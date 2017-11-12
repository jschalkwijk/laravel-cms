/**
 * Created by jorn on 11-11-17.
 */

var model = {
    replyBox : function(comment){
        var form = document.createElement('form');;
        var textarea = document.createElement('textarea');
        var submit = document.createElement('button');
        submit.type = 'submit';
        submit.name = 'submitReply';
        submit.innerHTML = 'Add Reply';
        submit.className = 'btn btn-info btn-circle text-uppercase';

        form.appendChild(textarea);
        form.appendChild(submit);
        form.action = '/admin/post/';
        form.method = 'POST';
        comment.appendChild(form);
    }
};
var view = {
};

var controller = {
    actions : function(){
        var replies = document.getElementsByClassName('reply');

        for(var i = 0; i < replies.length; i++) {
            (function(i){
                var reply = replies[i];
                var comment = reply.parentElement;

                reply.onclick = function () {
                    model.replyBox(comment);
                    reply.onclick = null;
                };
            })(i);
        }
    }
};

window.onload = init;

function init(){
    controller.actions();
}