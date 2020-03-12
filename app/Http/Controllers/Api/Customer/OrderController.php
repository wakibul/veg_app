<?php

namespace App\Http\Controllers\Api\Customer;

use App\Events\OrderPusherEvent;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderTransaction;
use App\Models\Cart;
use App\Models\DeliveryCharge;
use App\Models\Pincode;
use App\Models\TimeSlot;
use App\Models\Customer;
use App\Models\Coupon;
use Validator,DB;
class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user_id = auth('api')->user()->id;
        $orders = Order::select('id','order_confirm_id','otp','total_price_with_tax','time_slot_id','created_at','status')->with('timeSlot:id,slot','orderTransaction:id,order_id,quantity,product_id,product_package_id','orderTransaction.product:id,name','orderTransaction.productPackage:id,product_id,package_masters_id,market_price,offer_price,offer_percentage,is_offer','orderTransaction.productPackage.packageMaster:id,name')->where('user_id',$user_id)->orderBy('id','desc')->withTrashed()->paginate(30);
        if(!$orders->isEmpty())
            return response()->json(['success'=>true,'orders'=>$orders]);
        else
        return response()->json(['success'=>false,'message'=>'No record found']);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'recipient_no'=> 'required',
			'latitude'=> 'required',
            'longitude'=>'required',
            'address'=>'required',
            'pincode'=>'required',
            'city_id'=>'required',
            'time_slot_id'=>'required',
            'delivery_date'=>'required|date',
            'fcm_token' => 'required'
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $order_time = date("H:i:s");
        $user_id = auth('api')->user()->id;
        $totalPrice = Cart::where('user_id',$user_id)->sum('price');
        $carts = Cart::select('id','product_id','product_package_id','quantity','user_id','price')->with('product:id,name,details,category_id,small_picture','productPackage:id,product_id,package_masters_id,market_price,offer_price,offer_percentage,is_offer','productPackage.packageMaster:id,name')->where('user_id',$user_id)->get();
        $delivery_charges = DeliveryCharge::where('status',1)->first();
        $pincode = Pincode::where([['city_id',$request->city_id],['pincode',$request->pincode]])->first();
        if($pincode == null){
            return response()->json(['success'=>false,'error'=>'Sorry, unable to delivery in this pincode']);
        }

        if($totalPrice < $delivery_charges->maximum_amount){
            $charge_amount = $delivery_charges->charge_amount;
            $totalPrice = floatval($totalPrice)+floatval($delivery_charges->charge_amount);
        }
        else{
            $charge_amount = '0.00';
        }

        if($totalPrice < $delivery_charges->minimum_amount)
        {
            return response()->json(['success'=>false,'error'=>'The minimum  amount should be '.$delivery_charges->minimum_amount]);
        }

        $ordersCount = Order::where([['time_slot_id',$request->time_slot_id],['delivery_date',$request->delivery_date]])->count();
        if($ordersCount >= $delivery_charges->maximum_orders){
            return response()->json(['success'=>false,'error'=>'Maximum order limit is 50 items/day']);
        }

        $data  =  array();
        DB::beginTransaction();
        try{
            $data['user_id'] = auth('api')->user()->id;
            $data['order_time'] = date('H:i:s');
            $data['total_price'] = $totalPrice;
            $data['total_price_with_tax'] = $totalPrice;
            $data['recipient_no'] = $request->recipient_no;
            $data['latitude'] = $request->latitude;
            $data['longitude'] = $request->longitude;
            $data['address'] = $request->address;
            $data['pincode'] = $request->pincode;
            $data['coupon_id'] = $request->coupon_id;
            $data['time_slot_id'] = $request->time_slot_id;
            $data['delivery_date'] = $request->delivery_date;
            $data['delivery_charge'] = $charge_amount;
            $data['fcm_token'] = $request->fcm_token;

            if($order = Order::create($data)){
                event(new OrderPusherEvent($order));
                foreach($carts as $key=>$cart){
                    $orderTrans['order_id'] = $order->id;
                    $orderTrans['product_id'] = $cart->product_id;
                    $orderTrans['product_package_id'] = $cart->product_package_id;
                    $orderTrans['price'] = $cart->price;
                    $orderTrans['quantity'] = $cart->quantity;
                    OrderTransaction::create($orderTrans);
                }
                Cart::with('item')->where('user_id',$user_id)->delete();
                if($request->coupon_id != ''){
	                if($request->coupon_id == 1){
	                	if(auth('api')->user()->free_offer > 0){
	                		Customer::where('id',auth('api')->user()->id)->decrement('free_offer');
	                	}
	                }
            	}
                DB::commit();
                //$current_order = Order::with('orderTransactions.product')->find($order->id);
                return response()->json([
                    'success' => true,
                    'message' => 'Order placed successfully',
                    'data'    => Order::with('orderTransaction.product')->find($order->id)
                ]);
            }
        }
        catch(\Exception $e){
            \Log::error($e);
            DB::rollback();
            return response()->json(['success'=>false,'error'=>$e->getMessage()]);
        }
        // foreach($carts as $key=>$value){
        //     dd($value);
        // }

    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function address()
    {
        //
        $orders = Order::select('latitude','longitude','address','pincode')->where('user_id',auth('api')->user()->id)->get();
        if(!$orders->isEmpty()){
            return response()->json(['success'=>true,'address'=>$orders]);
        }
        else
            return response()->json(['success'=>false]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
