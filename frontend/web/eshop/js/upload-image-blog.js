// Занрузка фотки в один клик
function QuickUploadImage(){
    var fd = new FormData(document.getElementById("form-send-file"));
    $.ajax({
        url: "/blog/quick-upload",
        type: "POST",
        data: fd,
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        success: function (data) {
            $('#blog-image').val(data);
            $('.image_target').html('<img src="/upload/blog/'+ data +'" width="200" height="200" alt="">');
        }
    })
}

