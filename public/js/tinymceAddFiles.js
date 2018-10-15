/**
 * Created by jorn on 14-08-18.
 * FileManger Package
 */


Array.prototype.empty = function () {
    if (typeof this !== 'undefined' && this.length > 0) {
        return false;
    } else {
        return true;
    }
};

function requestStatusError(x, e) {
    if (x.status === 0) {
        alert('You are offline!!\n Please Check Your Network.');
    } else if (x.status === 404) {
        alert('Requested URL not found.');
    } else if (x.status === 500) {
        alert('Internel Server Error.');
    } else if (e === 'parsererror') {
        alert('Error.\nParsing JSON Request failed.');
    } else if (e === 'timeout') {
        alert('Request Time out.');
    } else {
        alert('Unknow Error.\n' + x.responseText);
    }
}

function FileManager(options = {}) {
    // define this object to a var so we can use it in our event handlers.

    const _this = this;
    this.cache = new Cache('cache');
    // Default values
    this.defaults = {
        errors: $('#errors'),
        searchFile: $('#search-file'),
        searchResults: $('#search-results'),
        searchResultsSelector:$('#image-search-selector'),
        gallery: $('#gallery'),
        selectedGallery: $('#selected-gallery'),
        addGallery: $('#add-gallery'),
        addToGallery: $('#add-to-gallery'),
        removeFromGallery: $('#remove-from-gallery'),
        createGallery: $('#create-gallery'),
        folders: $('#folders'),
    };
    // merge values from the options object to the defaults object and create new object
    this.opt = Object.assign({}, this.defaults, options);

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
                _this.opt.searchResults.html(result.html);
                // call image picker after adding the result, otherwise the script won't load.
                $("#image-search-selector").imagepicker();
                $.each($(".image_picker_image"), function () {
                    $(this).addClass('image');
                });
            }
        });
    };

    this.addFileToEditor = function (thumb = null) {
        let images = [];

        console.log("hello");
        $.each($("select#image-search-selector option:selected"), function () {
            images.push($(this).val());
        });

        if (thumb === null) {
            if (Array.isArray(images)) {
                for (var i = 0; i < images.length; i++) {
                    tinyMCE.execCommand('mceInsertRawHTML', false, '<a href=' + images[i] + '><img src=' + images[i] + ' width=100%></a>');
                }
            } else {
                tinyMCE.execCommand('mceInsertRawHTML', false, '<a href=' + images + '><img src=' + images + ' width=100%></a>');
            }
        } else {
            tinyMCE.execCommand('mceInsertRawHTML', false, '<a href=' + images + '><img src=' + thumb + '></a>');
        }

    };

    this.showGallery = function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: '/admin/file-manager/gallery/' + _this.opt.gallery.val(),
            method: 'get',
            success: function (result) {
                if (result.success) {
                    _this.opt.selectedGallery.html(result.html);
                    $("#gallery-image-selector").imagepicker();
                    $.each($(".image_picker_image"), function () {
                        $(this).addClass('image');
                    });
                } else {
                    console.log(result.html);
                }
            }
        });
    };

    this.addImageToGallery = function (e) {
        e.preventDefault();
        const images = [];
        $.each($("select#image-search-selector option:selected"), function () {
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
                gallery_id: _this.opt.gallery.val(),
                images: images
            },
            success: function (result) {
                if (result.success) {
                    // Get the updated galley from the DB with an ajax request inside this request.
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/admin/file-manager/gallery/' + _this.opt.gallery.val(),
                        method: 'get',
                        success: function (result) {
                            if (result.success) {
                                _this.opt.selectedGallery.html(result.html);
                                $("#gallery-image-selector").imagepicker();
                                $.each($(".image_picker_image"), function () {
                                    $(this).addClass('image');
                                });
                                _this.opt.errors.html('<div class="alert alert-success">Gallery Updated</div>');
                            } else {
                                _this.opt.errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                            }
                        }
                    });
                } else {
                    _this.opt.errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                }
            }
        });
    };

    this.removeImageFromGallery = function (e) {
        e.preventDefault();
        const images = [];
        $.each($("select#gallery-image-selector option:selected"), function () {
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
                gallery_id: _this.opt.gallery.val(),
                images: images
            },
            success: function (result) {
                if (result.success) {
                    // Get the updated galley from the DB with an ajax request inside this request.
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: '/admin/file-manager/gallery/' + _this.opt.gallery.val(),
                        method: 'get',
                        success: function (result) {
                            if (result.success) {
                                _this.opt.selectedGallery.html(result.html);
                                $("#gallery-image-selector").imagepicker();
                                $.each($(".image_picker_image"), function () {
                                    $(this).addClass('image');
                                });
                                _this.opt.errors.html('<div class="alert alert-success">Gallery Updated</div>');
                            } else {
                                _this.opt.errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                            }
                        }
                    });
                } else {
                    _this.opt.html('<div class="alert alert-warning">Oops something went wrong</div>');
                }
            }
        });
    };

    this.insertGalleryIntoEditor = function (html) {
        tinyMCE.execCommand('mceInsertRawHTML', false, html);
    };
    this.addGalleryToEditor = function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/file-manager/add-gallery",
            method: 'post',
            data: {
                gallery: Number(_this.opt.gallery.val())
            },
            success: function (result) {
                _this.insertGalleryIntoEditor(result.html);
            }
        });
    };

    this.createGallery = function (e) {
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
                if (result.success) {
                    // Update options
                    _this.opt.gallery.append($('<option>', {
                        value: result.gallery['gallery_id'],
                        text: result.gallery['name']
                    }));
                    _this.opt.errors.html('<div class="alert alert-success">' + 'Gallery ' + result.gallery['name'] + ' created ' + '</div>');
                } else {
                    _this.opt.errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                }
            }
        });
    };
    // Folders
    this.folder = function (requestUrl, update = false) {
        let url = requestUrl;
        let parts = requestUrl.split("/");

        console.log(url);
        // console.log(Cache.cache);

        if (parts[parts.length - 1] === '0') {
            url = '/admin/file-manager/folders';
        }
        const back = $("#currentUrl").html();
        $.ajax({
            url: url,
            method: 'GET',
            cache: true,
            ifModified: true,
            beforeSend: function () {
                let cached = _this.cache.get('url',requestUrl);
                if (cached && !update) {
                    _this.opt.folders.html(cached.html);
                    $("#dropzone").dropzone();
                    $('#image-folder-selector').imagepicker();
                    return false;
                }
                $("#wait").css("display", "block");
                return true;
            },
            success: function (result) {
                console.log(result);
                if (result.success) {
                    // Add visited page to the _this Cache array so when we go back to this page again no ajax request for data is required.
                    _this.opt.folders.html(result.html);
                    _this.cache.set({url: requestUrl, html: result.html},'url');
                    $('#back').attr("href", back);
                    $("#dropzone").dropzone();
                    $('#image-folder-selector').imagepicker();
                } else {
                    _this.opt.errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                }
            },
            error: function (x, e) {
                requestStatusError(x, e)
            },
        });
    };

    this.upload = function (e,url,formData) {
        $.ajax({
            url: url,
            method:'post',
            //When using FormData to parse the form the below settings need to be false otherwise it wont work.
            processData: false,
            contentType: false,
            data: formData,
            beforeSend: function () {
                $("#wait").css("display", "block");
            },
            complete: function () {
                $("#wait").css("display", "none");
            },
            success: function (result) {
                console.log(result);
                if(result.success && !result['reload']){
                    _this.folder('http://laravelcms.test/admin/folders/'+$('#upload').find("input[name='parent']").val(),true);
                } else if(result.success && result['reload']){
                    location.reload();
                } else {
                    _this.opt.errors.html('<div class="alert alert-warning">Oops something went wrong</div>');
                }
            },
            error: function (x, e) {
                requestStatusError(x, e)
            },
        })
    }
}

