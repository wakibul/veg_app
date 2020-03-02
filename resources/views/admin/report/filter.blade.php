<div class="card no-prints">
    <div class="card-header">
        <h5><i class="fa fa-filter"></i> Filter</h5>
    </div>
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
                    <div class="col-md-6">
                        <div class="input-daterange input-group" id="bs_datepicker_range_container">
                            <div class="form-line">
                                <input type="text" class="form-control datepicker" id="from_date" name="from_date" placeholder="From Date"
                                    autocomplete="off" value="{{request('from_date')}}">
                            </div>
                            <span class="input-group-addon">&nbsp;to&nbsp;</span>
                            <div class="form-line">
                                <input type="text" class="form-control datepicker" id="to_date" name="to_date" placeholder="To Date"
                                    autocomplete="off" value="{{request('to_date')}}">
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
