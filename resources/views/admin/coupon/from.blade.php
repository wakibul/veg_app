@csrf
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Name</div>
        <div class="col-md-8">
            <input type="text" name="name" class="form-control" value="@isset($coupon){{$coupon->name}}@endisset"
                required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Code</div>
        <div class="col-md-8">
            <input type="text" name="coupon_code" class="form-control"
                value="@isset($coupon){{$coupon->coupon_code}}@endisset" required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Coupon In</div>
        <div class="col-md-8">
            <select class="form-control" name="coupon_in" required>
                <option value="">-- Please Select--</option>

                <option value="1" @isset($coupon){{$coupon->coupon_in==1?'selected':''}}@endisset>Percentage</option>

                <option value="2" @isset($coupon){{$coupon->coupon_in==2?'selected':''}}@endisset>Rupees</option>

            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Coupon Value</div>
        <div class="col-md-8">
            <input type="text" name="coupon_value" class="form-control"
                value="@isset($coupon){{$coupon->coupon_value}}@endisset" required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Coupon Type</div>
        <div class="col-md-8">


            <select class="form-control" name="coupon_type" required>

                <option value="">-- Please Select--</option>
                @foreach($miscellaneous_masters as $key=>$miscellaneous_masters)
                <option value="{{$miscellaneous_masters->type}}">
                    {{$miscellaneous_masters->type}}
                </option>

                @endforeach

            </select>

        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-4">Max Coupon Used</div>
        <div class="col-md-8">
            <input type="text" name="max_coupon_use" class="form-control"
                value="@isset($coupon){{$coupon->max_coupon_use}}@endisset" required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Valid Upto(days)</div>
        <div class="col-md-8">
            <input type="text" name="valid_to" class="form-control"
                value="" required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Minimun Amount</div>
        <div class="col-md-8">
            <input type="text" name="minimun_amount" class="form-control"
                value="@isset($coupon){{$coupon->minimun_amount}}@endisset" required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Status</div>
        <div class="col-md-8">
            <select class="form-control" name="is_active" required>
                <option value="">-- Please Select--</option>

                <option value="1" @isset($coupon){{$coupon->is_active==1?'selected':''}}@endisset>Active</option>

                <option value="2" @isset($coupon){{$coupon->is_active==0?'selected':''}}@endisset>InActive</option>

            </select>
        </div>
    </div>
</div>
