<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
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

        return view('admin.coupon.create', compact('coupons'));

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
        $id = Crypt::decrypt($id);
        $coupon = Coupon::find($id);

        $coupons = Coupon::paginate(10);

        return view('admin.coupon.edit', compact('coupon', 'coupons'));

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
