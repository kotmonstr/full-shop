

function ShowOtvet(el,id){
   $('.new-form').hide();
    el.text('Отмена').attr('onclick','$(".new-form").hide()');
    var clone = $('.replay-box').clone();
    $('.replay-box').hide();
    el.parent().parent().append(clone).addClass('new-form');
}
