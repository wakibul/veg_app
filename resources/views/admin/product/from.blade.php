@csrf
@php
$productPackages = collect();
if(isset($product)==true){
    if($product->count()){
        if($product->productPackage()->exists()){
            $productPackages = $product->productPackage;
        }
    }else{
        $productPackages = collect();
    }
}else{
    $productPackages = collect();
    $key = 0;
}


@endphp
<div class="form-group">
    <div class="row">
        <div class="col-md-2">Name</div>
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" value="@isset($product){{$product->name}}@endisset"
                required>
        </div>

        <div class="col-md-2">Description</div>
        <div class="col-md-4">
            <textarea class="form-control" name="details"
                rows="3">@isset($product){{$product->details}} @endisset</textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-2">Unit Description</div>
        <div class="col-md-4">
            <textarea class="form-control" name="unit_desc" rows="3"
                required>@isset($product){{$product->unit_desc}} @endisset</textarea>
        </div>

        <div class="col-md-2">Category</div>
        <div class="col-md-4">
            <select class="form-control" name="category_id" value="" required>
                <option value="">-- Please Select Category --</option>
                @foreach($categories as $category)

                <option value="{{$category->id}}" @isset($product)
                    {{($product->category_id==$category->id)? 'selected':''}} @endisset">
                    {{$category->name}}</option>
                @endforeach


            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-2">Status</div>
        <div class="col-md-4">
            <select class="form-control" name="productstatus" required>
                <option value="">-- Please Select--</option>

                <option value="1" @isset($product){{$product->status==1?'selected':''}}@endisset>Available</option>

                <option value="0" @isset($product){{$product->status==0?'selected':''}}@endisset>Not Available</option>

            </select>
        </div>

        <div class="col-md-2">In Stock</div>
        <div class="col-md-4">
            <select class="form-control" name="is_available" required>
                <option value="">-- Please Select--</option>
                <option value="1" @isset($product){{$product->is_available==1?'selected':''}}@endisset>Available
                </option>
                <option value="0" @isset($product){{$product->is_available==0?'selected':''}}@endisset>Not Available
                </option>


            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-2">Small Image</div>
        <div class="col-md-4">

            <div class="custom-file">
                <input type="file" class="custom-file-input" name="small_picture"
                    value="@isset($product){{$product->small_picture}}@endisset">
                <label class="custom-file-label">Choose file...</label>

            </div>

        </div>
        <div class="col-md-2">Large Image</div>
        <div class="col-md-4">

            <div class="custom-file">
                <input type="file" class="custom-file-input" name="large_picture"
                    value="@isset($product){{$product->large_picture}} @endisset">
                <label class="custom-file-label">Choose file...</label>

            </div>

        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-2"> Is Subscrib</div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="defaultUnchecked" name="is_subscribe"
                onclick="onlySub(this)" value="0" @isset($product){{$product->is_subscribed==0?'selected':''}}@endisset>
            <label class="custom-control-label" for="defaultUnchecked">Yes</label> &nbsp;
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="default" name="is_subscribe" onclick="onlySub(this)"
                onclick="onlySub(this)" value="1" @isset($product){{$product->is_product==0?'selected':''}}@endisset>
            <label class="custom-control-label" for="default">No</label>
        </div>


    </div>
</div>
<div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">
                    Product Packages
                </h1>
            </div>
        @if($productPackages->count())
            @forelse ($productPackages as $key => $productpackage)
                @include('admin.product.product-package-form')
            @empty
                 @if(old('old_productPackages')!=null)
                    @foreach(old('old_productPackages') as $key => $productPackage)
                        @include('admin.product.product-package-form')
                    @endforeach
                @else
                    @include('admin.product.product-package-form')
                @endif
            @endforelse
        @else
            @include('admin.product.product-package-form')
        @endif
            <div class="col-8 col-md-12">
                <div class="text-right  col-md-offset-10">
                    <button type="button" class="btn btn-primary" onclick="addMorePackage()">
                        <i class="fa fa-plus">add More Package</i>
                    </button>
                </div>
            </div>
            <div class="col-8 col-md-12">
                <div class="text-right col-md-offset-4 remove_package">
                    {{-- @if ($application->count()) --}}
                    <button type="button" class="btn btn-danger">
                        <i class="fa fa-trash" aria-hidden="true" onclick="removePackage(this)"> Delete Product</i>
                    </button>
                    {{-- @endif --}}
                </div>
            </div>
            <hr>


        </div>
    </div>
</div>

</div>
