@extends('admin.layout.master')
@section('css')
@endsection
@section('content')
<div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">
                    Delivery Transaction <br>
                    <span style="color:rgb(62, 0, 37)"><h4> <u>Emplyee Name:</u>   </span>{{$employee->name}}&nbsp;&nbsp;
                    <span style="color:rgb(62, 0, 37)"> <u>Mobile no:</u>   </span>    {{$employee->mobile}}&nbsp;&nbsp;
                    <span style="color:rgb(62, 0, 37)"><u> Address:</u>    </span>{{$employee->address}} {{$employee->pin}}</h4>


                </h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="orderTable">

                        <thead>
                        <tr>

                        <th>#No.</th>
                        <th>Order No</th>
                        <th width="30%">Address</th>

                        <th>Status</th>
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



                                <td>{{ $key+ 1 + ($orders->perPage() * ($orders->currentPage() - 1)) }}</td>

                                <td valign="top">
                                    <strong>
                                        @if(!$order->order_confirm_id) pending#{{ $order->id }}

                                        @else{{$order->order_confirm_id}}
                                        @endif
                                    </strong>
                                </td>


                                <td width="35%">{{$order->address??'NA'}}</td>




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
                    {{$orders->appends(request()->all())->links()}}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>

<script>

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

@endsection
