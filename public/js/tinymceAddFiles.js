/**
 * Created by jorn on 14-08-18.
 */


Array.prototype.empty = function () {
    if(typeof this !== 'undefined' && this.length > 0){
        return false;
    } else {
        return true;
    }
};

function requestStatusError(x,e){
        if (x.status === 0) {
            alert('You are offline!!\n Please Check Your Network.');
        } else if(x.status === 404) {
            alert('Requested URL not found.');
        } else if(x.status === 500) {
            alert('Internel Server Error.');
        } else if(e ==='parsererror') {
            alert('Error.\nParsing JSON Request failed.');
        } else if(e ==='timeout'){
            alert('Request Time out.');
        } else {
            alert('Unknow Error.\n'+x.responseText);
        }
}

fileManagerController(new FileManager({color:'blue'}));

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

function FileManager (options = {}){
    // define this object to a var so we can use it in our event handlers.
    const FileManager = this;
    this.cache = [
    ];
    // Default values
    this.defaults = {
        gallery: $('#gallery'),
        errors: $('#errors'),
        selectedGallery: $('#selected-gallery'),
        searchResults: $('#search-results'),
    // define the DOM element buttons we use for our click events
        searchFile: $('#search-file'),
        addGallery: $('#add-gallery'),
        folders: $('#folders'),
    };
    // merge values from the options object to the defaults object and create new object
    this.opt = Object.assign({}, this.defaults, options);

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
                FileManager.opt.selectedGallery.html(result.html);
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
        console.log(Number(FileManager.opt.gallery.val()));
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/file-manager/add-gallery",
            method: 'post',
            data: {
                gallery: Number(FileManager.opt.gallery.val())
            },
            success: function (result) {
                console.log(result.html);
                insertGallery(result.html);
            }
        });
    };
    // Folders
    this.folder = function(requestUrl,update = false){
        let url = requestUrl;
        let parts = requestUrl.split("/");
        let cached = FileManager.getCached(url);
        console.log(url);
        console.log(FileManager.cache);
        console.log(cached);

        if(cached && !update){
            FileManager.opt.folders.html(cached.html);
            $("#dropzone").dropzone();
            $('#image-folder-selector').imagepicker();
            return;
        } else {
            if(parts[parts.length-1] === '0'){
                url = '/admin/file-manager/folders';
            }
            const back = $("#currentUrl").html();
            $.ajax({
                url:url,
                method: 'GET',
                success: function (result) {
                    console.log(result);
                    if(result.success) {
                        FileManager.opt.folders.html(result.html);
                        // Add visited page to the FileManager Cache array so when we go back to this page again no ajax request for data is required.
                        FileManager.addCache(requestUrl,result.html);
                        $('#back').attr("href",back);
                        $("#dropzone").dropzone();
                        $('#image-folder-selector').imagepicker();
                    } else {
                        errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                    }
                },
                error: function(x,e){requestStatusError(x,e)},
            });
        }
    };
    // cache
    this.getCached = function(url){
        // Finds an object in the cache array where the objects url == the given one and returns the object or undefined
        return FileManager.cache.find(obj => (obj.url === url)) || false;
    };
    this.addCache = function (url,html) {
        this.removeCache(url);
        // delete
        if(!this.getCached(url)) {
            this.cache.push({
                url: url,
                html: html,
            });
        }
    };
    this.removeCache = function(url){
        let removeIndex = this.cache.map(function(item) { return item.url; }).indexOf(url);// get index of object with url given
        if( removeIndex === -1 ){
            removeIndex = 0;
            return false;
        }
        this.cache.splice(removeIndex, 1);
    }
}
function fileManagerController(fileManager) {

    const gallery = $('#gallery');
    const errors = $('#errors');
    const selectedGallery = $('#selected-gallery');
    const searchResults = $('#search-results');

    // Event Handlers
    fileManager.opt.searchFile.click( function(e){fileManager.search(e);});
    fileManager.opt.selectedGallery.on("click","#add-multiple",function () {
        fileManager.addFileToEditor();
    });
    fileManager.opt.addGallery.click(function (e) {
        fileManager.addGalleryToEditor(e)
    });
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

    /*Folders*/
    fileManager.opt.folders.on('click','a',function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        fileManager.folder(url);
    })
}
// addLoadEvent();