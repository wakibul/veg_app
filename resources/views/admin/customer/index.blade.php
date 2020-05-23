@extends('admin.layout.master')
@php

@endphp

@section('content')
<div class="container">
    @include('admin.layout.alert')
    <div class="page-header">
        <h1 class="page-title">
            Customer
            <small>Details</small>
        </h1>
    </div>




    <div class="row">
        <div class="col-md-12">
            <a class="btn btn-info btn-lg float-right" href="{{route('admin.customer.export')}}">
                <i class="fa fa-file-excel-o" aria-hidden="true"></i> Export

            </a>
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"><b>Customer Details</h3>
                  </div>
            <table id="customer">

                <thead>
                    <tr>

                        <th>Sl.</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- {{ dd($orders) }} --}}

                    @foreach($customers as $key=>$customer)

                    <tr>

                        <td>{{$key+1}}</td>
                        <td>{{$customer->name??'NA'}}</td>


                        <td>{{$customer->mobile}}</td>
                        <td>
                            <div class="btn-group">

                                <a href="{{route('admin.customer.view',Crypt::encrypt($customer->id))}}" class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>

                            </div>
                            <div class="btn-group">

                                <a href="{{route('admin.customer.export',Crypt::encrypt($customer->id))}}" class="btn btn-sm btn-info"><i class="fa fa-file-excel-o"></i></a>

                            </div>
                        </td>


                    </tr>

                    @endforeach

                </tbody>

            </table>
            </div>
            {{$customers->appends(request()->all())->links()}}

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
<script>
$(document).ready( function () {
    $('#customer').DataTable();
} );
</script>
<script src="https://js.pusher.com/5.1/pusher.min.js"></script>




@endsection
