@extends('admin.layout.master')
@section('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css" type="text/css"
    rel="stylesheet">
@endsection
@section('content')
<div class="container card">
    <div class="row">
        <div class="col-12">
            <div class="page-header">
                <h1 class="page-title">
                    Product Master
                </h1>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @include('admin.layout.alert')
                        <form name="city" action="{{route('admin.product.store')}}" method="POST"
                            enctype="multipart/form-data">

                            @include('admin.product.from')


                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-2 offset-3">
                                        <button type="submit" class="btn btn-primary">Submit</button>
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
    var remove_package_button = '<button type="button" class="btn btn-danger" onclick="removePackage(this)">' +
    '<i class="fa fa-trash" aria-hidden="true"> Delete Package</i>' +
    '</button>';

addMorePackage = function () {

var clone_data = $(".package:last").clone();
$(clone_data).find("input, select, textarea").val("");
$(clone_data).find(':checked').attr('checked', false);
$(clone_data).find(".remove_package").html(remove_package_button);
$(clone_data).hide();
var clone_data = $(".package:last").after(clone_data);
$(".package:last").show("slow");
$('select').selectpicker();

resetDefaultPackages();
}
removePackage = function (obj) {
    console.log("remove button clicked");
    if ($(".package").length == 1) {
        alert("Atleast one package required.");
        return false;
    }
    $(obj).parents(".package").hide("slow", function () {
        $(this).remove();
    });
}
function onlyOne(checkbox) {
    /* var checkboxes = document.getElementsByName('default_package')
    checkboxes.forEach((item) => {
    if (item !== checkbox) item.checked = false
    }) */
    var $this = $(checkbox);
    $(".order").not($this).prop({
        "checked": false
    });
    resetDefaultPackages();
}
    resetDefaultPackages = function(){
        $(".order").each(function(index, element){
            $(element).val(index);
        });
    }
function onlySub(checkbox) {
var checkboxes = document.getElementsByName('is_subscribe')
checkboxes.forEach((item) => {
if (item !== checkbox) item.checked = false
})
}
</script>
@endsection
