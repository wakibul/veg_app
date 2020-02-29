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
                        <th>Status</th>
                        <th>Item</th>
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

                        <td>{{$key+1}}</td>
                        <td>{{$order->otp??'NA'}}</td>
                        <td valign="top">
                            <strong>
                                @if(!$order->order_confirm_id) pending#{{ $order->id }}

                                @else{{$order->order_confirm_id}}
                                @endif
                            </strong>
                        </td>


                        <td width="30%">{{$order->address??'NA'}}</td>
                        <td>{{$order->recipient_no ??'NA'}}</td>
                        <td>{{date("d-m-Y h:i a", strtotime($order->created_at))}}<br>
                            <a href="{{route("admin.home", ["slot_id" => $order->time_slot_id])}}">
                                <span class="label label-info">
                                    {{$order->timeSlot->slot}}
                                </span>
                            </a>
                        <td width="30%">@if($order->status!=0){{date("d-m-Y h:i a", strtotime($order->confirmation_time??'NA'))}} @else NA @endif</td>

                        <td>@if(!$order->order_confirm_id)
                            Waiting for Confirmation
                            @elseif($order->status==1)
                            Confirmed
                            @elseif($order->status==2)
                            Completed
                            @elseif($order->employee_id==null)
                            Assigned Delivery Boy
                            @elseif($order->status==3)
                            cancelled
                            @endif</td>
                        <td>
                            <button type="button" onClick="showItems(this)" class="btn btn-info btn-sm"
                                data-order="{{$order->toJson()}}" <i class="fa fa-eye"></i> Item
                            </button>
                        </td>
                        <td>
                            @if($order->status==0)
                            <a href="{{route('admin.dashboard.order.accept',Crypt::encrypt($order->id))}}">
                                <i class="btn btn-sm btn-success">Confirm</i>
                            </a>
                            <a href="{{route('admin.dashboard.order.reject',Crypt::encrypt($order->id))}}">
                                <i class="btn btn-sm btn-danger">Cancel</i>
                            </a>


                            @elseif($order->status==1)
                            <a class="btn btn-sm btn-warning"
                                href="{{route('admin.dashboard.order.close',Crypt::encrypt($order->id))}}"><i
                                    class="fa fa-close"></i> Close
                                Order</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            {{$orders->links()}}
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
                            <th>Quantity</th>
                            <th>Type</th>
                            <th>Price</th>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
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
