<?php

namespace App\Http\Controllers\Admin;

use App\Exports\CustomerAllExport;
use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Notification;
use App\Models\NotificationDetail;
use App\Models\Order;
use Crypt;
use Dompdf\Adapter\PDFLib;
use Excel;
use Illuminate\Http\Request;
use LaravelFCM\Facades\FCM;
use LaravelFCM\Message\OptionsBuilder;
use LaravelFCM\Message\PayloadDataBuilder;
use LaravelFCM\Message\PayloadNotificationBuilder;
use PDF;
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
        $customers = Customer::paginate(25);

        return view('admin.customer.index', compact('customers'));
    }
    public function verified()
    {
        $customers = Customer::where('fcm_token', '!=', null)->paginate(25);

        return view('admin.customer.verified', compact('customers'));
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
                'uuid'               => (string) Str::uuid(),
                'notification_title' => $request->notification_title,
                'notification_msg'   => $request->msg,
            ];

            $notification_data = Notification::create($data);

            foreach ($request->customer_checks as $key => $customer_check) {
                $notification_details = [

                    'notification_id' => $notification_data->id,
                    'customer_id'     => $customer_check,
                ];

                $notification_details = NotificationDetail::create($notification_details);

                $customer    = Customer::find($customer_check);
                $customer_no = $customer->mobile;

                try {
                    $token = $customer->fcm_token;
                } catch (\Exception $e) {
                    continue;
                    return back()->withError($e->getMessage())->withInput();
                }

                $optionBuilder = new OptionsBuilder();
                $optionBuilder->setTimeToLive(60 * 20);

                $notificationBuilder = new PayloadNotificationBuilder("$request->notification_title");
                $notificationBuilder->setBody("$request->msg")->setSound('default');

                $dataBuilder = new PayloadDataBuilder();
                $dataBuilder->addData(['a_data' => 'my_data']);

                $option       = $optionBuilder->build();
                $notification = $notificationBuilder->build();
                $data         = $dataBuilder->build();

                $customerMessage = FCM::sendTo($token, $option, $notification, $data);
            }
        }

        return redirect()->back()->with('success', 'Notification Send Successfully.');
    }
    public function view($customer_id)
    {
        $id       = Crypt::decrypt($customer_id);
        $customer = Customer::find($id);

        $orders = $customer->orders()->where('status', 2)->orderBy('created_at', 'desc')->get();

        //dd($orders);
        return view('admin.customer.view', compact('customer', 'orders'));
    }
    public function exportUser($customer_id)
    {
        $id = Crypt::decrypt($customer_id);

        $customers = Customer::where('id', $id)->get();
        //dd($customers);

        return Excel::download(new CustomerAllExport($customers), 'All-Customer-report.xlsx');
    }
    public function export()
    {
        $customers = Customer::get();

        return Excel::download(new CustomerAllExport($customers), 'All-Customer-report.xlsx');
    }
    public function verifiedCustomer()
    {
        $customers = Customer::with(["orders"])->where('fcm_token', '!=', null)->paginate(25);

        return Excel::download(new CustomerAllExport($customers), 'All-Customer-report.xlsx');
    }
    public function customerInvoice($order_id)
    {
        $order = Order::find(Crypt::decrypt($order_id));
        $pdf   = PDF::loadView('admin.customer.invoice',['order' => $order]);
        return $pdf->download('invoice.pdf');


    }

    public function destroy($id)
    {
        //
    }
}
