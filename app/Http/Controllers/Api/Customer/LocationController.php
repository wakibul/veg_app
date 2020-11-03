<?php

namespace App\Http\Controllers\Api\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use App\Models\Customer;
use App\Models\CustomerAddress;
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
    public function addressStore(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'address_type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'house_no' => 'required',
            'landmark' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        $data['customer_id'] = auth('api')->user()->id;
        $data['address_type'] = $request->address_type;
        $data['latitude'] = $request->latitude;
        $data['longitude'] = $request->longitude;
        $data['house_no'] = $request->house_no;
        $data['landmark'] = $request->landmark;
        $data['address'] = $request->address;
        DB::beginTransaction();
        try{
            CustomerAddress::updateOrCreate($data);
        }
        catch(\Exception $e){
            return response()->json(['success'=>false,'error'=>'Address can not be updated','er'=>$e->getMessage()]);
        }
        DB::commit();
        $customer = CustomerAddress::where('status',1)->where('customer_id',auth('api')->user()->id)->get();
        return response()->json(['success'=>true,'data'=>$customer]);

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addressIndex()
    {
        //
        $customers = CustomerAddress::where('status',1)->where('customer_id',auth('api')->user()->id)->get();
        if(!$customers->isEmpty()){
            return response()->json(['success'=>true,'data'=>$customers]);
        }
        else
        return response()->json(['success'=>false]);

    }

    public function addressUpdate(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'house_no' => 'required',
            'landmark' => 'required',
            'address' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        DB::beginTransaction();
        try{
            CustomerAddress::where('id',$request->id)->update(['latitude'=>$request->latitude,
            'longitude'=>$request->longitude,'house_no'=>$request->house_no,
            'house_no'=>$request->house_no,'landmark'=>$request->landmark,
            'address'=>$request->address
            ]);
        }
        catch(\Exception $e){
            return response()->json(['success'=>false,'error'=>'Address can not be updated','er'=>$e->getMessage()]);
        }
        DB::commit();
        $customer = CustomerAddress::where('status',1)->get();
        return response()->json(['success'=>true,'data'=>$customer]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function addressDelete(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        }
        DB::beginTransaction();
        try{
           CustomerAddress::where('id',$request->id)->delete();
        }
        catch(\Exception $e){
            return response()->json(['success'=>false,'error'=>'something went wrong','er'=>$e->getMessage()]);
        }
        DB::commit();
        $customer = CustomerAddress::where('status',1)->get();
        return response()->json(['success'=>true,'data'=>$customer]);

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
