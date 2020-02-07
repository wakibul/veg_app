@extends('admin.layout.master')
@php

@endphp

@section('content')
<div class="container">
    <div class="page-header">
        <h1 class="page-title">
            Dashboard
        </h1>
    </div>
    <div class="row row-cards">
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">

                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Todays Order</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">

                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Total Orders</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Available </div>
                </div>
            </div>
        </div>
        <!--- <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Guest Booking</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">

                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Total Franchise</div>
                </div>
            </div>
        </div>
        <div class="col-6 col-sm-4 col-lg-2">
            <div class="card">
                <div class="card-body p-3 text-center">
                    <div class="h1 m-0">1</div>
                    <div class="text-muted mb-4">Total Doctors</div>
                </div>
            </div>
        </div>

    -->



    </div>
   @include('admin.layout.alert')
    @include('admin.order.index')

</div>
@endsection
@section("css")
    <style>
        tbody tr{
            border-bottom: 2px solid #9DB2A2;
        }
    </style>
@endsection
@section('js')
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>
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
        var items = $this.data("items");
        console.log(items);
        var table_items = "";
        $(items).each(function(index, element){
            table_items +="<tr>";
            table_items +="<td>"+(index+1)+"</td>";
            table_items +="<td>"+element.product.name+"</td>";
            table_items +="<td>"+element.quantity+"</td>";
            table_items +="<td>"+element.price+"</td>";
            table_items +="</tr>";
        })
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

@endsection
