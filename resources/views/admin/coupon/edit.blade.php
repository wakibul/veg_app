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
                    Coupon Master
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('admin.layout.alert')

                        <form name="coupon" action="{{route('admin.coupon.update',Crypt::encrypt($coupon->id))}}"
                            method="POST" enctype="multipart/form-data">

                            @include('admin.coupon.from')


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 offset-3">
                                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>
            </div>
            @include('admin.coupon.index')
        </div>
    </div>

</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
<script type="text/javascript">
    $('.delete').on('click', function () {
        return confirm('Are you sure to delete this coupon?');
    });
</script>
@endsection
