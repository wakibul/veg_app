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
                    Product Master(Edit)
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('admin.layout.alert')
                        <form name="product" action="{{route('admin.product.update',Crypt::encrypt($product->id))}}" method="POST"
                            enctype="multipart/form-data">

                            @include('admin.product.from')


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 offset-3">
                                        <button type="submit" class="btn btn-primary">Update</button>
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
@include('admin.product.create-js')

@endsection
