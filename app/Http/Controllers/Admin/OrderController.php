<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::where('status', '!=', 3)->paginate(10);

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
        $order_confirm_id = getOrderConfirmId();
        $order->update(['status' => 1, 'confirmation_time' => getCurrentDate(), 'order_confirm_id' => $order_confirm_id]);
        $order->save();
        return redirect()->back();

    }
    public function rejectOrder($order_id)
    {
        $orderId = decrypt($order_id);
        $order = Order::find($orderId);
        $order->update(['status' => 4]);
        $order->save();
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
            $data = ['employee_id' => $request->employee_id

            ];
            $order->update($data);
            $order->save();

        }
        $employee_id = $request->employee_id;
        $this->sendAssignNotification($employee_id, $request->order_checks);

        return redirect()->back()->with('success', 'Delivery Boy assign successfully.');

    }
    public function sendAssignNotification($employee_id, $orders)
    {
        $employee = Employee::find($employee_id);
        // $employee = $employee->name;
        $title = "Delivery Order Assigned ";
        $customer_message = "New Order Assigned";

        $notification = sendMobilePushNotification($customer_message, $title, [$employee->fcm_token], ["order_id" => $orders, "employee_id" => $employee->id], 101, true);
        Log::debug($notification);
/*         if ($booking->booked_service_provider) {
$booked_service_provider       = $booking->booked_service_provider->first()->service_provider;
$service_provider_title        = "Service Completed " . $booking->booking_no;
$service_provider_message      = "Customer is waiting for your confirmation.";
$service_provider_notification = sendMobilePushNotification($service_provider_message, $service_provider_title, [$booked_service_provider->api_key], ["booking_id" => $booking->id, "booking_no" => $booking->booking_no], 106);
Log::debug($service_provider_notification);
} */
        return true;

    }
}
