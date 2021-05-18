$(".quantity-add").on('click', function () {
    // 点击事件触发的逻辑

    /**
     * 数量加1
     * 商品小计重新计算
     * 商品件数加1
     * 合计金额重新计算
     * 发送ajax请求改变数据库
     */

    // 数量加1
    var cart_quantity = $(this).closest('span').find('.cart-quantity');  // 取得数量的元素
    var current_cart_quantity = cart_quantity.text();  // 取得当前数量
    current_cart_quantity = current_cart_quantity.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
    current_cart_quantity = parseInt(current_cart_quantity);  // 将字符串转换成数字
    cart_quantity.text(current_cart_quantity + 1);

    // 商品小计重新计算
    var cart_subtal = $(this).closest('tr').find('.subtal');
    var cart_price = $(this).closest('tr').find('.unit');
    var current_cart_price = cart_price.text();
    current_cart_price = current_cart_price.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
    current_cart_price = parseInt(current_cart_price);
    var subtal = current_cart_price * (current_cart_quantity + 1);
    cart_subtal.text(subtal);

    // 商品件数加1
    var goods_num = $('span.goods_num');
    var current_goods_num = goods_num.text();
    current_goods_num = current_goods_num.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
    current_goods_num = parseInt(current_goods_num);
    goods_num.text(current_goods_num + 1);

    // 合计金额重新计算
    var price_tal = $('span.pricetal');
    var all_subtal = $('.subtal');
    var tal = 0;
    for (var i = 0; i < all_subtal.length; i++) {
        var bento_subtal = $(all_subtal[i]).text();
        bento_subtal = bento_subtal.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
        bento_subtal = parseInt(bento_subtal);
        tal += bento_subtal;
    }
    price_tal.text(tal);

    // 发送ajax请求改变数据库
    var bento_id_input = $(this).closest('tr').find('input[name="bento_id"]');
    var bento_id = bento_id_input.val();

    $.ajax({
        url: '/cart-change-quantity',
        type: 'post',
        data: {
            click:'+',
            bento_id: bento_id
        },
        dataType: 'json'
    }).done(function (res) {
        // ajax返回结果之后所作的处理
        console.log(res);
    });
});


$(".quantity-reduce").on('click', function () {
    // 点击事件触发的逻辑

    /**
     * 数量减1
     * 商品小计重新计算
     * 商品件数减1
     * 合计金额重新计算
     * 发送ajax请求改变数据库
     */

        // 数量减1
    var cart_quantity = $(this).closest('span').find('.cart-quantity');  // 取得数量的元素
    var current_cart_quantity = cart_quantity.text();  // 取得当前数量
    current_cart_quantity = current_cart_quantity.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
    current_cart_quantity = parseInt(current_cart_quantity);  // 将字符串转换成数字
    if (current_cart_quantity === 1) {
        // 整条删除
        var tr = $(this).closest('tr');
        tr.remove();
    } else {
        cart_quantity.text(current_cart_quantity - 1);

        // 商品小计重新计算
        var cart_subtal = $(this).closest('tr').find('.subtal');
        var cart_price = $(this).closest('tr').find('.unit');
        var current_cart_price = cart_price.text();
        current_cart_price = current_cart_price.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
        current_cart_price = parseInt(current_cart_price);
        var subtal = current_cart_price * (current_cart_quantity - 1);
        cart_subtal.text(subtal);
    }



    // 商品件数减1
    var goods_num = $('span.goods_num');
    var current_goods_num = goods_num.text();
    current_goods_num = current_goods_num.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
    current_goods_num = parseInt(current_goods_num);
    goods_num.text(current_goods_num - 1);

    // 合计金额重新计算
    var price_tal = $('span.pricetal');
    var all_subtal = $('.subtal');
    var tal = 0;
    for (var i = 0; i < all_subtal.length; i++) {
        var bento_subtal = $(all_subtal[i]).text();
        bento_subtal = bento_subtal.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
        bento_subtal = parseInt(bento_subtal);
        tal += bento_subtal;
    }
    price_tal.text(tal);

    // 发送ajax请求改变数据库
    var bento_id_input = $(this).closest('tr').find('input[name="bento_id"]');
    var bento_id = bento_id_input.val();

    $.ajax({
        url: '/cart-change-quantity',
        type: 'post',
        data: {
            click:'-',
            bento_id: bento_id
        },
        dataType: 'json'
    }).done(function (res) {
        // ajax返回结果之后所作的处理
        console.log(res);
    });
});




$(".delete").on('click', function () {


    //
    var tr = $(this).closest('tr');
    tr.remove();

/**    //取当前键入购物车的便当数量
    var cart_quantity = $(this).closest('span').find('.cart-quantity');  // 取得数量的元素
    var current_cart_quantity = cart_quantity.text();  // 取得当前数量
    current_cart_quantity = current_cart_quantity.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
    current_cart_quantity = parseInt(current_cart_quantity);  // 将字符串转换成数字


    // 商品件数重新计算
    var goods_num = $('span.goods_num');
    var current_goods_num = goods_num.text();
    current_goods_num = current_goods_num.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
    current_goods_num = parseInt(current_goods_num);
    goods_num.text(current_goods_num - current_cart_quantity);
*/

     // 商品件数重新计算
  var goods_num = $('span.goods_num');
    var cart_quantity = $('.cart-quantity');
    var goodstol = 0;
    for (var m = 0; m < cart_quantity.length; m++){
        var all_cart_quantity = $(cart_quantity[m]).text();
        all_cart_quantity = all_cart_quantity.replace(',', '');
        all_cart_quantity = parseInt(all_cart_quantity);
        goodstol += all_cart_quantity;
    }
    goods_num.text(goodstol);



    // 合计金额重新计算
    var price_tal = $('span.pricetal');
    var all_subtal = $('.subtal');
    var tal = 0;
    for (var i = 0; i < all_subtal.length; i++) {
        var bento_subtal = $(all_subtal[i]).text();
        bento_subtal = bento_subtal.replace(',', '');  // 将数量中的,去掉，1,000 -> 1000
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
            click:'cancel',
            bento_id: bento_id
        },
        dataType: 'json'
    }).done(function (res) {
        // ajax返回结果之后所作的处理
        console.log(res);
    });

});
