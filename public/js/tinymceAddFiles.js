/**
 * Created by jorn on 14-08-18.
 */

function mce(){
    handleImagesAdding();
}

function insertImages(images,thumb) {
    console.log(images);
    if(thumb === null) {
        if(Array.isArray(images)){
            for (var i = 0; i < images.length; i++) {
                tinyMCE.execCommand('mceInsertRawHTML', false, '<a href=' + images[i] + '><img src=' + images[i] + ' width=100%></a>');
            }
        } else {
            tinyMCE.execCommand('mceInsertRawHTML', false, '<a href=' + images + '><img src=' + images + ' width=100%></a>');
        }
    } else {
        tinyMCE.execCommand('mceInsertRawHTML', false, '<a href='+ images +'><img src=' + thumb + '></a>');
    }
}
function insertGallery(html) {
    tinyMCE.execCommand('mceInsertRawHTML', false, html);
}

function handleImagesAdding() {
    $('#result').on("click","#add-multiple",function () {
        var images = [];
        console.log("hello");
        $.each($("select#image-selector option:selected"), function(){
            console.log("hello");
            images.push($(this).val());
        });
        insertImages(images,null);
    });

    $('#search-file').click(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/uploads/ajax",
            method: 'post',
            data: {
                search: $('#search').val()
            },
            success: function (result) {
                $('#result').html(result.html);
                // call image picker after adding the result, otherwise the script won't load.
                $("#image-selector").imagepicker();
                $.each($(".image_picker_image"),function () {
                   $(this).addClass('image');
                });
            }
        });
    });

    $('#add-gallery').click(function (e) {
        e.preventDefault();
        console.log(Number($('#gallery').val()));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/uploads/gallery",
            method: 'post',
            data: {
                gallery: Number(gallery.val())
            },
            success: function (result) {
                insertGallery(result.html);
            }
        });
    });

    var gallery = $('#gallery');
    var errors = $('#errors');
    var currentGallery= $('#selected-gallery');
    $('#create-gallery').click(function (e) {
        e.preventDefault();


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/galleries",
            method: 'post',
            data: {
                name: $('#name').val()
            },
            success: function (result) {
                if(result.success) {
                    // Update options
                    gallery.append($('<option>', {
                        value: result.gallery['gallery_id'],
                        text: result.gallery['name']
                    }));
                    errors.html('<div class="alert alert-success">'+'Gallery '+result.gallery['name']+' created '+'</div>');
                } else {
                    errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                }
            }
        });
    });

    gallery.change(function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admin/galleries/' + gallery.val(),
            method: 'get',
            success: function (result) {
                if (result.success) {
                    currentGallery.html(result.html);
                }
            }
        });
    }).change();

    $('#add-to-gallery').click(function (e) {
        e.preventDefault();
        var images = [];
        $.each($("select#image-selector option:selected"), function(){
            images.push($(this).attr('id'));
        });
        console.log(images);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/galleries/attach",
            method: 'post',
            data: {
                gallery_id: gallery.val(),
                images: images
            },
            success: function (result) {
                if(result.success) {
                    // Update gallery
                    // for(var i=0;i < result.images.length; i++) {
                    //     currentGallery.append($('<img>', {
                    //         value: result.images[i]['upload_id'],
                    //         text: result.gallery['name']
                    //     }));
                    // }
                    errors.html('<div class="alert alert-success">Gallery Updated</div>');
                } else {
                    errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                }
            }
        });
    });
}
addLoadEvent(mce);