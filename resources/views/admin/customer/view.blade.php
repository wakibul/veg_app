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


                        @foreach($orders as $key=>$order)
                           @foreach($order->orderTransactions as $key=>$transaction)
                             <tr>
                                <td>{{$key+1}}</td>
                            <th>{{$transaction->product->name??'NA'}}</th>
                            <th>{{$transaction->quantity??'NA' }}</th>
                            <th>{{$transaction->productPackage->packageMaster->name??'NA'}}</th>
                            <th>{{$transaction->price??'NA'}}</th>
                             </tr>
                            @endforeach




                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
