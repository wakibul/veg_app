@csrf
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Name</div>
        <div class="col-md-6">
            <input type="text" name="name" class="form-control" value="@isset($employee){{$employee->name}}@endisset" required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Address</div>
        <div class="col-md-6">
            <input type="text" name="address" class="form-control" value="@isset($employee){{$employee->address}}@endisset"
                required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Pin</div>
        <div class="col-md-6">
            <input type="number" name="pin" class="form-control" value="@isset($employee){{$employee->pincode}}@endisset"
                required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Phone No</div>
        <div class="col-md-6">
            <input type="number" name="mobile" class="form-control" value="@isset($employee){{$employee->mobile}}@endisset"
                required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">@if(@isset($employee) )New Password @else Password @endif</div>
        <div class="col-md-6">
            <input type="password" name="pass" class="form-control"
                value="" required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Document</div>
        <div class="col-md-6">

            <div class="custom-file">
                <input type="file" class="custom-file-input" name="document"
                    value="@isset($employee){{$employee->document}}@endisset" required>
                <label class="custom-file-label">Choose file...</label>

            </div>

        </div>
    </div>
</div>

