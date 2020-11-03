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
    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fa fa-filter" aria-hidden="true"></i> Filter
    </a>
    <a class="btn btn-info" href="{{request()->fullUrlWithQuery(['export-excel' => 1])}}"><button class="btn btn-sm btn-info"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</button></a>
    <br>
    @include('admin.report.filter')
    <div class="card-header">

    </div>

    <span style="border:0 px;">

    </span>

    <form name="employee" action="{{route('admin.assign_employee.store')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" id="orderTable">

                    <thead>

                        <tr>
                            <th>Sl.</th>
                            <th>OTP</th>
                            <th>Order No</th>
                            <th width="30%">Address</th>
                            <th>Phone No</th>
                            <th width="30%">Order Time</th>
                            <th>Confirm Time</th>
                            <th>Status</th>
                            <th>Item</th>
                            <th>Total Amount</th>
                            
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


                            <td>{{$key+1}}</td>
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
                                <h6>Delivery Date:<br>{{$order->delivery_date}}</h6><br>
                                <a href="{{route("admin.home", ["slot_id" => $order->time_slot_id])}}">
                                    <span class="label label-info">
                                        {{$order->timeSlot->slot??''}}
                                    </span>
                                </a>
                            <td width="30%">
                                @if($order->status!=0){{date("d-m-Y h:i a", strtotime($order->confirmation_time??'NA'))}}
                                @else NA @endif</td>

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
                                <button type="button" onClick="showItems(this)" class="btn btn-info btn-sm" data-order="{{$order->toJson()}}" <i class="fa fa-eye"></i> Item
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

                        <h4>Coupon Price: - <strong id="coupon_price"></strong></h4>
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
    $(document).ready(function() {
        $('#employee').on('show.bs.collapse', function() {
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
    showItems = function(obj) {
        console.log('showItems loadings');
        var $this = $(obj);
        var $modal = $("#myModal");
        var order = $this.data("order");
        var items = order["order_transactions"];
        var coupon = order["coupon"];


        console.log(coupon);
        // console.log(items);
        var table_items = "";
        var total = 0;
        $(items).each(function(index, element) {
            console.log(element);
            table_items += "<tr>";
            table_items += "<td>" + (index + 1) + "</td>";
            table_items += "<td>" + element.product.name + "</td>";
            table_items += "<td class='text-right'>" + element.quantity + "</td>";
            var master = element.product.product_package.filter(function(obj) {
                if (obj.id == element.product_package_id) return obj;
            });
            table_items += "<td>" + (element.product_package.package_master.name) + "</td>";

            table_items += "<td class='text-right'>" + element.price.toFixed(2) + "</td>";
            table_items += "</tr>";
            total += element.price;

        });
        if (coupon == null) {
            var coupon_amount = 0.00;

        } else {
            if (order.discount_amt == null) {
                var coupon_amount = (coupon.coupon_in = 1 ? ((total.toFixed(2) / 100) * coupon.coupon_value.toFixed(2)) :
                    coupon.coupon_value.toFixed(2)).toFixed(2);
            } else {
                var coupon_amount = order.discount_amt.toFixed(2);
            }

        }
        if (order.total_price_with_tax == null) {
            var total_price = order.total_price_with_tax.toFixed(2) - coupon_amount;

        } else {
            var total_price = order.total_price_with_tax;
        }
        console.log(order.total_price_with_tax);

        $modal.find("#order_no").html(order.order_confirm_id ? order.order_confirm_id : "Pending#" + order.id);
        $modal.find("#order_time").html(order.created_at);
        $modal.find("#total_price").html(total.toFixed(2));
        $modal.find("#coupon_price").html(coupon_amount);
        $modal.find("#delivery_charge").html(order.delivery_charge.toFixed(2));

        $modal.find("#total_price_with_coupon").html(total_price.toFixed(2));
        $modal.find("#order_address").html(order.address);
        $modal.find("table tbody").html(table_items);
        $modal.modal();
    }

    check = function() {
        var total_order_chack = $(".order:checked").filter(function() {
            return this.checked;
        }).length;
        if (total_order_chack <= 0) {
            alert("Please select atleast one order");
            return false;
        }
    }
    closeOrder = function(Obj) {
        console.log(Obj);
        var order_id_url = $(Obj).data("close-url");
        console.log(order_id_url);
        $("#order_close_modal").find("form").prop("action", order_id_url);
        $("#order_close_modal").modal();
    }
</script>
<script src="path/to/zebra_datepicker.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr(document.getElementById('from-date'), {
        });
    });
    document.addEventListener("DOMContentLoaded", function () {
        flatpickr(document.getElementById('to-date'), {
        });
    });
  </script>


@endsection