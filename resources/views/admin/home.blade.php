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
        <div class="col-6 col-sm-4 col-lg-2">
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





    </div>
@include('admin.order.index')

</div>
@endsection
@section('js')
<script>
function check() {
    var total_order_chack = $(".order:checked").filter(function() {
        return this.checked;
    }).length;
    if(total_order_chack<=0){
        alert("Please select atleast one order");
        return false;
    }
}
$('#employee').on('show.bs.collapse', function () {
  return check();
})
</script>

@endsection
