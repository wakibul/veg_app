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
            <input type="text" name="pin" class="form-control" value="@isset($employee){{$employee->pincode}}@endisset"
                required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Phone No</div>
        <div class="col-md-6">
            <input type="text" name="mobile" class="form-control" value="@isset($employee){{$employee->mobile}}@endisset"
                required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Password</div>
        <div class="col-md-6">
            <input type="password" name="pass" class="form-control"
                value="@isset($employee){{$employee->password}}@endisset" required>
        </div>
    </div>
</div>

