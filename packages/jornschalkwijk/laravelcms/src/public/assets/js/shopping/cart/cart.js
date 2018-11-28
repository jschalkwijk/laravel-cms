/**
 * Created by jorn on 08-12-18.
 */

function Cart(options = {}) {
    const _this = this;
    this.cache = new Cache({});
    // Default values
    this.defaults = {
    };
    this.update = function (e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/cart/update",
            method: 'post',
            data: {
                product: this.$('[name="product_id"]').val(),
                quantity: this.$('[name="quantity"]').val()
            },
            success: function (result) {
                // _this.opt.searchResults.html(result.html);
                // // call image picker after adding the result, otherwise the script won't load.
                // $("#image-search-selector").imagepicker();
                // $.each($(".image_picker_image"), function () {
                //     $(this).addClass('image');
                // });
            }
        });
    };
    $('[name="update"]').click(function (e) {
        e.preventDefault();
        console.log('update clicked');
        // _this.update(e);
        });

}