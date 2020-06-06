$(document).ready(function () {
    $('#totalPrice').val(totalValue);
});

$("#orderItems").select2({
    placeholder :'Select Items',
    width: "100%",
});

$(document.body).on("change","#orderItems",function(){
    let totalPrice = 0
    $.each($('#orderItems').select2('data'), function (key, value) {
        totalPrice += parseInt(value.element.dataset.price);
    });
    $('#totalPrice').val(totalPrice);
});

if(typeof(salesOrderItemsPreset) !== "undefined")
{
    $('#orderItems').val(salesOrderItemsPreset).trigger('change');
}