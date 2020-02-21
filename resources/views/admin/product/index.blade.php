@extends('admin.layout.master')
@section('css')
@endsection
@section('content')


<div class="container card">
    <div class="page-header">
        <p>
            <a class="btn btn-primary" data-toggle="collapse" href="#filter" role="button" aria-expanded="false"
                aria-controls="filter">
                <i class="fa fa-filter" aria-hidden="true"></i>Filter
            </a>
        </p>
    </div>
    <div class="collapse" id="filter">
        <div class="card-body">
            <div class="row">

                <form class="form-inline" method="get" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="product_name">Product Name:</label>&nbsp;
                        <input type="product_name" class="form-control" id="product_name" value="{{request()->name}}"
                            name="name">
                    </div>&nbsp;&nbsp;
                    <div class="form-group">
                        <label for="category">Category:</label>&nbsp;
                        <select class="form-control" name="category_id" value="{{request()->category_id}}"
                            name="category_id">
                            <option value="">-- Please Select Category --</option>
                            @foreach($categories as $category)

                            <option value="{{$category->id}}" @isset($product)
                                {{($product->category_id==$category->id)? 'selected':''}} @endisset">
                                {{$category->name}}</option>
                            @endforeach


                        </select>
                    </div>
                  &nbsp;&nbsp;
                    <div class="form-group">
                        <button type="submit" class="btn btn-success"><i class="fa fa-search"
                                aria-hidden="true"></i>Search</button>
                    </div>
                    <div class="form-group">
                        <a href="{{request()->url()}}" class="btn btn-danger">
                            <i class="fa fa-close"></i> Reset
                        </a>

                    </div>

            </div>
        </div>

        </form>
    </div>

</div>
<div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">
                    Product List
                    <a href="{{route("admin.product.create")}}" class="text-right btn btn-sm btn-success"><span><i
                                class="fa fa-plus"></i>Add Product</span></a>
                </h1>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered table-hover" id="orderTable">
                        <caption>Product List</caption>
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Product Image</th>
                                <th>name</th>
                                <th>Details</th>
                                <th>Unit Description</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Defult Package</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- {{ dd($orders) }} --}}
                            @foreach($products as $key=>$product)

                            <tr>
                                <td class="sl">{{$key+1}}</td>

                                <td id="img">@if(!empty($product->small_picture))
                                    <b><img src="{{$product->small_picture}}" width="100px;"></b>
                                    @endif</td>
                                <td>{{ $product->name }}</td>
                                <td>{{$product->details}}</td>
                                <td>{{$product->unit_desc??'NA'}}</td>
                                <td>{{$product->category->name}}</td>
                                <td>@if($product->is_available==0)NotAvailable @else Available @endif</td>
                                <td>{{$product->defultPackage->packageMaster->name ?? "NA"}}</td>

                                </td>


                                <td>
                                    <div class="btn-group">
                                        <a href="{{route('admin.product.edit',Crypt::encrypt($product->id))}}" class="btn btn-sm
                                                        btn-primary"><i class="fa fa-edit"></i></a>
                                        <a href="{{route('admin.product.delete',Crypt::encrypt($product->id))}}"
                                            class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{$products->appends(request()->all())->links()}}

                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')

@endsection
