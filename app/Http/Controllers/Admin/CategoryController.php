<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use Crypt;
use DB;
use Illuminate\Http\Request;
use Redirect;
use Response;
use Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        //dd(public_path());
        $categories = Category::with('categoryCity.city')->paginate();
        $cities = City::where([['state_id', 3], ['status', 1]])->get();
        return view('admin.category.create', compact('categories', 'cities'));
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


        DB::beginTransaction();
        try {
            $this->validate($request, [
                'name' => 'required',
                'image' => 'required|mimes:jpeg,jpg,png|',
            ]);

            $path = public_path() . '/images/categories/';
            $imageName = date('dmyhis') . 'category_image.' . $request->file('image')->getClientOriginalExtension();

            $request->file('image')->move($path, $imageName);
            $data = [
                'banner_image' => url('/public') . '/images/categories/' . $imageName,
                'name'=>$request->name,

            ];


            //dd($data);
            if ($category = Category::create($data)) {
                foreach ($request->city_id as $value) {
                    $category->categoryCity()->create([
                        'city_id' => $value,
                    ]);
                    DB::commit();
                }
                return Redirect::route('admin.category.index')->with('success', 'Category added successfully');
            }
        } catch (Exception $e) {
            DB::rollback();
            dd($e);
            Session::flash('error', 'Something Went Wrong');
            return back();
        }
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
        $id = Crypt::decrypt($id);
        $category = Category::with('categoryCity.city')->findOrFail($id);
        $cities = City::where([['state_id', 3], ['status', 1]])->get();
        return view('admin.category.edit', compact('category', 'cities'));
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
    public function status($id)
    {

        $id = Crypt::decrypt($id);
        $category = Category::find($id);

        if ($category->status == 1) {
            $status = 0;
        } else {
            $status = 1;

        }

        $category->update(['status' => $status]);
        $category->save();
        return Redirect::route('admin.category.index')->with('success', 'Category Status Updated successfully');

    }
    public function destroy($id)
    {
        //
        $id = Crypt::decrypt($id);
        $category = Category::findOrFail($id)->delete();
        $category->categoryCity()->delete();
        Session::flash('error', 'Deleted');
        return back();
    }
}
