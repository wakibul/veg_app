

        <div class="package">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <div class="row">
                                <div class="mb-3">
                                    <label><input type="checkbox" name="default_packages[]" class="order" value="1"
                                            onClick="onlyOne(this)"> Select as a default
                                        package</label>
                                </div>


                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-md-2">Sku code</div>
                                <div class="col-md-4">
                                    <input type="text" name="skucodes[]" class="form-control"
                                        value="@isset($product){{($productpackage->skucode)}}@endisset" required>
                                </div>

                                <div class="col-md-2">Package Unit</div>
                                <div class="col-md-4">
                                    <select class="form-control" name="category_ids[]" required>
                                        <option value="">-- Please Select Package unit --</option>
                                        @foreach($package_masters as $package_master)

                                        <option value="{{$package_master->id}}"
                                            @isset($product){{($productpackage->product_id==$package_master->id?'selected':'')}}@endisset>
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
                                    <input type="text" name="market_prices[]" class="form-control market_price"
                                        id="market_price"
                                        value="@isset($product){{$productpackage->market_price}} @endisset" required>
                                </div>

                                <div class="col-md-2">Offer Percentage</div>
                                <div class="col-md-2">
                                    <input type="text" name="offer_percentages[]" class="form-control offer_per"
                                        value="@isset($product){{$productpackage->offer_percentage}}@endisset"
                                        id="offer_per" onkeyup="offerPrice(this)" required>
                                </div>
                                <div class="col-md-2">Offer Price</div>
                                <div class="col-md-2">
                                    <input type="text" name="offer_prices[]" class="form-control offer_price"
                                        value="@isset($product){{$productpackage->offer_price}}@endisset"
                                        id="offer_price" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="row">


                                <div class="col-md-2">Is Offer</div>
                                <div class="col-md-4">
                                    <select class="form-control" name="is_offers[]">
                                        <option value="">-- Please Select --</option>


                                        <option value="1"
                                            @isset($product){{$productpackage->is_offer==1?'selected':''}}@endisset>
                                            Yes</option>
                                        <option value="0"
                                            @isset($product){{$productpackage->is_product==0?'selected':''}}@endisset>
                                            No</option>



                                    </select>
                                </div>
                                <div class="col-md-2">Status</div>
                                <div class="col-md-4">
                                    <select class="form-control" name="status[]">
                                        <option value="">-- Please Select --</option>


                                        <option value="1"
                                            @isset($product){{$productpackage->is_product==1?'selected':''}}@endisset>
                                            Active</option>
                                        <option value="0"
                                            @isset($product){{$productpackage->is_product==0?'selected':''}}@endisset>
                                            In Active</option>



                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


