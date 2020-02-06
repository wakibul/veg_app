<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CancellationReason;
use App\Models\Order;
use App\Models\OrderTransaction;
use Validator,DB;
class CancellationController extends Controller
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


    public function reason()
    {
        //
        $reason = CancellationReason::select('id','reason')->where('status',1)->get();
        if(!$reason->isEmpty()){
            return response()->json(['success'=>true,'reason'=>$reason]);
        }
        else
        return response()->json(['success'=>false,'error'=>'No reason found']);
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
            'order_id' => 'required|numeric',
            'cancellation_reason' => 'required'
        ]);
        if($validator->fails())
            return response()->json(['success'=>false,'error'=>$validator->errors()]);
        $cancellation_reason = $request->cancellation_reason;
        DB::beginTransaction();
        try{
            $order = Order::findOrFail($request->order_id)->update(['status'=>'3','cancellation_reason'=>$cancellation_reason]);
            $order->orderTransaction()->update(['status'=>'3']);
        }
        catch(\Exeception $e){
            DB::rollback();
            return response()->json(['success'=>false,'error'=>$e->getMessage()]);
        }
        DB::commit();
        return response()->json(['success'=>true,'message'=>'Order Cancelled successfully']);

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
