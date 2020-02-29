<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryCity;
use App\Models\Category;
use Validator;
class CategoryController extends Controller
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
            'city_id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
		}
        $category = CategoryCity::with('category')->where([['city_id',$request->city_id],['status',1]])->get();
        if ($category->isNotEmpty()) {
            return response()->json(['success'=>true,'category_details'=>$category]);
        }
        else
            return response()->json(['success'=>false,'error'=>['message'=>'No category found']]);


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function SubCategory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric'
        ]);
        if ($validator->fails()) {
			return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $subCategory = Category::where([['parent_id',$request->id],['status',1]])->get();
        if ($subCategory->isNotEmpty()) {
            return response()->json(['success'=>true,'category_details'=>$subCategory]);
        }
        else
            return response()->json(['success'=>false,'error'=>['message'=>'No category found']]);


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
