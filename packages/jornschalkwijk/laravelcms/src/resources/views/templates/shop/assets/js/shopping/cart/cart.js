/**
 * Created by jorn on 08-12-18.
 */

function requestStatusError(x, e) {
    if (x.status === 0) {
        alert('You are offline!!\n Please Check Your Network.');
    } else if (x.status === 404) {w
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
        cart: $('#cart'),
        quantity: $('.quantity'),
        empty: $('#empty'),
        remove: $('.remove'),
        refresh: $('#refresh'),
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
            url: "/cart/update",
            method: 'post',
            cache: false,
            data:$(form).serialize(),
            success: function (result) {
                if(result.success === true){
                    $('#cart').html(result.html);
                    if(result.success) {
                        console.log(result);
                        console.log(this.data);
                    }
                } else {
                    $('#errors').html(result.message);
                }
            },
            error: function (x, e) {
                requestStatusError(x, e)
            },
        });
    };
    this.remove = function (url,e) {
        e.preventDefault();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'get',
            cache: false,
            success: function (result) {
                if(result.success === true){
                    $('#cart').html(result.html);
                    if(result.success) {
                        console.log(result);
                    }
                } else {
                    $('#errors').html(result.message);
                }
            },
            error: function (x, e) {
                requestStatusError(x, e)
            },
        });
    };
    this.empty = function (url) {
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'get',
            cache: false,
            success: function (result) {
                if(result.success === true){
                    $('#cart').html(result.html);
                } else {
                    $('#errors').html(result.message);
                }
            },
            error: function (x, e) {
                requestStatusError(x, e)
            },
        });
    };
    this.refresh = function (url) {
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: url,
            method: 'get',
            cache: false,
            success: function (result) {
                if(result.success === true){
                    $('#cart').html(result.cart);
                    $('#cart-summary').html(result.summary);
                    $('select').niceSelect();
                } else {
                    $('#errors').html(result.message);
                }
            },
            error: function (x, e) {
                requestStatusError(x, e)
            },
        });
    };
    this.opt.cart.on('change','form > .quantity',function (e) {
        e.preventDefault();
        _this.update($(this).parent('form'),e);
    });
    this.opt.cart.on('click','.remove',function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        _this.remove(url,e);
    });
    this.opt.empty.on('click',function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        _this.empty(url,e);
    });
    this.hideUpdate = function(){
        //remove update button when javascript is enabled
        $(".update").hide();
    };
    this.opt.refresh.on('click',function (e) {
        e.preventDefault();
        let url = $(this).attr("href");
        _this.refresh(url);
    });
}
function CartInit() {
    new Cart();
}
addLoadEvent(CartInit);