@extends('admin.layout.master')
@php

@endphp

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            Dashboard
            <button type="button" class="btn btn-primary">Todays Order: <span class="badge">{{$todays_order}}</span></button>
            <button type="button" class="btn btn-success"> Total Orders: <span class="badge">{{$total_orders}}</span></button>
        </h1>
    </div>

    <a class="btn btn-primary" data-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" aria-controls="collapseExample">
        <i class="fa fa-filter" aria-hidden="true"></i> Filter
    </a>

    @include('admin.report.filter')
    @include('admin.layout.alert')
    <a class="btn btn-info" href="{{request()->fullUrlWithQuery(['export-excel' => 1])}}"><button class="btn btn-sm btn-info"> <i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</button></a>
    @include('admin.order.index')

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

@endsection
