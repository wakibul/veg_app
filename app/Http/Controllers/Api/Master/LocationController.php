<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Customer;
use DB;
class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $customer = Customer::select('latitude','longitude','house_no','landmark','address')->findOrFail(auth('api')->user()->id);
        return response()->json(['success'=>true,'location'=>$customer]);

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
        $validator = Validator::make($request->all(),[
            'latitude' => 'required',
            'longitude' => 'required',
            'house_no' => 'required',
            'landmark' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $data['latitude'] = $request->latitude;
        $data['longitude'] = $request->longitude;
        $data['house_no'] = $request->house_no;
        $data['landmark'] = $request->landmark;
        $data['address'] = $request->address;
        DB::beginTransaction();
        try{
            Customer::where('id',auth('api')->user()->id)->update($data);
        }
        catch(\Exception $e){
            return response()->json(['success'=>false,'error'=>'Address can not be updated','er'=>$e->getMessage()]);
        }
        DB::commit();
        return response()->json(['success'=>true]);
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