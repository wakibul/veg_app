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
                    Category Master
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        @include('admin.layout.alert')
                        <form name="city" action="{{route('admin.category.store')}}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">Name</div>
                                    <div class="col-md-6">
                                        <input type="text" name="name" class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-4">Select City</div>
                                    <div class="col-md-6">
                                        <select name="city_id[]" id="city_id" required class="form-control" multiple>
                                            <option value="">Select</option>
                                            @foreach($cities as $key=>$city)
                                            <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 offset-3">
                                        <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>

                    <div class="col-md-6">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $key=>$category)
                                <tr>
                                    <td>{{ ($key+1) }}</td>
                                    <td>{{$category->name}}</td>

                                    <td>
                                        <div class="btn-group">
                                            {{-- <a href="{{route('admin.category.edit',Crypt::encrypt($category->id))}}"
                                            class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a> --}}
                                            <a href="{{route('admin.category.delete',Crypt::encrypt($category->id))}}"
                                                class="btn btn-sm btn-danger" onclick="return conf()"><i
                                                    class="fa fa-trash"></i></a>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3">No data</td>
                                </tr>
                                @endforelse

                            </tbody>
                        </table>
                        <span class="pull-right"> {{ $categories->links()}}</span>
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
    $('#city_id').selectize({
    delimiter: ',',
    persist: false,
    create: false
});
</script>
@endsection
