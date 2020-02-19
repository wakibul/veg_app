@if ($errors->any())
<div class="alert alert-danger">
    @foreach ($errors->all() as $error)
    <div>{{ $error }}</div>
    @endforeach
</div>
@endif

@if(Session::has('error'))
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
