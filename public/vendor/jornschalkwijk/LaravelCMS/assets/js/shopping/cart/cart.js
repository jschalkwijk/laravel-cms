/**
 * Created by jorn on 08-12-18.
 */

function Cart(options = {}) {
    const _this = this;
    // this.cache = new Cache({});
    // Default values
    this.defaults = {
        update: $('.update'),
        form: $('form'),
        quantity: $('.quantity'),
    };
    // merge values from the options object to the defaults object and create new object
    this.opt = Object.assign({}, this.defaults, options)
    this.update = function (form,e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "/admin/cart/update",
            method: 'post',
            data:$(form).serialize(),
            success: function (result) {
                // _this.opt.searchResults.html(result.html);
                // // call image picker after adding the result, otherwise the script won't load.
                // $("#image-search-selector").imagepicker();
                // $.each($(".image_picker_image"), function () {
                //     $(this).addClass('image');
                // });
                console.log(result)
            }
        });
    };
}


function CartController(cart) {
    console.log('hello');

    cart.opt.form.on('change',cart.opt.quantity,function (e) {
        e.preventDefault();
        cart.update(this,e);
    });
    cart.opt.form.on('submit',function (e) {
        e.preventDefault();
        cart.update(this,e);
    });

}
function CartInit() {
    // $('#test').click(function (e) {
    //     e.preventDefault();
    //     console.log('update clicked');
    //     // cart.update(e);
    // });
    var cart = new Cart();
    CartController(cart);
}
addLoadEvent(CartInit);