<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class reportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::query();
        $orders = $this->filter($orders)->paginate(10);
        $total_order = $orders->count();
        $total_delivery = $orders->where('status', 2)->count();
        $total_cancel = $orders->where('status', 4)->count();

        return view('admin.report.index', compact('orders', 'total_order', 'total_delivery', 'total_cancel'));
    }
    public function filter($orders)
    {
        $orders->when(request("order_confirm_id"), function ($query) {
            $query->where('order_confirm_id', request('order_confirm_id'));
        });

        $orders->when(request("status"), function ($query) {
            $query->where('status', request('status'));
        });

        $orders->when(request('from_date'), function ($query) {
            $query->whereDate('created_at', '>=', request('from_date'));
        });
        $orders->when(request('to_date'), function ($query) {
            $query->whereDate('created_at', '<=', request('to_date'));
        });

        return $orders;
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
}
