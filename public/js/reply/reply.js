/**
 * Created by jorn on 11-11-17.
 */

var model = {
    replyBox : function(comment){

        var method = document.createElement('input');
        method.type = 'hidden';
        method.name = '_method';
        method.value = 'POST';

        var token = document.createElement('input');
        token.type = 'hidden';
        token.name = '_token';
        // the csrf_token is generated on the php view and set to this javascript variable which we can use in this script.
        token.value = csrf_token;
        var textarea = document.createElement('textarea');
        textarea.name = 'content';
        textarea.className = 'form-control';
        textarea.rows = 5;

        var commentID = document.createElement('input');
        commentID.value = this.commentID(comment);
        commentID.type = 'hidden';
        commentID.name = 'comment_id';

        var submit = document.createElement('button');
        submit.type = 'submit';
        submit.name = 'submitReply';
        submit.innerHTML = 'Add Reply';
        submit.className = 'btn btn-info btn-circle text-uppercase';

        var postID = window.location.pathname.match(/[0-9]+/)[0];

        var form = document.createElement('form');
        form.appendChild(method);
        form.appendChild(token);
        form.appendChild(textarea);
        form.appendChild(commentID);
        form.appendChild(submit);
        form.action = 'http://laravelcms.app/admin/replies';
        form.method = 'post';

        comment.appendChild(form);
    },
    commentID : function (comment) {
        var classes = comment.classList;
        var regX = /^comment-[0-9]+$/;
        for (var i = 0; i < classes.length; i++){
            if(classes[i].match(regX)){
                var commentID = classes[i].split('comment-').pop();
                console.log(commentID);
            }
        }
        return commentID;
    }
};

var controller = {
    actions : function(){
        var replies = document.getElementsByClassName('reply');

        for(var i = 0; i < replies.length; i++) {
            (function(i){
                var reply = replies[i];
                var comment = reply.parentElement;
                var toggle = false;

                reply.onclick = function () {
                    if (!toggle){
                        model.replyBox(comment);
                        toggle = true;
                    } else {
                        comment.getElementsByTagName('form')[0].remove();
                        // reply.onclick = null;
                        toggle = false;
                    }
                };
            })(i);
        }
    }
};

window.onload = init;

function init(){
    controller.actions();
}