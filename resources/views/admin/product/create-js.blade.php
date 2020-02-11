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

resetDefaultPackages();
}
removePackage = function (obj) {

    if ($(".package").length == 1) {
        alert("Atleast one package required.");
        return false;
    }
    $(obj).parents(".package").hide("slow", function () {
console.log("remove button clicked");
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
offerPrice = function (Obj)
{
 var $this = $(Obj);

 var offer_per =$this.parents('.form-group .row').find('.offer_per').val();
var market_price=$this.parents('.form-group .row').find('.market_price').val();
 var offer= market_price-(market_price*(offer_per/100));
 var offer_price = $this.parents('.form-group .row').find('.offer_price').val(offer);
//Not recommended
}
</script>
