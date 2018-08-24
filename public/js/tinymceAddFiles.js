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
                search: $('#search').val(),
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
}
addLoadEvent(mce);

//
// $('#result').click(function (e) {
//     /* When using checkboxes*/
//     // console.log("hello");
//     // // e.target is the clicked element!
//     // if ($(event.target).hasClass('image')) {
//     //     // List item found!  Output the ID!
//     //
//     //     insertImages(e.target.name,null);
//     // }
//     // if (event.altKey) {
//     //     e.preventDefault();
//     //     if ($(event.target).hasClass('image')) {
//     //         // List item found!  Output the ID!
//     //
//     //         insertImages(e.target.name,null);
//     //     }
//     // }
//
//     if(e.target.id === 'add-multiple'){
//     /* When using checkboxes*/
//             // var string;
//             // var path;
//             // var thumb;
//             // var checked = document.getElementsByName("checkbox[]");
//             // // loop over them all
//             // for (var i = 0; i < checked.length; i++) {
//             //     if (checked[i].checked) {
//             //         string = checked[i].value.split("#");
//             //         thumb = string[0];
//             //         console.log("thumb: "+thumb);
//             //         path = string[1];
//             //         console.log("path: "+path);
//             //         insertImages(path,thumb);
//             //     }
//             // }
//         /* When using Image Picker*/
//             var images = [];
//             $.each($("select#image-selector option:selected"), function(){
//                 console.log("hello");
//                 images.push($(this).val());
//             });
//             insertImages(images,null);
//
//     }
// });
// After ajax call we need to use the on.() methodt call on click
// if(document.getElementById("add-multiple")) {
//     var string;
//     var path;
//     var thumb;
//     document.getElementById("add-multiple").addEventListener("click", function (e) {
//         var checked = document.getElementsByName("checkbox[]");
//         // loop over them all
//         for (var i = 0; i < checked.length; i++) {
//
//             if (checked[i].checked) {
//                 string = checked[i].value.split("#");
//                 thumb = string[0];
//                 console.log("string: "+thumb);
//                 path = string[1];
//                 console.log("path: "+path);
//                 insertImages(path,thumb);
//             }
//         }
//     });
//     console.log("multiple")
// }