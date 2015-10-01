function changePlace(el,Name){
var upsrc = $('.zoom img').attr('src');
    //alert(up_src);
    $('.zoomImg').attr('src','/upload/goods-extra/'+Name);
    $('.zoom img').attr('src','/upload/goods-extra/'+Name);
    //el.children().attr('src',upsrc);

    $('#zoom').zoom();

}