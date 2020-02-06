<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::paginate(10);

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
        $order->update(['status' => 3]);
        $order->save();
        return redirect()->back();

    }
    public function closeOrder($order_id)
    {
        $orderId = decrypt($order_id);
        $order = Order::find($orderId);
        $order->update(['status' => 2]);
        $order->save();
        return redirect()->back();

    }
    public function assignEmployee(Request $request)
    {

        foreach ($request->order_checks as $key => $order) {
            $order = Order::find($order);
            $data = ['delivery_boy_id' => $request->employee_id,

            ];
            $order->update($data);
            $order->save();

        }
        return redirect()->back();

    }
}
