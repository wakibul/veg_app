<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\packageMaster;
use App\Models\Product;
use App\Models\ProductPackage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::query();

        $products = $this->filter($products)->paginate(15);

        $categories = Category::get();

        return view('admin.product.index', compact('products', 'categories'));
    }
    public function filter($products)
    {

        $products->when(request("name"), function ($query) {
            $query->where('name', request('name'));
        });
        $products->when(request("category_id"), function ($query) {
            $query->where('category_id', request('category_id'));
        });
        return $products;

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::get();
        $product = collect();

        $package_masters = packageMaster::get();

        return view('admin.product.create', compact('categories', 'package_masters'));

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'small_picture' => 'required|mimes:jpeg,jpg,png',
            'large_picture' => 'required|mimes:jpeg,jpg,png',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $path = public_path() . '/images/product/small';
        $imageName = date('dmyhis') . 'product.' . $request->file('small_picture')->getClientOriginalExtension();

        $request->file('small_picture')->move($path, $imageName);
        $imagePath = public_path() . '/images/product/large';
        $largeImageName = date('dmyhis') . 'product.' . $request->file('large_picture')->getClientOriginalExtension();
        $request->file('large_picture')->move($imagePath, $largeImageName);
        if ($request->is_subscribe == 0) {
            $is_subscribed = 0;
            $is_product = 1;

        } else {
            $is_subscribed = 1;
            $is_product = 0;

        }
        $request->merge([
            "is_available" => true,
        ]);

        DB::beginTransaction();
        $data = [

            'name' => $request->name,
            'details' => $request->details,
            'unit_desc' => $request->unit_desc,
            'category_id' => $request->category_id,
            'small_picture' => url('/public') . '/images/product/small/' . $imageName,

            'large_picture' => url('/public') . '/images/product/large/' . $largeImageName,

            'status' => $request->productstatus,
            'is_available' => $request->is_available,
            'is_subscribed' => $is_subscribed,
            'is_product' => $is_product,

        ];
        $product = Product::create($data);

        $default_key = 0;
        foreach ($request->default_packages as $key => $value) {
            if ($value) {
                $default_key = $value;
            }
        }
        // dd($request->default_packages);

        if ($product) {
            $product_packages_array = [];
            $product_packages = [];

            foreach ($request->category_ids as $key => $category_id) {

                $product_packages_data = [
                    'skucode' => $request->skucodes[$key],
                    'product_id' => $product->id,
                    'package_masters_id' => $request->category_ids[$key],
                    'market_price' => $request->market_prices[$key],
                    'offer_price' => $request->offer_prices[$key],
                    'offer_percentage' => $request->offer_percentages[$key],
                    'is_offer' => $request->is_offers[$key],
                    'status' => $request->status[$key],

                    'created_at' => getCurrentDate(),
                    'updated_at' => getCurrentDate(),
                ];
                $product_packages_array[] = $product_packages_data;
                $product_packages[] = ProductPackage::create($product_packages_data);
            }

            $default_id = $product_packages[$default_key]->id;
            $product->default_package = $default_id;
            $product->save();

        }
        DB::commit();
        return Redirect::back()->with('success', 'Product added successfully');

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
        $id = Crypt::decrypt($id);
        $categories = Category::get();
        $package_masters = packageMaster::get();

        $product = Product::with(["productPackage"])->find($id);

        return view('admin.product.edit', compact('product', 'categories', 'package_masters'));

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


        if (($request->file('small_picture') != null)) {

            $validator = Validator::make($request->all(), [

                'small_picture' => 'mimes:jpeg,jpg,png|dimensions:min_width=320,min_height=200',

            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

        }
        if (($request->file('large_picture') != null)) {
            $validator = Validator::make($request->all(), [

                'large_picture' => 'required|mimes:jpeg,jpg,png|dimensions:min_width=640,min_height=400',

            ]);
            if ($validator->fails()) {
                return Redirect::back()->withErrors($validator)->withInput();
            }

        }

        $id = Crypt::decrypt($id);
        $product = Product::find($id);

        if (($request->file('small_picture') != null)) {
            $path = public_path() . '/images/product/small';
            $imageName = date('dmyhis') . 'product.' . $request->file('small_picture')->getClientOriginalExtension();
            $request->file('small_picture')->move($path, $imageName);

        }
        if (($request->file('large_picture') != null)) {
            $imagePath = public_path() . '/images/product/large';
            $largeImageName = date('dmyhis') . 'product.' . $request->file('large_picture')->getClientOriginalExtension();
            $request->file('large_picture')->move($imagePath, $largeImageName);

        }

        if ($request->is_subscribe == 0) {
            $is_subscribed = 0;
            $is_product = 1;

        } else {
            $is_subscribed = 1;
            $is_product = 0;

        }


        if (($request->file('small_picture') != null)) {
            $small_picture = url('/public') . '/images/product/small/' . $imageName;
        } else {
            $small_picture = $product->small_picture;
        }
        if (($request->file('large_picture') != null)) {
            $large_picture = url('/public') . '/images/product/large/' . $largeImageName;
        } else {
            $large_picture = $product->large_picture;
        }
        DB::beginTransaction();

        $data = [

            'name' => $request->name,
            'details' => $request->details,
            'unit_desc' => $request->unit_desc,
            'category_id' => $request->category_id,
            'small_picture' => $small_picture,

            'large_picture' => $large_picture,

            'status' => $request->productstatus,
            'is_available' => $request->is_available,
            'is_subscribed' => $is_subscribed,
            'is_product' => $is_product,

        ];

        $product->update($data);
        $product->productPackage()->delete();

        $default_key = 0;

        if ($request->default_packages) {
            foreach ($request->default_packages as $key => $value) {
                if ($value) {
                    $default_key = $value;
                }
            }
        }


        if ($product) {
            $product_packages_array = [];
            $product_packages = [];
            foreach ($request->category_ids as $key => $category_id) {
                $product_packages_data = [
                    'skucode' => $request->skucodes[$key],
                    'product_id' => $id,
                    'package_masters_id' => $request->category_ids[$key],
                    'market_price' => $request->market_prices[$key],
                    'offer_price' => $request->offer_prices[$key],
                    'offer_percentage' => $request->offer_percentages[$key],
                    'is_offer' => $request->is_offers[$key],
                    'status' => $request->status[$key],
                    'created_at' => getCurrentDate(),
                    'updated_at' => getCurrentDate(),
                ];

                $product_packages_array[] = $product_packages_data;
                $product_packages[] = ProductPackage::create($product_packages_data);

            }

            $product = Product::find($id);
            $default_id = $product_packages[$default_key]->id;
            $product->default_package = $default_id;
            $product->save();

        }
        DB::commit();
        return Redirect::back()->with('success', 'Product update successfully');

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $id = Crypt::decrypt($id);
        $product = Product::findOrFail($id);
        $cart = Cart::where('product_id', $product->id)->delete();
        $product->delete();

        return back()->with('error', 'Product details Deleted Successfully');

    }
}
