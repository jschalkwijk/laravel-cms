/**
 * Created by jorn on 19-09-18.
 */
Dropzone.options.dropzone = {
    uploadMultiple: true,
    paramName: "files",
    dictDefaultMessage: "Drop files here or click to upload",
    init: function () {
        this.on("complete",function (file,response) {
           console.log(file,response);
        });
        this.on("completemultiple", function (files) {
            this.removeAllFiles(files);
                // console.log('/admin/file-manager/folders/'+$('#dropzone').find("input[name='parent']").val());
                fileManager.folder('http://laravelcms.test/admin/folders/'+$('#dropzone').find("input[name='parent']").val(),true);


        });
    }
};