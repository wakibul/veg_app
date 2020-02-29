@csrf

<div class="form-group">
    <div class="row">
        <div class="col-md-4">Image</div>
        <div class="col-md-6">

            <div class="custom-file">
                <input type="file" class="custom-file-input" name="image"
                    value="@isset($banner){{$banner->banner_image}}@endisset" required>
                <label class="custom-file-label">Choose file...</label>

            </div>

        </div>
    </div>
</div>
