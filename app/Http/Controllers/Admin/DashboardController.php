<?php

namespace App\Http\Controllers\Admin;

use App\Exports\BushAllIndexExport;
use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Excel;
use DB;
use App\Models\Power;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index( Request $request)
    {
        $users[] = Auth::user();
        $users[] = Auth::guard()->user();
        $users[] = Auth::guard('admin')->user();
        $orders = Order::query();
        $orders = $this->filter($orders);

        $total_orders = Order::where('status','!=','3')->count();
        if((date('H:i:s')>='18:00:00' && date('H:i:s')<='23:59:59'))
            $date = date('Y-m-d', strtotime(' +1 day'));
        else
            $date = date('Y-m-d');

        $todays_order = Order::whereDate('delivery_date', '=', $date)->count();



        $orders = $orders->with(["orderTransactions.product", "coupon", "orderTransactions.productPackage.packageMaster"])->with('orderTransactions.product.productPackage.packageMaster')->where('status', '!=', 4)->orderBy('id', 'DESC');
        $employees = Employee::get();
        if ($request->get("export-excel") == '1') {
            return $this->filterExportReport($orders->get());
        }
        $orders = $orders->paginate(10);
        $employees = Employee::get();
           //dd($users);

        return view('admin.home', compact('orders', 'employees', 'total_orders','todays_order'));

    }
    public function filter($orders)
    {
        $orders->when(request("slot_id"), function ($query) {
            return $query->where("time_slot_id", request("slot_id"));
        });
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
        $orders->when(request("pincode"), function ($query) {
            $query->where('pincode', request('pincode'));
        });

        return $orders;
    }
    public function filterExportReport($orders)
    {


        return Excel::download(new BushAllIndexExport($orders), 'All-report.xlsx');
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

    public function power(Request $request)
    {
        //
        DB::beginTransaction();
        try{
            Power::where('id',1)->update(['status'=>$request->status]);
        }
        catch(\Exception $e){
            return response()->json(['suceess'=>false,'message'=>$e->getMessage()]);
        }
        DB::commit();
        return response()->json(['suceess'=>true,'message'=>'Power Changed']);
    }
}
