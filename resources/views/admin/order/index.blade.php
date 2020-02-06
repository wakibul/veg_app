<div class="row row-cards row-deck">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Recent Orders</h3>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-nowrap">
                    <thead>
                        <tr>
                            <th>Check</th>
                            <th>Sl.</th>
                            <th>Order No</th>
                            <th>Item's</th>
                            <th>Address</th>
                            <th>Phone No</th>
                            <th>Order Time</th>
                            <th>Confirm Time</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $key => $order)
                        @php
                        $tr_color_class = "";
                        if($order->status == 0){
                        $tr_color_class = "text-red";
                        $lbl_class = "danger";
                        }
                        elseif($order->status == 1){
                        $tr_color_class = "text-yellow";
                        $lbl_class = "warning";
                        }

                        elseif($order->status == 2){
                        $tr_color_class = "text-green";
                        $lbl_class = "success";
                        }
                        elseif($order->status == 3){
                        $tr_color_class = "text-info";
                        $lbl_class = "success";
                        }
                        @endphp
                        <form name="city" action="{{route('admin.assign_employee.store')}}" method="POST">
                           @csrf
                            <tr class="{{ $tr_color_class }}">
                                @if(($order->status==1) && !($order->delivery_boy_id))
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
                                <td>{{$order->order_confirm_id ?? "NA"}}</td>
                                <td>@foreach($order->orderTransactions as $orderKey => $orderTransaction)
                                    <span class="label label-{{$lbl_class}}">{{$orderTransaction->product->name}}
                                        ({{$orderTransaction->quantity}})</span><br>
                                    @endforeach</td>
                                <td>{{$order->address??'NA'}}</td>
                                <td>{{$order->recipient_no ??'NA'}}</td>
                                <td>{{date("d-m-Y h:i a", strtotime($order->created_at))}}</td>
                                <td>{{date("d-m-Y h:i a", strtotime($order->confirmation_time??'NA'))}}</td>
                                <td>@if(!$order->order_confirm_id)
                                    Waiting for Confirmation
                                    @elseif($order->status==1)
                                    Order Received
                                    @elseif($order->status==2)
                                    Order Completed
                                    @elseif($order->status==3)
                                    Order Cancle
                                    @endif</td>
                                <td>
                                    @if($order->status==0)
                                    <a href="{{route('admin.dashboard.order.accept',Crypt::encrypt($order->id))}}">
                                        <i class="btn btn-outline-success">Confirm Order</i>
                                    </a>
                                    <br>
                                    <a href="{{route('admin.dashboard.order.reject',Crypt::encrypt($order->id))}}">
                                        <i class="btn btn-outline-danger">Cancel Order</i>
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

</form>


</div>
