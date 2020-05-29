<form name="employee" action="{{route('admin.assign_employee.store')}}" method="POST">
    @csrf

    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-hover" id="orderTable">
                <caption>Recent Orders</caption>
                <thead>
                    <tr>
                        <th>Check</th>
                        <th>Sl.</th>
                        <th>OTP</th>
                        <th>Order No</th>
                        <th width="30%">Address</th>
                        <th>Phone No</th>
                        <th width="30%">Order Time</th>
                        <th>Confirm Time</th>
                        <th>Delivery Boy</th>
                        <th>Status</th>
                        <th>Item</th>
                        <th>Total Amount</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{ dd($orders) }} --}}
                    @foreach($orders as $key=>$order)
                    @php
                    $tr_class = "";
                    if($order->status == 0){
                    $tr_class = "";
                    $lbl_class = "";
                    }
                    elseif($order->status == 1){
                    $tr_class = "text-blue";
                    $lbl_class = "#FFFFFF";
                    }

                    elseif($order->status == 2){
                    $tr_class = "text-green";
                    $lbl_class = "success";
                    }
                    elseif($order->employee_id == null){
                    $tr_color_class = "text-red";
                    $lbl_class = "red";
                    }
                    elseif($order->status == 3){
                    $tr_color_class = "text-info";
                    $lbl_class = "blue";
                    }

                    //dd($order->orderTransactions);
                    @endphp
                    <tr class="{{$tr_class}}">

                        @if(($order->status==1) && !($order->employee_id))
                        <td>
                            <!-- Material unchecked -->
                            <div class="custom-control custom-checkbox mb-3">
                                <input type="checkbox" class="custom-control-input order" id="orderCheck_{{$key}}"
                                    name="order_checks[]" value="{{$order->id}}">
                                <label class="custom-control-label" for="orderCheck_{{$key}}"></label>
                            </div>
                        </td>
                        @else
                        <td></td>
                        @endif

                        <td>{{ $key+ 1 + ($orders->perPage() * ($orders->currentPage() - 1)) }}</td>
                        <td>{{$order->otp??'NA'}}</td>
                        <td valign="top">
                            <strong>
                                @if(!$order->order_confirm_id) pending#{{ $order->id }}

                                @else{{$order->order_confirm_id}}
                                @endif
                            </strong>
                        </td>


                        <td width="35%">{{$order->address??'NA'}}</td>

                        <td>{{$order->recipient_no ??'NA'}}</td>



                        <td width="30%">{{date("d-m-Y h:i a", strtotime($order->created_at))}}<br>
                            <hr>
                            <h6>Delivery Date:<br>{{date("d-m-Y", strtotime($order->delivery_date??'NA'))}}</h6><br>

                            <a href="{{route("admin.home", ["slot_id" => $order->time_slot_id])}}">
                                <span class="label label-info">
                                    {{$order->timeSlot->slot??''}}
                                </span>
                            </a>
                        </td>

                        <td width="30%">
                            @if($order->status!=0){{date("d-m-Y h:i a", strtotime($order->confirmation_time??'NA'))}}
                            @else NA @endif</td>
                            <td>{{$order->employee->name??'NA'}}</td>
                        <td>@if(!($order->order_confirm_id) && ($order->status==0))
                            Waiting for Confirmation
                            @elseif($order->status==1)
                            Confirmed
                            @elseif($order->status==2)
                            Completed
                            @elseif($order->employee_id!=null)
                            Assigned Delivery Boy
                            @elseif(!($order->order_confirm_id) && ($order->status==3))
                            cancelled
                            @endif</td>
                        <td>
                            <button type="button" onClick="showItems(this)" class="btn btn-info btn-sm"
                                data-order="{{$order->toJson()}}" <i class="fa fa-eye"></i> Item
                            </button>
                        </td>

                        <td>
                            @php
                            $total=0;
                            foreach($order->orderTransactions as $orderTransaction){
                            $total+=$orderTransaction->price;
                            }
                            @endphp
                            @if(!$order->coupon)
                            @if(!$order->total_price_with_tax)
                            Total Amount:{{number_format($total, 2, '.', '')}}
                            @else
                            Total Amount:{{number_format($order->total_price_with_tax, 2, '.', '')??''}}
                            @endif
                            @else
                            @php

                            if($order->coupon->coupon_in==1){
                            $coupon_amount= ($total)*($order->coupon->coupon_value)/100;
                            }else{
                            $coupon_amount=$order->coupon->coupon_value;
                            }
                            @endphp

                            Total Amount:{{number_format($order->total_price_with_tax, 2, '.', '')}}<br>
                            @if(!$order->discount_amt)
                            <hr>Coupon Price:{{number_format($coupon_amount, 2, '.', '')}}
                            @else
                            <hr>Coupon Price:{{number_format($order->discount_amt, 2, '.', '')}}
                            @endif
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                @if($order->status==0)
                                <a href="{{route('admin.dashboard.order.accept',Crypt::encrypt($order->id))}}">
                                    <i class="btn btn-sm btn-success">Confirm</i>
                                </a>
                                <a data-close-url="{{route('admin.dashboard.order.reject',Crypt::encrypt($order->id))}}"
                                    onclick="closeOrder(this)">
                                    <i class="btn btn-sm btn-danger">Cancel</i>
                                </a>


                                @elseif($order->status==1)
                                <a class="btn btn-sm btn-warning"
                                    href="{{route('admin.dashboard.order.close',Crypt::encrypt($order->id))}}"><i
                                        class="fa fa-close"></i> Close
                                    Order</a>
                                <a data-close-url="{{route('admin.dashboard.order.reject',Crypt::encrypt($order->id))}}"
                                    onclick="closeOrder(this)">
                                    <i class="btn btn-sm btn-danger">Cancel</i>
                                </a>

                                @endif
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
            {{$orders->appends(request()->all())->links()}}

        </div>
    </div>

    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header btn btn-info">
                    <h4 class="modal-title">Order Items: <strong id="order_no"></strong></h4>
                    <h6>Order Time:<strong id="order_time"></strong></h6>

                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Qty</th>
                            <th>Type</th>
                            <th>Price</th>
                        </thead>
                        <tbody>

                        </tbody>



                    </table>
                </div>
                <hr>
                <div class="container text-right">
                    <h4>Price: <strong id="total_price"></strong></h4>

                    <h4>Coupon Price:- <strong id="coupon_price"></strong></h4>
                    <h4>Delivery Charges: + <strong id="delivery_charge"></strong></h4>
                    </h4>Total amount with delivery charges: <strong id="total_price_with_coupon"></strong></h4>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">


                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-sm-10"></div>
            <div class="col-sm-2">

                <button style="align:right" data-toggle="collapse" href="#employee" aria-expanded="false"
                    aria-controls="collapseExample" type="button" class="btn btn-outline-success">Assign Delivery
                    Boy</button>

            </div>
        </div>
    </div>
    <div class="container collapse" id="employee">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Select Delivery Boy</h3>
                </div>
                <br>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-1 offset-md-3"><b>Name</b></div>
                        <div class="col-md-4">
                            <select class="form-control" name="employee_id">
                                <option value="">-- Please Select Delivery Boy --</option>
                                @foreach($employees as $employee)

                                <option value="{{$employee->id}}">
                                    {{$employee->name}}</option>

                                @endforeach
                            </select>

                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-md-8 offset-md-10">
                            <button type="submit" class="btn btn-outline-primary">Submit/Assign</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>
<div class="modal fade" id="order_close_modal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Close Order</h4>
            </div>
            <form action="" method="POST">
                {{csrf_field()}}
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-6">
                            <label for="buffer_time">Cancellation Reason</label>
                            <input type="text" class="form-control" name="reason" id="reason" required>
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="send_notification"
                                    name="send_notification" value="1" checked>
                                <label class="form-check-label" for="send_notification">Cancellation Notification Send
                                    to Customer</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Cancel Order</button>
                </div>
            </form>
        </div>

    </div>
</div>
