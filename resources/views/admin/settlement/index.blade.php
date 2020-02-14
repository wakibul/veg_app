@extends('admin.layout.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" type="text/css"
    rel="stylesheet">
<style>
    .form-group .form-line .form-label {
        top: -10px !important;
        font-size: 12px !important;
    }

    .hidden {
        display: none;
    }

    tr.header {
        cursor: pointer;
    }
</style>
@endsection
@section('content')
<div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">
                    Settlement Details
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @include('admin.layout.alert')

                    </div>
                    <div class="container card">
                        <div class="row">
                            <div class="col-12">

                                <div class="card-body">
                                    <div class="col-md-12">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Engineer Name</th>
                                                    <th>Total Machines</th>
                                                    <th>Amount Pending</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($employees as $index => $employee)
                                                <tr class="header" tabindex="-1">
                                                    <td>{{$index + 1}}</td>
                                                    <td>{{$employee->name}}</td>
                                                    <td>{{$employee->mobile}}</td>
                                                    @php
                                                    $total_paid=0;
                                                    foreach ($employee->employeePaidTransactions as
                                                    $key=>$employee_paid_transaction)
                                                    $total_paid=$total_paid+$employee_paid_transaction->amount;


                                                    @endphp

                                                    <td>{{$employee->updated_balance}}</td>

                                                </tr>

                                                <tr class="hidden" tabindex="-1">
                                                    <td colspan="4">
                                                        <h4>transaction details</h4>
                                                        <form name="employee"
                                                            action="{{route('admin.settlement.store')}}" method="POST">
                                                            @csrf

                                                            <input type="hidden" name="employee_id"
                                                                value="{{$employee->id}}">
                                                            <table class="table table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>Order Id</th>

                                                                        <th>Amount</th>
                                                                        <th>Action(Settlement)</th>

                                                                    </tr>
                                                                </thead>
                                                                <tbody>

                                                                    @foreach ($employee->employeeUnpaidTransactions as
                                                                    $key=>$employee_transaction)
                                                                    <tr>
                                                                        <td>{{ ($key+1) }}</td>
                                                                        <td>{{$employee_transaction->order->order_confirm_id}}
                                                                        </td>

                                                                        <td>{{$employee_transaction->amount}}</td>

                                                                        <td>@if($employee_transaction->status==1)
                                                                            <label class="checkbox-inline"><input
                                                                                    type="checkbox"
                                                                                    name="employee_transactions[]"
                                                                                    value="{{ $employee_transaction->id }}">
                                                                            </label>
                                                                            @else
                                                                            Paid
                                                                            @endif
                                                                        </td>

                                                                    </tr>


                                                                    @endforeach
                                                                    @if(($employee->updated_balance)!=0)
                                                                    <tr>
                                                                        <td colspan="1"></td>
                                                                        <td>Total:</td>
                                                                        <td>{{ $employee->updated_balance }}
                                                                        </td>
                                                                        <td>
                                                                            <button type="submit"
                                                                                class="btn btn-primary">Sattlement</button>
                                                                        </td>
                                                                    </tr>
                                                                    @else
                                                                    <tr>
                                                                        <td class="text-danger text-center" colspan="4">
                                                                            No Records found.
                                                                        </td>
                                                                    </tr>
                                                                    @endif
                                                                </tbody>
                                                            </table>
                                                        </form>
                                                    </td>
                                                </tr>

                                                @empty
                                                <tr>
                                                    <td class="text-danger text-center" colspan="3">No Records found.
                                                    </td>
                                                </tr>
                                                @endforelse
                                            </tbody>
                                        </table>

                                    </div>
                                </div>


                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
<script>
    $(document).ready(function(){
        $(document).on("click", "tr.header", function(){
            console.log("clicked");
            $(this).next("tr").toggleClass("hidden");
        })
    });
</script>
@endsection
