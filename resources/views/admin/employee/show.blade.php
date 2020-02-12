@extends('admin.layout.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" type="text/css"
    rel="stylesheet">
@endsection
@section('content')
<div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">
                    Delivery Boy Details
                </h1>
            </div>
            <div class="card-body">
                <div class="row">

                    <table class="table">
                        <thead>
                            <tr>

                                <th align="left">Name :{{$employee->name}}<br>Phone No:{{$employee->mobile}}</th>


                                <th align="right">Address:{{$employee->address}}<br>pin:{{$employee->pincode}}</th>


                            </tr>
                        </thead>

                    </table>


                </div>
            </div>
            <div class="col-md-12">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Id</th>
                            <th>Status</th>
                            <th>Amount</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employee->employeeTransactions as $key=>$employee_transaction)
                        <tr>
                            <td>{{ ($key+1) }}</td>
                            <td>{{$employee_transaction->order->order_confirm_id}}</td>
                            <td>{{$employee_transaction->status}}</td>
                            <td>{{$employee_transaction->amount}}</td>

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
    </div>

</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

@endsection
