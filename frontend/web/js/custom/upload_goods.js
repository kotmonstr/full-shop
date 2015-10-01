function sendfile() {
    var fd = new FormData(document.getElementById("form-send-file"));
    fd.append("CustomField", "This is some extra data");
    $.ajax({
        url: "/goods/submit",
        type: "POST",
        data: fd,
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType
        //beforeSend: function (xhr) {
        //    jpreloader('show');
        //},
        success: function (data) {
            //$('#goods-image_file').html(data.imageName);

            $('.target_image').attr('src', '/upload/goods/' + data.imageName)
            $('.new_image').val(data.imageName);
        }
    })

    ;
    /* Preloader */
    function jpreloader(item) {
        if (item == 'show') {
            $(document.body).append('<div class="back_background jpreloader" style="z-index: 90000;"></div>');
        } else {
            $('.jpreloader').remove();
        }
    }

}

function uploadExtraImage(id) {
    //alert(id);
    var fd = new FormData(document.getElementById("form-send-file"));
    fd.append("id", id);
    $.ajax({
        url: "/goods/upload-extra-image",
        type: "POST",
        data: fd,
        processData: false, // tell jQuery not to process the data
        contentType: false, // tell jQuery not to set contentType

        success: function (data) {
            if (data.limit) {
                //ToDo cистемное сообщение
                $('#system').css('opacity', '1').show(),$('.layout').show();
                $('#system .modal-body p').html(data.limit);
            }

            if (data.a) {

                $('.field-goods-new_image').append('<img src="/' + data.a + '" alt="" width="100px" height="100px" style="display:inline"><div onclick="del-image('+data.a_id+')" class="del-image">X</div>');
            }
            if (data.b) {
                $('.field-goods-new_image').append('<img src="/' + data.b + '" alt="" width="100px" height="100px" style="display:inline"><div onclick="del-image('+data.b_id+')" class="del-image">X</div>');
            }
            if (data.c) {
                $('.field-goods-new_image').append('<img src="/' + data.c + '" alt="" width="100px" height="100px" style="display:inline"><div onclick="del-image('+data.c_id+')" class="del-image">X</div>');
            }
            if (data.d) {
                $('.field-goods-new_image').append('<img src="/' + data.d + '" alt="" width="100px" height="100px" style="display:inline"><div onclick="del-image('+data.d_id+')" class="del-image">X</div>');
            }
            if (data.e) {
                $('.field-goods-new_image').append('<img src="/' + data.e + '" alt="" width="100px" height="100px" style="display:inline"><div onclick="del-image('+data.e_id+')" class="del-image">X</div>');
            }

        }
    })


}