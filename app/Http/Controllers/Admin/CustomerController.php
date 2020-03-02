<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\NotificationDetail;
use Illuminate\Http\Request;
use Str;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::paginate(10);
        return view('admin.customer.index', compact('customers'));

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
    public function notification(Request $request)
    {
        if ($request->customer_checks == null) {
            return redirect()->back()->with('error', 'Please select AtLeast One Customer  .');

        } else {
            $data = [
                'uuid' => (String) Str::uuid(),
                'notification_msg' => $request->msg,
            ];
            $notification = Notification::create($data);

            foreach ($request->customer_checks as $key => $customer_check) {
                $notification_details = [

                    'notification_id' => $notification->id,
                    'customer_id' => $customer_check,
                ];

                $notification_details = NotificationDetail::create($notification_details);

                $customer = Customer::find($customer_check);
                $customer_no = $customer->mobile;
                $sms = sendNewSMS($customer_no, $request->msg);
            }

        }

        return redirect()->back()->with('success', 'Notification Send Successfully.');

    }
    public function destroy($id)
    {
        //
    }
}
