<?php

namespace App\Http\Controllers\Api\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Employee;
use App\Models\Order;
use Dotenv\Validator as DotenvValidator;
use JWTFactory;
use JWTAuth,JWTException;
use Validator,DB,Str;
use Response;
class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        //
            $validator = Validator::make($request->all(), [
                'mobile'=> 'required|numeric',
                'password'=> 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success'=>false,'error'=>$validator->errors()]);
            }
            $credentials = $request->only('mobile', 'password');
            $credentials['status'] = 1;
            try {
                // attempt to verify the credentials and create a token for the user
                if (! $token = auth('employee')->attempt($credentials)) {
                    return response()->json(['success' => false, 'error' => 'Your username or password is incorrect']);
                }
            } catch (JWTException $e) {
                // something went wrong whilst attempting to encode the token
                return response()->json(['success' => false, 'error' => $e->getMessage()]);
            }
            // all good so return the token
            return response()->json(['success' => true, 'token' => $token, 'employee_details' => [
                        'id'            => auth('employee')->user()->id,
                        'name'          => auth('employee')->user()->name,
                        'mobile'         => auth('employee')->user()->mobile,
                        'device_id'         => auth('employee')->user()->device_id,
                        'updated_balance' => auth('employee')->user()->updated_balance
                    ] ]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function user()
    {
        //
        $employee = Employee::findOrFail(auth('employee')->user()->id)->first();
        return response()->json(['success'=>true,'employee_details'=>$employee]);
    }

    public function otp(Request $request)
    {
        //
        $validator = Validator::make($request->all(),[
            'order_id'=>'required'
        ]);
        if($validator->fails())
        return response()->json(['success'=>false,'error'=>$validator->errors()]);
        DB::beginTransaction();
        try{
        $otp = mt_rand(100000, 999999);
        $order = Order::findOrFail($request->order_id)->first();
        $otp_order = Order::where('id',$order->id)->update(['otp'=>$otp]);
		sendNewSMS($order->recipient_no,"Your otp verification code is ".$otp);
        }
        catch(\Exception $e){
            DB::rollback();
            return response()->json(['success'=>false,'message'=>'Something went wrong']);
        }
        DB::commit();
        return response()->json(['success'=>true,'Otp sent successfully']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function currentOrders(Request $request)
    {
        //
        $orders = Order::select('id','order_confirm_id','recipient_no','latitude','longitude','address','time_slot_id','delivery_date','total_price_with_tax','status')->with('timeSlot:id,slot')->where('employee_id',auth('employee')->user()->id)->where('status',1)->get();
        if(!$orders->isEmpty())
            return response()->json(['success'=>true,'orders'=>$orders]);
        else
            return response()->json(['success'=>false,'message'=>'No current order issued']);
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
