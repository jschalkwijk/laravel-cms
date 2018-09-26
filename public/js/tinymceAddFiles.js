/**
 * Created by jorn on 14-08-18.
 */

function fileManager(){
   const manager = new FileManager({color:'blue'});
    handleFileManager(manager);

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

function FileManager (opt = {}){
    let defaults = {
        gallery: $('#gallery'),
        errors: $('#errors'),
        selectedGallery: $('#selected-gallery'),
        searchResults: $('#search-results'),
    // define the DOM element buttons we use for our click events
        searchFile: $('#search-file'),
        addGallery: $('#add-gallery'),
    };
    let options = Object.assign({}, defaults, opt);
    // define this object to a var so we can use it in our event handlers.
    const FileManager = this;
    // define the needed DOM elements we use.
    this.gallery = $('#gallery');
    this.errors = $('#errors');
    this.selectedGallery = $('#selected-gallery');
    this.searchResults = $('#search-results');
    // define the DOM element buttons we use for our click events
    this.searchFile = $('#search-file');
    this.addGallery = $('#add-gallery');

    this.search = function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/file-manager/search",
            method: 'post',
            data: {
                search: $('#search').val()
            },
            success: function (result) {
                FileManager.selectedGallery.html(result.html);
                // call image picker after adding the result, otherwise the script won't load.
                $("#image-selector").imagepicker();
                $.each($(".image_picker_image"),function () {
                    $(this).addClass('image');
                });
            }
        });
    };
    this.addFileToEditor = function(){
        let images = [];
        console.log("hello");
                $.each($("select#image-selector option:selected"), function () {
                    images.push($(this).val());
                });
                insertImages(images, null);
            }
    ;
    this.addGalleryToEditor = function (e) {
        e.preventDefault();
        console.log(Number($('#gallery').val()));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/file-manager/add-gallery",
            method: 'post',
            data: {
                gallery: Number(gallery.val())
            },
            success: function (result) {
                console.log(result.html);
                insertGallery(result.html);
            }
        });
    };
    // Event Handlers
    this.searchFile.click( function(e){FileManager.search(e);});
    this.selectedGallery.on("click","#add-multiple",function () {
        FileManager.addFileToEditor();
    });
    this.addGallery.click(function (e) {
        FileManager.addGalleryToEditor(e)
    });
}
function handleFileManager(manager) {

    const gallery = $('#gallery');
    const errors = $('#errors');
    const selectedGallery = $('#selected-gallery');
    const searchResults = $('#search-results');



    $('#create-gallery').click(function (e) {
        e.preventDefault();


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/file-manager/create-gallery",
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
            url: '/admin/file-manager/gallery/' + gallery.val(),
            method: 'get',
            success: function (result) {
                if (result.success) {
                    selectedGallery.html(result.html);
                    $("#gallery-image-selector").imagepicker();
                    $.each($(".image_picker_image"),function () {
                        $(this).addClass('image');
                    });
                } else {
                    console.log(result.html);
                }
            }
        });
    });

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
            url: "/admin/file-manager/add-to-gallery",
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
                        url: '/admin/file-manager/gallery/' + gallery.val(),
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
            url: "/admin/file-manager/remove-from-gallery",
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
                        url: '/admin/file-manager/gallery/' + gallery.val(),
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

    const folders = $('#folders');
    /*Folders*/
    folders.on('click','a',function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        let parts = url.split("/");
        if(parts[parts.length-1] === '0'){
            url = '/admin/file-manager/folders';
            $.ajax({
                url:url,
                method: 'GET',
                success: function (result) {
                    if(result.success) {
                        folders.html(result.html);
                    } else {
                        errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                    }
                },
                error:function(x,e) {
                    if (x.status==0) {
                        alert('You are offline!!\n Please Check Your Network.');
                    } else if(x.status==404) {
                        alert('Requested URL not found.');
                    } else if(x.status==500) {
                        alert('Internel Server Error.');
                    } else if(e=='parsererror') {
                        alert('Error.\nParsing JSON Request failed.');
                    } else if(e=='timeout'){
                        alert('Request Time out.');
                    } else {
                        alert('Unknow Error.\n'+x.responseText);
                    }
                }
            });
        } else {
            const back = $("#currentUrl").html();
            $.ajax({
                url:url,
                method: 'GET',
                success: function (result) {
                    console.log(result);
                    if(result.success) {
                        folders.html(result.html);
                        $('#back').attr("href",back);
                        $("#dropzone").dropzone();
                        $('#image-folder-selector').imagepicker();
                    } else {
                        errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                    }
                }
            });
        }
        return false;

    })
}
addLoadEvent(fileManager);