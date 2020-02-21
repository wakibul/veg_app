<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductPackage;
use App\Models\PackageMaster;
use App\Models\MaxMin;
use Validator;
class ProductController extends Controller
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
			'category_id'=> 'required|numeric'
		]);
		if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
		}
        $products = Product::select('id','name','details','large_picture','small_picture','is_available','default_package')->with('productPackage:id,product_id,package_masters_id,market_price,offer_price,is_offer,offer_percentage','productPackage.packageMaster:id,name')->where([['status',1],['category_id',$request->category_id],['is_product',1]])->orderBy('name')->paginate(10);
        if(!$products->isEmpty()){
            $status = true;
            $max_price = MaxMin::where('id',$request->category_id)->max('market_price');
            $min = MaxMin::where('id',$request->category_id)->min('market_price');
        }
        else
            $status = false;

        return response()->json(['success'=>$status,'max_price'=>$max_price,'min_price'=>$min,'product_details'=>$products]);
    }

    public function latest()
    {
        //
        $products = Product::select('id','name','details','large_picture','small_picture','is_available','default_package')->with('productPackage:id,product_id,package_masters_id,market_price,offer_price,is_offer,offer_percentage','productPackage.packageMaster:id,name')->where([['status',1],['is_product',1]])->latest()->paginate(10);
        $max_price = MaxMin::max('market_price');
        $min = MaxMin::min('market_price');
        if(!$products->isEmpty())
            $status = true;
        else
            $status = false;

        return response()->json(['success'=>$status,'max_price'=>$max_price,'min_price'=>$min,'product_details'=>$products]);
    }

    public function popular()
    {
        //
        $products = Product::select('id','name','details','large_picture','small_picture','is_available','default_package')->with('productPackage:id,product_id,package_masters_id,market_price,offer_price,is_offer,offer_percentage','productPackage.packageMaster:id,name')->where([['status',1],['is_product',1]])->inRandomOrder()->paginate(10);
        if(!$products->isEmpty())
            $status = true;
        else
            $status = false;

        return response()->json(['success'=>$status,'product_details'=>$products]);
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
