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
                    Employee Master
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        @endif

                        @if(session()->has('error'))
                        <div class="alert alert-danger">
                            @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                            @endforeach
                        </div>
                        @endif

                        @if(Session::has('success'))
                        <div class="alert alert-success">
                            {!! session('success') !!}
                        </div>
                        @endif
                        <form name="city" action="{{route('admin.employee.update',Crypt::encrypt($employee->id))}}"
                            method="POST" enctype="multipart/form-data">

                            @include('admin.employee.from')


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 offset-3">
                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    @include('admin.employee.index')
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

@endsection