function FileManagerController(fileManager) {
    // Event Handlers
    fileManager.opt.searchFile.click(function (e) {
        fileManager.search(e);
    });

    fileManager.opt.searchResults.on("click", "#add-from-search", function (e) {
        e.preventDefault();
        fileManager.addFileToEditor();
    });

    fileManager.opt.addGallery.click(function (e) {
        fileManager.addGalleryToEditor(e)
    });

    fileManager.opt.createGallery.click(function (e) {
        fileManager.createGallery(e);
    });

    fileManager.opt.gallery.change(function (e) {
        fileManager.showGallery(e);
    });

    fileManager.opt.selectedGallery.on('click', fileManager.opt.addToGallery, function (e) {
        fileManager.addImageToGallery(e);
    });

    fileManager.opt.selectedGallery.on('click', fileManager.opt.removeFromGallery, function (e) {
        fileManager.removeImageFromGallery(e);
    });

    /*Folders*/
    fileManager.opt.folders.on('click', 'a', function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        fileManager.folder(url);
    });

    fileManager.opt.folders.on('submit','#upload',function (e) {
        e.preventDefault();
        let url = $(this).attr("action");
        let formData = new FormData(document.getElementById('upload'));
        fileManager.upload(e,url,formData);
    });
    fileManager.opt.folders.on('click','#add-from-folder',function (e) {
        e.preventDefault();
        fileManager.addFileToEditor();
    });
}

