<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\EmployeeTransaction;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;




class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('status', '!=', 3)->paginate(25);

        return view('admin.order.index', compact('orders'));
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
    public function acceptOrder($order_id)
    {
        $orderId = decrypt($order_id);
        $order = Order::find($orderId);
        $order_confirm_id = getOrderConfirmId($orderId);
        $order->update(['status' => 1, 'confirmation_time' => getCurrentDate(), 'order_confirm_id' => $order_confirm_id]);
        $order = $order->save();
        $order_details = Order::find($orderId);
        $token = $order_details->fcm_token;
        $optionBuilder = new OptionsBuilder();
        $optionBuilder->setTimeToLive(60 * 20);

        $notificationBuilder = new PayloadNotificationBuilder("Today's Report");
        $notificationBuilder->setBody("Thank you,Your order Has been Received with Order No: {$order_details->order_confirm_id}")
            ->setSound('default');

        $dataBuilder = new PayloadDataBuilder();
        $dataBuilder->addData(['a_data' => 'my_data']);

        $option = $optionBuilder->build();
        $notification = $notificationBuilder->build();
        $data = $dataBuilder->build();
        $sendMsg=sendNewSMS($order->customer->mobile,"Thank you,Your order Has been Received with Order No: {$order_details->order_confirm_id}");
        $customerMessage = FCM::sendTo($token, $option, $notification, $data);



        return redirect()->back();

    }
    public function rejectOrder(Request $request,$order_id)
    {

        $data=[
            "cancellation_reason"=>$request->reason,
            'status' => 3,

        ];
        $orderId = decrypt($order_id);
        $order = Order::find($orderId);
        $order->update($data);
        $order->save();
        if($request->send_notification==1){
            $user_id=$order->user_id;
            $customer=Customer::find( $user_id);
            $mobile=$customer->mobile;
            $sendMsg=sendNewSMS($mobile,$request->reason);

        }
        return redirect()->back()->with('error', 'Order Cancel');

    }
    public function closeOrder($order_id)
    {
        $orderId = decrypt($order_id);
        $order = Order::find($orderId);
        $order->update(['status' => 2]);
        $order->save();
        return redirect()->back()->with('success', 'Order Completed Successfully');

    }
    public function assignEmployee(Request $request)
    {

        foreach ($request->order_checks as $key => $order) {
            $order = Order::find($order);
            $data = ['employee_id' => $request->employee_id,
            ];
            $order->update($data);
            $order->save();

        }
        //foreach ($request->order_checks as $key => $order) {
        //    $order = Order::find($order);
        //    $data = ['order_id' => $order->id,
        //        'employee_id' => $request->employee_id,
         //       'amount' => $order->total_price_with_tax,
         //   ];
         //   $employeeTransaction = EmployeeTransaction::create($data);
        //}
       // $amount = 0;

        //foreach ($request->order_checks as $key => $order) {

         //   $order = Order::find($order);
          //  $amount = $amount + $order->total_price_with_tax;

        //}

        //$employee = Employee::find($request->employee_id);
        // $data=[
        // 'updated_balance'=>$employee->updated_balance+$amount,

        // ];
        // $employee->update($data);
        // $employee->save();

        $employee_id = $request->employee_id;
        $this->sendAssignNotification($employee_id, $request->order_checks);

        return redirect()->back()->with('success', 'Delivery Boy assign successfully.');

    }
    public function sendAssignNotification($employee_id)
    {
        $employee = Employee::find($employee_id);
        // $employee = $employee->name;
        $title = "New Order";
        $customer_message = "New Order has arrived";
        $sendMsg=sendNewSMS($employee->mobile,$customer_message);
        $notification = sendMobilePushNotification($customer_message, $title, [$employee->fcm_token], ["employee_id" => $employee->id, "notification_code" => 101], 101, true);
        Log::debug($notification);

        return true;

    }
}
