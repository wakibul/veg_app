<div class="collapse" id="collapseExample">
    <div class="card no-prints">
        <div class="card-body">
            <div class="body">
                <form method="get">
                    <div class="row clearfix">
                        <div class="col-md-3">
                            <div class="form-group form-float">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">Order Confirm Id</div>
                                        <div class="col-md-8">
                                            <input type="text" class="form-control" name="order_confirm_id" id="order_confirm_id" value="{{request()->order_confirm_id}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group  form-float">
                                <select class="form-control show-tick" name="status">
                                    <option value="">Status</option>
                                    <option value="0">Not Yet Comfirm</option>
                                    <option value="1">Confirm</option>
                                    <option value="2">Delivered</option>
                                    <option value="3">Cancel</option>

                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-float">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="from_date" id="from-date" placeholder="From Date" autocomplete="off" value="{{request('from_date')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group form-float">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <input type="text" class="form-control" name="to_date" id="to-date" placeholder="To Date" autocomplete="off" value="{{request('to_date')}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row clearfix">
                        <div class="col-md-3">
                            <div class="form-group form-float">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-4">Pin</div>
                                        <div class="col-md-8">
                                            <input type="number" class="form-control" name="pincode" id="pincode" value="{{request()->pincode}}">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>




            </div>


            <button type="submit" class="btn btn-primary mr-2">
                <i class="fa fa-search" aria-hidden="true"></i> Search
            </button>

            <a href="{{request()->url()}}" class="btn btn-danger mr-2">
                <i class="fa fa-times" aria-hidden="true"></i>Close
            </a>

            </form>
        </div>
    </div>
</div>
