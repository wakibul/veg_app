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
                   Reset Password
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5">
                       @include('admin.layout.alert')
                        <form name="city" action="{{route('admin.editPassword')}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                       <div class="form-group">
                          <div class="row">
                          <div class="col-md-6">
                          <input type="password" name="pass" class="form-control"
                          value="" >
                         </div>
                        </div>
                        </div>
<div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 offset-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>


                        </form>
                    </div>

                </div>
            </div>

        </div>
    </div>

</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>

@endsection
