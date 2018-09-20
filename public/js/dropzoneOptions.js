/**
 * Created by jorn on 19-09-18.
 */
Dropzone.options.dropzone = {
    uploadMultiple: true,
    paramName: "files",
    dictDefaultMessage: "Drop files here or click to upload",
    init: function () {
        this.on("success", function (file, response) {
            this.removeAllFiles(file);
            console.log(response);
            if(response['reload']){
                location.reload();
            } else {
                console.log('dont reload');
            }

        })
    }
};