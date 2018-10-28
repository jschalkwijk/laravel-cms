/**
 * Created by jorn on 16-09-18.
 */
/* Selectize.js for adding tags on the fly */
$(function() {
    $('.prettyTags').selectize({
        plugins: ['remove_button'],
        delimiter: ',',
        create: function(input,callback) {
            console.log(input);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '/admin/tags',
                method: 'post',
                data: {
                    title: input,
                    tag_type:'post'
                },
                success: function (result) {
                    if (result.success) {
                        console.log(result.tag['tag_id']);
                        return callback( { 'value': result.tag['tag_id'], 'text': input});
                    } else {
                        return {
                            value: input,
                            text: input
                        }
                    }
                }
            });
        }
    });
});