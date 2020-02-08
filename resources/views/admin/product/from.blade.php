@csrf
<div class="form-group">
    <div class="row">
        <div class="col-md-2">Name</div>
        <div class="col-md-4">
            <input type="text" name="name" class="form-control" value="" required>
        </div>

        <div class="col-md-2">Description</div>
        <div class="col-md-4">
            <textarea class="form-control" name="details" rows="3"></textarea>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-2">Unit Description</div>
        <div class="col-md-4">
            <textarea class="form-control" name="unit_desc" rows="3"></textarea>
        </div>

        <div class="col-md-2">Category</div>
        <div class="col-md-4">
            <select class="form-control" name="category_id">
                <option value="">-- Please Select Category --</option>
                @foreach($categories as $category)

                <option value="{{$category->id}}">
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
            <select class="form-control" name="productstatus">
                <option value="">-- Please Select--</option>
                <option value="1">Available</option>
                <option value="0">Not Available</option>

            </select>
        </div>

        <div class="col-md-2">In Stock</div>
        <div class="col-md-4">
            <select class="form-control" name="is_available">
                <option value="">-- Please Select--</option>
                <option value="1">Available</option>
                <option value="0">Not Available</option>


            </select>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-2">Small Image</div>
        <div class="col-md-4">

            <div class="custom-file">
                <input type="file" class="custom-file-input" name="small_picture" required>
                <label class="custom-file-label">Choose file...</label>

            </div>

        </div>
        <div class="col-md-2">Large Image</div>
        <div class="col-md-4">

            <div class="custom-file">
                <input type="file" class="custom-file-input" name="large_picture" required>
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
                onclick="onlySub(this)" value="0">
            <label class="custom-control-label" for="defaultUnchecked">Yes</label> &nbsp;
        </div>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="default" name="is_subscribe" onclick="onlySub(this)"
                value="1" onclick="onlySub(this)" value="0">
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
            <div class="package">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <div class="row">


                                   {{--  <div class="custom-control custom-checkbox mb-3">
                                        <input type="checkbox" class="custom-control-input order" id="default_package"
                                            name="default_packages[]" onclick="onlyOne(this)" value="1">
                                        <label class="custom-control-label" for="default_package">Select as a default
                                            package</label>
                                    </div>
 --}}
                                <div class="mb-3">
                                    <label><input type="checkbox" name="default_packages[]" class="order" value="1" onClick="onlyOne(this)"> Select as a default
                                        package</label>
                                </div>


                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">Sku code</div>
                                    <div class="col-md-4">
                                        <input type="text" name="skucodes[]" class="form-control" value="" required>
                                    </div>

                                    <div class="col-md-2">Package Unit</div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="category_ids[]">
                                            <option value="">-- Please Select Package unit --</option>
                                            @foreach($package_masters as $package_master)

                                            <option value="{{$package_master->id}}">
                                                {{$package_master->name}}</option>
                                            @endforeach


                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2">Market Price</div>
                                    <div class="col-md-2">
                                        <input type="text" name="market_prices[]" class="form-control" value=""
                                            required>
                                    </div>

                                    <div class="col-md-2">Offer Percentage</div>
                                    <div class="col-md-2">
                                        <input type="text" name="offer_percentages[]" class="form-control" value=""
                                            required>
                                    </div>
                                    <div class="col-md-2">Offer Price</div>
                                    <div class="col-md-2">
                                        <input type="text" name="offer_prices[]" class="form-control" value="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="row">


                                    <div class="col-md-2">Is Offer</div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="is_offers[]">
                                            <option value="">-- Please Select --</option>


                                            <option value="1">Yes</option>
                                            <option value="0">No</option>



                                        </select>
                                    </div>
                                    <div class="col-md-2">Status</div>
                                    <div class="col-md-4">
                                        <select class="form-control" name="status[]">
                                            <option value="">-- Please Select --</option>


                                            <option value="1">Active</option>
                                            <option value="0">In Active</option>



                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                    <i class="fa fa-trash" aria-hidden="true"> Delete Product</i>
                </button>
                {{-- @endif --}}
            </div>
        </div>
    </div>
    <hr>
</div>
</div>
