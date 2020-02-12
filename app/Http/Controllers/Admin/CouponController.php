<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\MiscellaneousMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Redirect;
use Validator;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = Coupon::paginate(10);
        $miscellaneous_masters = MiscellaneousMaster::get();

        return view('admin.coupon.create', compact('coupons', 'miscellaneous_masters'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $current_date = date("Y-m-d");
        $days = $request->valid_to;
        $date_sum = date('Y-m-d', strtotime($current_date . ' + ' . $days . ' days'));

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'coupon_code' => 'required',
            'coupon_in' => 'required',
            'coupon_value' => 'required',
            'max_coupon_use' => 'required',
            'coupon_type' => 'required',
            'valid_to' => 'required',
            'minimun_amount' => 'required',
            'is_active' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        try {
            $data = ['name' => $request->name,
                'coupon_code' => $request->coupon_code,
                'coupon_in' => $request->coupon_in,
                'coupon_value' => $request->coupon_value,
                'coupon_type' => $request->coupon_type,
                'max_coupon_use' => $request->max_coupon_use,
                'valid_to' => $date_sum,
                'minimun_amount' => $request->minimun_amount,
                'is_active' => $request->is_active,

            ];
            $coupon = Coupon::create($data);

            return Redirect::route('admin.coupon.index')->with('success', 'Coupon Added successfully');

        } catch (Exception $e) {
            DB::rollback();
            dd($e);

            return back()->with('error', 'Something Went Wrong');

        }

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

        $id = Crypt::decrypt($id);
        $coupon = Coupon::find($id);
        $create_date = dateFormat($coupon->created_at, 'Y-m-d');
        $up_to = dateFormat($coupon->valid_to, 'Y-m-d');

        $diff_in_day = dateDiff($create_date, $up_to, "Day");

        $miscellaneous_masters = MiscellaneousMaster::get();

        $coupons = Coupon::paginate(10);

        return view('admin.coupon.edit', compact('coupon', 'coupons', 'miscellaneous_masters'));

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

        $id = Crypt::decrypt($id);
        $coupon = Coupon::find($id);
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'coupon_code' => 'required',
            'coupon_in' => 'required',
            'coupon_value' => 'required',

            'valid_to' => 'required',
            'minimun_amount' => 'required',
            'is_active' => 'required',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }
        try {
            $data = ['name' => $request->name,
                'coupon_code' => $request->coupon_code,
                'coupon_in' => $request->coupon_in,
                'coupon_value' => $request->coupon_value,
                'coupon_type' => 'first_offer',
                'valid_to' => $request->valid_to,
                'minimun_amount' => $request->minimun_amount,
                'is_active' => $request->is_active,

            ];
            $coupon->update($data);
            $coupon->save();
            return Redirect::route('admin.coupon.index')->with('success', 'Coupon updated successfully');

        } catch (Exception $e) {
            DB::rollback();
            dd($e);

            return back()->with('error', 'Something Went Wrong');

        }

    }
    public function status($id)
    {
        $id = Crypt::decrypt($id);
        $coupon = Coupon::find($id);

        if ($coupon->is_active == 1) {
            $status = 0;
        } else {
            $status = 1;

        }

        $coupon->update(['is_active' => $status]);
        $coupon->save();
        return Redirect::route('admin.coupon.index')->with('success', 'Coupon Status Updated successfully');

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
