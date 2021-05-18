$(".quantity-add").on('click', function () {

    var cart_quantity = $(this).closest('span').find('.cart-quantity');
    var current_cart_quantity = cart_quantity.text();
    current_cart_quantity = current_cart_quantity.replace(',', '');
    current_cart_quantity = parseInt(current_cart_quantity);
    cart_quantity.text(current_cart_quantity + 1);

    // 商品小计重新计算
    var cart_subtal = $(this).closest('tr').find('.subtal');
    var cart_price = $(this).closest('tr').find('.unit');
    var current_cart_price = cart_price.text();
    current_cart_price = current_cart_price.replace(',', '');
    current_cart_price = parseInt(current_cart_price);
    var subtal = current_cart_price * (current_cart_quantity + 1);
    cart_subtal.text(subtal);


    var goods_num = $('span.goods_num');
    var current_goods_num = goods_num.text();
    current_goods_num = current_goods_num.replace(',', '');
    current_goods_num = parseInt(current_goods_num);
    goods_num.text(current_goods_num + 1);


    var price_tal = $('span.pricetal');
    var all_subtal = $('.subtal');
    var tal = 0;
    for (var i = 0; i < all_subtal.length; i++) {
        var bento_subtal = $(all_subtal[i]).text();
        bento_subtal = bento_subtal.replace(',', '');
        bento_subtal = parseInt(bento_subtal);
        tal += bento_subtal;
    }
    price_tal.text(tal);


    var bento_id_input = $(this).closest('tr').find('input[name="bento_id"]');
    var bento_id = bento_id_input.val();

    $.ajax({
        url: '/cart-change-quantity',
        type: 'post',
        data: {
            bento_id: bento_id
        },
        dataType: 'json'
    }).done(function (res) {

        console.log(res);
    });
});


$(".quantity-reduce").on('click', function () {



    var cart_quantity = $(this).closest('span').find('.cart-quantity');
    var current_cart_quantity = cart_quantity.text();  // 取得当前数量
    current_cart_quantity = current_cart_quantity.replace(',', '');
    current_cart_quantity = parseInt(current_cart_quantity);
    cart_quantity.text(current_cart_quantity - 1);


    var cart_subtal = $(this).closest('tr').find('.subtal');
    var cart_price = $(this).closest('tr').find('.unit');
    var current_cart_price = cart_price.text();
    current_cart_price = current_cart_price.replace(',', '');
    current_cart_price = parseInt(current_cart_price);
    var subtal = current_cart_price * (current_cart_quantity - 1);
    cart_subtal.text(subtal);


    var goods_num = $('span.goods_num');
    var current_goods_num = goods_num.text();
    current_goods_num = current_goods_num.replace(',', '');
    current_goods_num = parseInt(current_goods_num);
    goods_num.text(current_goods_num - 1);

  
    var price_tal = $('span.pricetal');
    var all_subtal = $('.subtal');
    var tal = 0;
    for (var i = 0; i < all_subtal.length; i++) {
        var bento_subtal = $(all_subtal[i]).text();
        bento_subtal = bento_subtal.replace(',', '');
        bento_subtal = parseInt(bento_subtal);
        tal += bento_subtal;
    }
    price_tal.text(tal);


    var bento_id_input = $(this).closest('tr').find('input[name="bento_id"]');
    var bento_id = bento_id_input.val();

    $.ajax({
        url: '/cart-change-quantity',
        type: 'post',
        data: {
            bento_id: bento_id
        },
        dataType: 'json'
    }).done(function (res) {

        console.log(res);
    });
});