var Cache = function(name){
    const _this = this;
    this.name = name;
    this.cache = function () {
        return JSON.parse(sessionStorage.getItem(this.name));
    };

    (function init() {
        if (sessionStorage) {
            if (!sessionStorage.getItem(_this.name)) {
                // Store data
                let cache = [];
                sessionStorage.setItem(_this.name, JSON.stringify(cache));
            }
            console.log('init');
        } else {
            alert("Sorry, your browser do not support session storage.");
        }
    }());

    this.get = function (key, value) {
        // Finds an object in the cache array where the objects url == the given one and returns the object or undefined
        // let cache = [{url: "test",html:"html"}];
        // sessionStorage.setItem("cache", JSON.stringify(cache));
        // let cache2 = JSON.parse(sessionStorage.getItem("cache"));
        // console.log(cache2);
        // return cache2.find(obj => (obj.url === 'test')) || false;
        if (sessionStorage.getItem(this.name)) {
            let cache = this.cache();
            console.log(cache);
            // sessionStorage.setItem(this.name, JSON.stringify([]));
            if (cache.find(obj => (obj[key] === value)) !== undefined) {
                return cache.find(obj => (obj[key] === value));
            } else {
                return false;
            }
        }
    };

    this.set = function (values = {}, referenceKey) {
        // remove value from array which has this reference value
        this.unset(referenceKey,values[referenceKey]);
        // Get current stored array and update with new data
        let updatedCache = this.cache();
        updatedCache.push(values);
        //overwrite the old array with the update array
        sessionStorage.setItem(this.name, JSON.stringify(updatedCache));
        console.log(this.cache());
    };

    this.unset = function (key,value) {
        let cache = JSON.parse(sessionStorage.getItem(this.name));
        let removeIndex = cache.map(function (item) {
            return item[key];
        }).indexOf(value);// get index of object with url given
        if (removeIndex === -1) {
            removeIndex = 0;
            return false;
        }
        cache.splice(removeIndex, 1);
        sessionStorage.setItem(this.name, JSON.stringify(cache));
    };

    this.reset = function () {
        sessionStorage.setItem(this.name, JSON.stringify([]));
    };
};

var fileManager = new FileManager();
FileManagerController(fileManager);

// addLoadEvent();
