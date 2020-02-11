@extends('admin.layout.master')
@section('css')
@endsection
@section('content')
<div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">
                    Product List
                    <a href="{{route("admin.product.create")}}" class="text-right btn btn-sm btn-success"><span><i class="fa fa-plus"></i>Add Product</span></a>
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

                                <td>@if(!empty($product->small_picture))
                                <b><img src="{{asset('public/images/large/non-leafy/'.$product->small_picture)}}" width="100px;"></b>
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
                                        <a href="{{route('admin.product.delete',Crypt::encrypt($product->id))}}" class="btn btn-sm btn-danger"><i
                                                class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{$products->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@section('js')
@endsection
