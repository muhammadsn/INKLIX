$(function () {

    var pst =  $('#post-viewer');
    var follow = false;
    var like_link ='';


    pst.hide();

    $('.post-prev').on('click', function () {
       pst.fadeIn(500);
       let _img = $(this).children('img').clone();
       let _title = $(this).children('.overlay').children('span').clone();
       let _text = $(this).children('p').clone();
       let _likes = $(this).children('div#like_count').clone();
       let _trusts = $(this).children('div#trust_count').clone();
       var like_link =  $(this).children('div#like_addr').clone();
       $("#img-view").html(_img);
       $('#post-title').text(_title.text());
       $('#post-text').text(_text.text());
       $('span.likes').text(_likes.text());
       $('span.trusts').text(_trusts.text());
    });

    $('.like').on('click', function () {
        let url = like_link;
        console.log(url);
        $.get(url)
    });

    $('.modal-bg').on('click', function () {
       pst.fadeOut(500);
    });

    $('.close-modal').on('click', function () {
       pst.fadeOut(500);
    });

    $('#follow-bottom').on('click', function () {
        if (follow == false) {
            $(this).removeAttr('class').addClass('nav-bottom-success nav-bottom').text('Following');
            follow = true;
        }
        else{
            $(this).removeAttr('class').addClass('nav-bottom').text('Follow');
            follow = false;
        }
    });


    //====================Clodinary=======================

    var img_url = '';
    $.cloudinary.config({"api_key":"365831583263688","cloud_name":"inklix", 'api_secret':'GMBldNex7eV7bV3mqe3xOgtzWgU'});

    if($.fn.cloudinary_fileupload !== undefined) {
        $("input.cloudinary-fileupload[type=file]").cloudinary_fileupload();
        $('.cloudinary-fileupload').bind('cloudinarydone', function(e, data) {
            img_url = data['result']['url'];
            $('.post-prev').html('<img src="'+img_url+'">');
            return true;
        });
    }

    $('.image-upload .post-prev').on('click', function () {
        $('#image').val(img_url);
    });


});