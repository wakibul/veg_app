@extends('admin.layout.master')
@php

@endphp

@section('content')
<div class="container">
    @include('admin.layout.alert')
    <div class="page-header">
        <h1 class="page-title">
            Customer
            <small>details</small>
        </h1>
    </div>
    <form name="customer" action="{{route('admin.customer.notification.store')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" id="orderTable">

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

                            <a href="{{route('admin.customer.view',Crypt::encrypt($customer->id))}}"
                            class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a>

                    </div>
                    </td>


                        </tr>

                        @endforeach

                    </tbody>
                </table>

                {{$customers->links()}}
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
    check = function() {
        var total_order_chack = $(".customer:checked").filter(function() {
            return this.checked;
        }).length;
        if(total_order_chack<=0){
            alert("Please select atleast one Customer");
            return false;
        }
    }
</script>


@endsection
