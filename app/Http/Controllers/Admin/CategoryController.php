<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator,DB,Str,Session,Redirect;
use Response,Crypt;
use App\Models\Category;
use App\Models\City;
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
        $categories = Category::with('categoryCity.city')->where('status',1)->paginate();
        $cities = City::where([['state_id',3],['status',1]])->get();
        return view('admin.category.index',compact('categories','cities'));
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
            'name' => 'required',
            'banner_image' => 'required|mimes:jpeg,jpg,png'
        ]);
        if ($validator->fails()) return Redirect::back()->withErrors($validator)->withInput();

        if ($request->hasFile('banner_image')) {
            try {
                $path = public_path().'/vendor/images/category/';
                $imageName = date('dmyhis') . 'category.' . $request->file('banner_image')->getClientOriginalExtension();
                //dd($imageName);
                $request->file('banner_image')->move($path, $imageName);
                $data['banner_image'] = url('/public').'/vendor/images/category/' . $imageName;
            } catch (\Exception $e) {
                dd($e);
                return Redirect::back()->with('message', $e->getMessage());
            }
        }
        DB::beginTransaction();
        try {
            $data['name'] = $request->name;
            //dd($data);
            if($category = Category::create($data)){
              foreach($request->city_id as $value){
                $category->categoryCity()->create([
                    'city_id' => $value
                ]);
                DB::commit();
              }
                return Redirect::route('admin.category.index')->with('success','Category added successfully');
            }
        }
        catch (Exception $e) {
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
        $cities = City::where([['state_id',3],['status',1]])->get();
        return view('admin.category.edit',compact('category','cities'));
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
        $id = Crypt::decrypt($id);
        $category = Category::findOrFail($id)->delete();
        $category->categoryCity()->delete();
        Session::flash('error', 'Deleted');
        return back();
    }
}
