@extends('admin.layout.master')
@php

@endphp

@section('content')
<div class="container">
    @include('admin.layout.alert')
    <div class="page-header">
        <h4 class="page-title">
            <u> Customer Name:</u> {{$customer->name??'NA'}}<br>
             <u>Customer Phone No:</u> {{$customer->mobile??'NA'}}
        </h4>
    </div>
    <form name="customer" action="{{route('admin.customer.notification.store')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" id="orderTable">

                    <thead>
                        <tr>
                            <th>Sl.</th>
                            <th>Pin</th>
                            <th>Address</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ dd($orders) }} --}}


                        @forelse($orders as $key=>$order)

                        <tr>
                            <td>{{$key+1}}</td>

                            <td>{{$order->pincode}}</td>
                            <td>{{$order->address??'NA'}}</td>




                        </tr>
                        @empty
                        <tr>
                            <td colspan="3">No data</td>
                         </tr>
                        @endforelse


                    </tbody>
                </table>

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



@endsection
