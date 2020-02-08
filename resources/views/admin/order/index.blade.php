<form name="city" action="{{route('admin.assign_employee.store')}}" method="POST">
    @csrf
    <div class="row row-cards row-deck">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Recent Orders</h3>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter">
                        <thead>
                            <tr>
                                <th>Check</th>
                                <th>Sl.</th>
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
                            @forelse($orders as $key => $order)
                            @php
                            $tr_color_class = "";
                            if($order->status == 0){
                            $tr_color_class = "";
                            $lbl_class = "";
                            }
                            elseif($order->status == 1){
                            $tr_color_class = "yellow";
                            $lbl_class = "warning";
                            }

                            elseif($order->status == 2){
                            $tr_color_class = "#68D281";
                            $lbl_class = "success";
                            }
                            elseif($order->status == 3){
                            $tr_color_class = "#99FFCC";
                            $lbl_class = "info";
                            }
                            elseif($order->status == 4){
                            $tr_color_class = "info";
                            $lbl_class = "";
                            }
                            @endphp
                            <tr bgcolor="{{ $tr_color_class }}">
                                @if(($order->status==1) && !($order->employee_id))
                                <td>
                                    <!-- Material unchecked -->
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input order"
                                            id="orderCheck_{{$key}}" name="order_checks[]" value="{{$order->id}}">
                                        <label class="custom-control-label" for="orderCheck_{{$key}}"></label>
                                    </div>
                                </td>
                                @else
                                <td></td>
                                @endif

                                <td>{{$key+1}}</td>
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
                                <td width="30%">{{date("d-m-Y h:i a", strtotime($order->confirmation_time??'NA'))}}</td>
                                <td>@if(!$order->order_confirm_id)
                                    Waiting for Confirmation
                                    @elseif($order->status==1)
                                    Confirmed
                                    @elseif($order->status==2)
                                    Completed
                                    @elseif($order->status==3)
                                    Assigned Delivery Boy
                                    @elseif($order->status==4)
                                    cancelled
                                    @endif</td>
                                <td>
                                    <button type="button" onClick="showItems(this)" class="btn btn-info btn-sm"
                                        data-items="{{$order->orderTransactions->toJson()}}">
                                        <i class="fa fa-eye"></i> Item
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

                            @empty
                            <tr>
                                <th colspan="3">No Data</th>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="myModal">
        <div class="modal-dialog">
            <div class="modal-content">

                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Order Items</h4>

                </div>

                <!-- Modal body -->
                <div class="modal-body">
                    <table class="table table-sm table-bordered">
                        <thead>
                            <th>#</th>
                            <th>Item Name</th>
                            <th>Quantity</th>
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
            <div class="col-md-8 offset-md-10">
                <button data-toggle="collapse" href="#employee" aria-expanded="false" aria-controls="collapseExample"
                    type="button" class="btn btn-outline-success">Assign Delivery Boy</button>
            </div>
        </div>
    </div>
    <div class="container collapse" id="employee">

        <br>
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
                                <option value="">-- Please Select Employee --</option>
                                @foreach($employees as $employee)

                                <option value="{{$employee->id}}">
                                    {{$employee->name}}</option>


                            </select>
                            @endforeach
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
