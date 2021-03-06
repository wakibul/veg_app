<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Customer;
class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'device_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $coupon = Coupon::where('is_active',1)->get();
        if(auth('api')->user()->device_id == $request->device_id){
            if(auth('api')->user()->free_offer == 0)
            $coupon = Coupon::where('is_active',1)->where('coupon_type','!=','first_offer')->get();
        }

        if(!$coupon->isEmpty()){
            return response()->json(['success'=>true,'coupon'=>$coupon]);
        }
        return response()->json(['success'=>false,'message'=>'No coupon found']);
    }


    public function applyCoupon(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'coupon_id' => 'required',
            'price'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $coupon_id = $request->coupon_id;
        $price = $request->price;
        $coupon = Coupon::where([['id',$coupon_id],['is_active',1]])->first();
        if($coupon){
            $user_id    = auth('api')->user()->id;
            $orders = Order::where([['user_id',$user_id],['coupon_id',$coupon->id]])->count();
            if($orders >= $coupon->max_coupon_use){
                return response()->json(['success'=>false,'error'=>'You have used this coupon maximum times']);
            }
            $minimun_amount = $coupon->minimun_amount;
            if($coupon->valid_to <= date('Y-m-d')){
                return response()->json(['success'=>false,'error'=>'The offer is expired']);
            }
            if($minimun_amount>$price){
                return response()->json(['success'=>false,'error'=>'Minimum amount should be'.$minimun_amount]);
            }
            if($coupon->coupon_in == 1){
                $reduced_amount = floatval($price)*(floatval($coupon->coupon_value)/100);
                $discount_price = floatval($price)-floatval($reduced_amount);
            }
            elseif($coupon->coupon_in == 2){
                 $reduced_amount = floatval($coupon->coupon_value);
                 $discount_price = floatval($price)-floatval($reduced_amount);
            }
        $firstCoupon= Coupon::where([['id',$coupon_id],['is_active',1],['coupon_type','first_offer']])->first();
        if($firstCoupon)
        {
            if(auth('api')->user()->free_offer_valid_to < date('Y-m-d')){
                return response()->json(['success'=>false,'error'=>'The offer is expired']);
            }
            if(auth('api')->user()->free_offer == 0){
                //Customer::where('id',auth('api')->user()->id)->decrement('free_offer');
                return response()->json(['success'=>false,'error'=>'The offer is not applicable now']);
            }


        }
            return response()->json(['success'=>true,'original_price'=>$price,'reduced_amount'=>round($reduced_amount),'discount_price'=>round($discount_price),'message'=>'Coupon applied successfull']);
        }
        return response()->json(['success'=>false,'error'=>'Coupon not found']);
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
