<div class="form-group">
    <div class="row">
        <div class="col-md-4">Name</div>
        <div class="col-md-6">
            <input type="text" name="name" class="form-control" required>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="row">
        <div class="col-md-4">Select City</div>
        <div class="col-md-6">
            <select name="city_id[]" id="city_id" required class="form-control" multiple>
                <option value="">Select</option>
                @foreach($cities as $key=>$city)
                <option value="{{$city->id}}">{{$city->name}}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>
<div class="form-group">
    <div class="row">
        <div class="col-md-4">Image</div>
        <div class="col-md-6">

            <div class="custom-file">
                <input type="file" class="custom-file-input" name="image"
                    value="@isset($category){{$category->banner_image}}@endisset" required>
                <label class="custom-file-label">Choose file...</label>

            </div>

        </div>
    </div>
</div>
