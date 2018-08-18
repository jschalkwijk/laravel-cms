/**
 * Created by jorn on 14-08-18.
 */

function mce(){
    handleImagesAdding();
}

function insertImages(path,thumb) {
    if(thumb === null) {
        tinyMCE.execCommand('mceInsertRawHTML', false, '<a href='+ path +'><img src=' + path + ' width=100%></a>');
    } else {
        tinyMCE.execCommand('mceInsertRawHTML', false, '<a href='+ path +'><img src=' + thumb + '></a>');
    }
}

function handleImagesAdding() {

    $('#add-image').click(function (e) {
        console.log("hello");

        // e.target is the clicked element!
        // If it was a list item
        if (e.target && $(event.target).hasClass('files')) {
            // List item found!  Output the ID!
            insertImages(e.target.name,null);
        }
    });


    if(document.getElementById("add-multiple")) {
        var string;
        var path;
        var thumb;
        document.getElementById("add-multiple").addEventListener("click", function (e) {
            var checked = document.getElementsByName("checkbox[]");
            // loop over them all
            for (var i = 0; i < checked.length; i++) {

                if (checked[i].checked) {
                    string = checked[i].value.split("#");
                    thumb = string[0];
                    console.log("string: "+thumb);
                    path = string[1];
                    console.log("path: "+path);
                    insertImages(path,thumb);
                }
            }
        });
    }

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
                search: $('#search').val(),
            },
            success: function (result) {
                $('#result').html(result.html);
                // call image picker after adding the result, otherwise the script won't load.
                $("select").imagepicker();
            }
        });
    });
}

addLoadEvent(mce);
