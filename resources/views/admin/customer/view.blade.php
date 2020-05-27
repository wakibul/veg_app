@extends('admin.layout.master')
@php

@endphp

@section('content')
<div class="container">
    @include('admin.layout.alert')
    <div class="page-header">

    </div>

    <div class="card">
        <div class="card-header">
        <h3 class="card-title"><b>Customer Name:</b>  {{$customer->name??'NA'}} &nbsp; <b>Customer Phone No:</b>{{$customer->mobile??'NA'}}</h3>
        <a href="{{route('admin.customer.index')}}" class="btn btn-info ml-auto"><i class="fa fa-list" aria-hidden="true"></i> Customer</a>
    </div>
    </div>

    @if(!empty($orders))
    @foreach($orders as $key=>$order)
    <div class="card">
        <div class="card-header">
        <h3 class="card-title"> <b>Order No:</b>{{$order->order_confirm_id??'NA'}} &nbsp;&nbsp; <b>Order at:</b> {{date("d-m-Y h:i a", strtotime($order->created_at??'NA'))}} </h3>


        <a href="{{route('admin.order.invoice',Crypt::encrypt($order->id))}}" class="btn btn-primary ml-auto"><i class="fa fa-file-pdf-o" aria-hidden="true"></i></a>

    </div>

        <div class="row">
            <div class="col-md-12">
                <table class="table table-vcenter table-mobile-md card-table" id="orderTable">

                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Product</th>
                            <th>Quantity</th>
                            <th>Type</th>
                            <th>Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ dd($orders) }} --}}



                           @foreach($order->orderTransactions as $key=>$transaction)
                             <tr>
                                <td>{{$key+1}}</td>
                            <th>{{$transaction->product->name??'NA'}}</th>
                            <th>{{$transaction->quantity??'NA' }}</th>
                            <th>{{$transaction->productPackage->packageMaster->name??'NA'}}</th>
                            <th>{{$transaction->price??'NA'}}</th>
                             </tr>
                            @endforeach
                      </tbody>
                </table>
            </div>
        </div>

    </div>
    @endforeach
    @else
    data is empty
    @endif


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



@endsection
