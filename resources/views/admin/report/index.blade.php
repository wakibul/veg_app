@extends('admin.layout.master')
@php

@endphp

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            Service Report
            <small>details</small>
        </h1>
    </div>
    @include('admin.report.filter')
    <div class="row">
        <div class="col-md-12">
            <table class="table table-bordered table-hover" id="orderTable">
                <caption>Recent Orders</caption>
                <thead>
                    <tr>
                        <th>Total Order</th>
                        <th>Total Delivery</th>
                        <th>Total Cancel</th>


                    </tr>
                </thead>
                <tbody>
                    <td>{{$total_order}}</td>
                    <td>{{$total_delivery}}</td>
                    <td>{{$total_cancel}}</td>
                </tbody>

            </table>


        </div>
    </div>
    <form name="employee" action="{{route('admin.assign_employee.store')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" id="orderTable">
                    <caption>Recent Orders</caption>
                    <thead>
                        <tr>

                            <th>Sl.</th>
                            <th>OTP</th>
                            <th>Order No</th>
                            <th width="20%">Address</th>
                            <th>Phone No</th>
                            <th width="20%">Order Time</th>
                            <th>Confirm Time</th>
                            <th>Status</th>
                            <th>Item</th>

                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ dd($orders) }} --}}
                        @foreach($orders as $key=>$order)
                        @php
                        $tr_class = "";
                        if($order->status == 0){
                        $tr_class = "text-blue";
                        $lbl_class = "info";
                        }
                        elseif($order->status == 1){
                        $tr_class = "text-yellow";
                        $lbl_class = "warning";
                        }

                        elseif($order->status == 2){
                        $tr_class = "text-green";
                        $lbl_class = "success";
                        }
                        elseif($order->status == 3){
                        $tr_color_class = "text-red";
                        $lbl_class = "red";
                        }
                        elseif($order->status == 4){
                        $tr_color_class = "text-info";
                        $lbl_class = "blue";
                        }

                        //dd($order->orderTransactions);
                        @endphp
                        <tr class="{{$tr_class}}">
                            <td>{{$key+1}}</td>
                            <td>{{$order->otp??'NA'}}</td>
                            <td valign="top">
                                <strong>
                                    @if(!$order->order_confirm_id) pending#{{ $order->id }}

                                    @else{{$order->order_confirm_id}}
                                    @endif
                                </strong>
                            </td>


                            <td width="20%">{{$order->address??'NA'}}</td>
                            <td>{{$order->recipient_no ??'NA'}}</td>
                            <td>{{date("d-m-Y h:i a", strtotime($order->created_at))}}<br>
                                <a href="{{route("admin.home", ["slot_id" => $order->time_slot_id])}}">
                                    <span class="label label-info">
                                        {{$order->timeSlot->slot??''}}
                                    </span>
                                </a>
                            <td width="20%">{{date("d-m-Y h:i a", strtotime($order->confirmation_time??'NA'))}}</td>

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
                               @foreach($order->orderTransactions as $orderKey => $orderTransaction)

                                <span class="label label-{{$lbl_class}}">{{$orderTransaction->product->name??''}}
                                ({{$orderTransaction->quantity??''}} ({{$orderTransaction->productPackage->PackageMaster->name??''}}))</span><br>

                                @endforeach
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



    </form>

</div>
@endsection
@section("css")
<style>
    tbody tr {
        border-bottom: 2px solid #9DB2A2;
    }
</style>
@endsection
@section('js')
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>

<script>
    $(document).ready(function(){
        $('#employee').on('show.bs.collapse', function () {
            return check();
        })
        var pusher = new Pusher('f4fc0e863f372de00405', {
            cluster: 'ap2',
            forceTLS: true
        });

    var channel = pusher.subscribe('dashboard-update');
        channel.bind('order-created', function(data) {
            console.log(data);
            alert(JSON.stringify(data));
        });
        channel.bind('order-cancelled', function(data) {
            console.log(data);
            alert(JSON.stringify(data));
        });
    });
    showItems = function(obj){
        console.log('showItems loadings');
        var $this = $(obj);
        var $modal = $("#myModal");
        var order = $this.data("order");
        var items = order["order_transactions"];
        console.log(order);
        console.log(items);
        var table_items = "";
        $(items).each(function(index, element){
            table_items +="<tr>";
            table_items +="<td>"+(index+1)+"</td>";
            table_items +="<td>"+element.product.name+"</td>";
            table_items +="<td>"+element.quantity+"</td>";
            table_items +="<td>"+element.price+"</td>";
            table_items +="</tr>";
        });
        $modal.find("#order_no").html(order.order_confirm_id ? order.order_confirm_id : "Pending#"+order.id);
        $modal.find("#order_time").html(order.created_at);
        $modal.find("#order_address").html(order.address);
        $modal.find("table tbody").html(table_items);
        $modal.modal();
    }

    check = function() {
        var total_order_chack = $(".order:checked").filter(function() {
            return this.checked;
        }).length;
        if(total_order_chack<=0){
            alert("Please select atleast one order");
            return false;
        }
    }
</script>
<script>
    var fromDate = null;
    var toDate = null;
    $('#from-date').Zebra_DatePicker({
    format: 'Y-m-d',
    direction: true,
    disabled_dates: ['* * * 0'],
    pair: $('#to-date'),
    onSelect: function () {
    fromDate = $(this)[0].value;
    $(this).change();
    }
    });
    $('#to-date').Zebra_DatePicker({
    format: 'Y-m-d',
    direction: true,
    disabled_dates: ['* * * 0'],
    onSelect: function () {
    toDate = $(this)[0].value;
    $(this).change();
    }
    });
</script>
<script>
    $(function(){
   $('.datepicker').datepicker({
      format: 'mm-dd-yyyy'
    });
});
</script>

@endsection
