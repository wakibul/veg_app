@csrf
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Name</div>
        <div class="col-md-6">
            <input type="text" name="name" class="form-control" value="@isset($unit){{$unit->name}}@endisset" required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Abbreviation</div>
        <div class="col-md-6">
            <input type="text" name="abb" class="form-control" value="@isset($unit){{$unit->abb}}@endisset" required>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Status</div>
        <div class="col-md-6">
            <select class="form-control" name="status">
                <option value="1" @isset($unit){{$unit->status==1?'selected':''}}@endisset>
                    Available</option>
                <option value="0" @isset($unit){{$unit->status==0?'selected':''}}@endisset>
                    Not Available</option>

            </select>
        </div>
    </div>
</div>
