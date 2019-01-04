/**
 * Created by jorn on 19-09-18.
 */
Dropzone.options.dropzone = {
    uploadMultiple: true,
    maxFiles:20,
    parallelUploads:20,
    paramName: "files",
    dictDefaultMessage: "Drop files here or click to upload",
    init: function () {
        this.on("completemultiple", function (file) {
            console.log(JSON.parse(file[0].xhr.responseText)['reload']);
            if($('input[name="reload"]').val() === 1){
                location.reload();
            } else {
                this.removeAllFiles(file);
                // console.log('/admin/file-manager/folders/'+$('#dropzone').find("input[name='parent']").val());
                fileManager.folder('http://laravelcms.test/admin/folders/'+$('#dropzone').find("input[name='parent']").val(),true);
            }
        })
    }
};