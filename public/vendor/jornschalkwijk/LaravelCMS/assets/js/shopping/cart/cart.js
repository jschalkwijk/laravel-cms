/**
 * Created by jorn on 08-12-18.
 */

function requestStatusError(x, e) {
    if (x.status === 0) {
        alert('You are offline!!\n Please Check Your Network.');
    } else if (x.status === 404) {
        alert('Requested URL not found.');
    } else if (x.status === 500) {
        alert('Internel Server Error.');
    } else if (e === 'parsererror') {
        alert('Error.\nParsing JSON Request failed.');
    } else if (e === 'timeout') {
        alert('Request Time out.');
    } else {
        alert('Unknow Error.\n' + x.responseText);
    }
}

function Cart(options = {}) {
    const _this = this;
    // this.cache = new Cache({});
    // Default values
    this.defaults = {
        update: $('.update'),
        form: $('form'),
        table: $('#cart-table'),
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
            cache: false,
            data:$(form).serialize(),
            success: function (result) {
                $('#cart').html(result.html);
                if(result.success) {
                    console.log(result);
                    console.log(this.data);
                }
            },
            error: function (x, e) {
                requestStatusError(x, e)
            },
        });
    };
    $('#cart').on('change','form > .quantity',function (e) {
        e.preventDefault();
        _this.update($(this).parent('form'),e);
    });
}


function CartController(cart) {
    console.log('hello');

    // $('#cart').find('form').on('change',cart.opt.quantity,function (e) {
    //     e.preventDefault();
    //     cart.update(this,e);
    // });
    $('#cart').on('submit','form',function (e) {
        e.preventDefault();
        cart.update($(this).find('form'),e);
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