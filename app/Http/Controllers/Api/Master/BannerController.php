<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Banner;
use App\Models\Advertisement;
use Validator;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $banner = Banner::select('id','banner_image')->where('status',1)->get();
        if(!$banner->isEmpty()){
            return response()->json(['success'=>true,'banner'=>$banner]);
        }
        else{
            return response()->json(['success'=>false,'message'=>'No record found']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function advertisement()
    {
        //
        $advertisements = Advertisement::select('id','picture')->where([['status',1],['type',1]])->get();
        if(!$advertisements->isEmpty()){
            return response()->json(['success'=>true,'advertisement'=>$advertisements]);
        }
        else{
            $advertisements = Advertisement::select('id','picture')->where([['status',1],['type',0]])->get();
            return response()->json(['success'=>true,'advertisement'=>$advertisements]);
        }

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
