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

    const gallery = $('#gallery');
    const errors = $('#errors');
    const selectedGallery = $('#selected-gallery');
    const searchResults = $('#search-results');;

    searchResults.on("click","#add-multiple",function () {
        const images = [];
        console.log("hello");
        $.each($("select#image-selector option:selected"), function(){
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
                searchResults.html(result.html);
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
                    selectedGallery.html(result.html);
                    $("#gallery-image-selector").imagepicker();
                    $.each($(".image_picker_image"),function () {
                        $(this).addClass('image');
                    });
                }
            }
        });
    }).change();

    selectedGallery.on('click','#add-to-gallery',function (e) {
        e.preventDefault();
        const images = [];
        $.each($("select#image-selector option:selected"), function(){
            images.push($(this).attr('id'));
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/galleries/add",
            method: 'post',
            data: {
                gallery_id: gallery.val(),
                images: images
            },
            success: function (result) {
                if(result.success) {
                    // Get the updated galley from the DB with an ajax request inside this request.
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
                                selectedGallery.html(result.html);
                                $("#gallery-image-selector").imagepicker();
                                $.each($(".image_picker_image"),function () {
                                    $(this).addClass('image');
                                });
                                errors.html('<div class="alert alert-success">Gallery Updated</div>');
                            } else {
                                errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                            }
                        }
                    });
                } else {
                    errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                }
            }
        });
    });

    selectedGallery.on('click','#remove-from-gallery',function (e) {
        console.log('hello');
        e.preventDefault();
        const images = [];
        $.each($("select#gallery-image-selector option:selected"), function(){
            images.push($(this).attr('id'));
        });
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/galleries/remove",
            method: 'post',
            data: {
                gallery_id: gallery.val(),
                images: images
            },
            success: function (result) {
                if(result.success) {
                    // Get the updated galley from the DB with an ajax request inside this request.
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
                                selectedGallery.html(result.html);
                                $("#gallery-image-selector").imagepicker();
                                $.each($(".image_picker_image"),function () {
                                    $(this).addClass('image');
                                });
                                errors.html('<div class="alert alert-success">Gallery Updated</div>');
                            } else {
                                errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                            }
                        }
                    });
                } else {
                    errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                }
            }
        });
    });
}
addLoadEvent(mce);