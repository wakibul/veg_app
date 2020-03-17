@extends('admin.layout.master')
@php

@endphp

@section('content')
<div class="container">
    @include('admin.layout.alert')
    <div class="page-header">
        <h1 class="page-title">
            Notification
            <small></small>
        </h1>
    </div>
    <form name="customer" action="{{route('admin.customer.notification.store')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered table-hover" id="orderTable">

                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Sl.</th>
                            <th>Name</th>
                            <th>Phone</th>

                        </tr>
                    </thead>
                    <tbody>
                        {{-- {{ dd($orders) }} --}}

                        @foreach($customers as $key=>$customer)

                        <tr>
                            <td>
                                <!-- Material unchecked -->

                                <div class="custom-control custom-checkbox mb-3">
                                    <input type="checkbox" class="custom-control-input customer"
                                        id="customerCheck_{{$key}}" name="customer_checks[]" value="{{$customer->id}}">
                                    <label class="custom-control-label" for="customerCheck_{{$key}}"></label>
                                </div>

                            </td>
                            <td>{{$key+1}}</td>
                            <td>{{$customer->name??'NA'}}</td>


                            <td>{{$customer->mobile}}</td>



                        </tr>

                        @endforeach

                    </tbody>
                </table>

                {{$customers->links()}}
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-sm-10"></div>
                <div class="col-sm-2">

                    <button style="align:right" data-toggle="collapse" href="#employee" aria-expanded="false"
                        aria-controls="collapseExample" type="button" class="btn btn-outline-success"
                        onclick="return check()">Send
                        Notification</button>

                </div>
            </div>
        </div>

        <div class="container collapse" id="employee">

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Notification</h3>
                    </div>
                    <br>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-2 offset-md-3"><b>Notification:</b></div>
                            <div class="col-md-4">
                                <textarea class="form-control" name="msg" id="msg" rows="3"
                                    placeholder="write your notification message here.. " required></textarea>

                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8 offset-md-10">
                                <button type="submit" class="btn btn-outline-primary">Send</button>
                            </div>
                        </div>
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