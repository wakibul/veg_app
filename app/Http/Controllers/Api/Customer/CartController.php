<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,DB,Str;
use Response;
use App\Models\Product;
use App\Models\Cart;
use App\Models\ProductPackage;
use App\Models\PackageMaster;
use App\Models\Pincode;
class CartController extends Controller
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
        $cart = Cart::select('id','product_id','product_package_id','quantity','user_id','price')->with('product:id,name,details,category_id,small_picture','product.productPackage:id,product_id,package_masters_id,market_price,offer_price,offer_percentage,is_offer','product.productPackage.packageMaster:id,name')->where('user_id',auth('api')->user()->id)->get();
        $totalProduct = Cart::where('user_id',$user_id)->count();
        if(!$cart->isEmpty()){
            return response()->json(['success'=>true,'count'=>$totalProduct,'cart_items'=>$cart]);
        }
        else{
            return response()->json(['success'=>false,'error'=>'Cart is empty']);
        }

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
            'product_id' => 'required|numeric',
            'product_package_id'=> 'required|numeric',
			'quantity'=> 'required|numeric',
			'price'=>'required'
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $product_id = $request->product_id;
        $product_package_id = $request->product_package_id;
        $quantity = $request->quantity;
        $user_id = auth('api')->user()->id;
        $price = (string)$request->price * $quantity;
        try{
            $product = Product::where([['id',$product_id],['status',1]])->first();
            if($product == null){
                return response()->json(['success'=>false,'error'=>'Product is not available']);
            }

            $package_master = PackageMaster::where([['id',$product_package_id],['status',1]])->first();
            if($package_master == null){
                return response()->json(['success'=>false,'error'=>'Package is not available']);
            }
            $cart = Cart::where([['user_id',$user_id],['product_id',$product_id],['product_package_id',$product_package_id]])->first();
            if($cart != null){
                $total_quantity = intval($cart->quantity)+intval($quantity);
                $total_price = intval($cart->price)+intval($price);
            }
            else{
                $total_quantity = intval($quantity);
                $total_price =   intval($price);
            }
            $where = ['product_id'=>$product_id,'product_package_id'=>$product_package_id,'user_id'=>$user_id];
            $data['quantity'] = $total_quantity;
            $data['price'] = floatval($total_price);
            Cart::updateOrCreate($where,$data);
            $totalProduct = Cart::where('user_id',$user_id)->count();
            $cart_items = Cart::select('id','product_id','product_package_id','quantity','user_id','price')->with('product:id,name,details,category_id,small_picture','product.productPackage:id,product_id,package_masters_id,market_price,offer_price,offer_percentage,is_offer','product.productPackage.packageMaster:id,name')->where('user_id',$user_id)->get();
            return response()->json(['success'=>true,'count'=>$totalProduct,'cart_items'=>$cart_items]);

        }
        catch (\Exception $e) {
                return response()->json(['success'=>false,'error'=>$e->getMessage()]);
            }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
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
    public function destroy(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|numeric',
            'product_package_id'=> 'required|numeric'
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $product_id = $request->product_id;
        $product_package_id = $request->product_package_id;
        $user_id = auth('api')->user()->id;
        try{
            Cart::where([['user_id',$user_id],['product_id',$product_id],['product_package_id',$product_package_id]])->delete();
            $cart_items = Cart::select('id','product_id','product_package_id','quantity','user_id','price')->with('product:id,name,details,category_id,small_picture','productPackage:id,product_id,package_masters_id,market_price,offer_price,offer_percentage,is_offer','productPackage.packageMaster:id,name')->where('user_id',$user_id)->get();
            return response()->json(['success'=>true,'message'=>'Successfully Removed','cart_items'=>$cart_items]);
        }
        catch (\Exception $e){
            return response()->json(['success'=>false,'error'=>$e->getMessage()]);
        }

    }
}
