@extends('admin.layout.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" type="text/css" rel="stylesheet">
@endsection
@section('content')
 <div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
              <h1 class="page-title">
                Edit Category
              </h1>
            </div>
            <div class="card-body">
                    <div class="row">
                          <div class="col-md-6 col-lg-7">
                             @if(session()->has('error'))
                                <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <div>{{ $error }}</div>
                                @endforeach
                                </div>
                              @endif

                              @if(Session::has('success'))
                                        <div class="alert alert-success">
                                        {!! session('success') !!}
                                        </div>
                              @endif
                              <form name="city" action="{{route('admin.category.store')}}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group">
                                <div class="row">
                                      <div class="col-md-4">Name</div>
                                      <div class="col-md-6">
                                      <input type="text" name="name" class="form-control" required value="{{$category->name}}">
                                      </div>
                                 </div>
                                </div>
                                <div class="form-group">
                                 <div class="row">
                                    <div class="col-md-4">Upload Picture</div>
                                    <div class="col-md-6">
                                      <input type="file" name="banner_image" class="form-control" required>
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
                                <div class="col-md-2 offset-3">
                                    <button type="submit" name="submit" class="btn btn-primary">Submit</button>
                                  </div>
                              </div>
                            </div>

                            </form>
                          </div>



                    </div>
            </div>

        </div>
    </div>

</div>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js"></script>
<script>
$('#city_id').selectize({
    delimiter: ',',
    create: false,
    valueField: 'id',
    labelField: 'title',
    searchField: 'title',
    options: [
        {id: 1, title: 'Spectrometer', url: 'http://en.wikipedia.org/wiki/Spectrometers'},
        {id: 2, title: 'Star Chart', url: 'http://en.wikipedia.org/wiki/Star_chart'},
        {id: 3, title: 'Electrical Tape', url: 'http://en.wikipedia.org/wiki/Electrical_tape'}
    ]
});
</script>
@endsection
