$(".quantity-add").on('click',function(){   //+按钮的name
    //点击变更购物车bento数量添加按钮事件，触发的逻辑(jq)
    //数量+1
    //商品小计重新计算
    //商品件数加1
    //合计金额重新计算
    //发送ajax请求改变数据库

    //数量+1
    var cart_quantity = $(this).closest('span').find('.cart-quantity');  //取得数量的元素：向上追溯tag->向下追溯class
    var current_cart_quantity = cart_quantity.text();  //取得当前显示数量：text只取内容，html将内容转化为html语言
    current_cart_quantity = current_cart_quantity.replace(',','');  //将数字中的,去掉，获得字符串
    current_cart_quantity = parseInt(current_cart_quantity);  //parseInt：将字符串转换为int类型
    cart_quantity.text(current_cart_quantity + 1);

    //商品小计重新计算
    var cart_subtal =  $(this).closest('tr').find('.subtal');
    var cart_price = $(this).closest('tr').find('.unit');
    var current_cart_price = cart_price.text();
    current_cart_price = current_cart_price.replace(',','');
    current_cart_price = parseInt(current_cart_price);  //parseInt：将字符串转换为int类型后才可以运算
    var subtal = current_cart_price * (current_cart_quantity + 1);
    cart_subtal.text(subtal);  //取得改变之后的小计subtal

    //商品件数+1
    var goods_num = $('span.goods_num');  //通过tag.name来取得
    var current_goods_num = goods_num.text();
    current_goods_num = current_goods_num.replace(',','');
    current_goods_num = parseInt(current_goods_num);
    goods_num.text(current_goods_num + 1);

    //合计金额重新计算
    var price_tal = $('span.pricetal');  //合计金额
    var all_subtal = $('.subtal');  //全部小计金额
    var tal = 0;
    for(var i = 0; i < all_subtal.length; i++){  //length：取得小计金额个数的长度
        var bento_subtal = $(all_subtal[i]).text();
        bento_subtal = bento_subtal.replace(',','');
        bento_subtal = parseInt(bento_subtal);
        tal += bento_subtal;
    }
    price_tal.text(tal);

    //让レジに進む前边的金额也保持同步
    var reg_price_tal = $('span.procetal');
    var current_reg_price_tal = tal;
    reg_price_tal.text(current_reg_price_tal);

    //发送ajax请求改变数据库
    var bento_id_input = $(this).closest('tr').find('input[name="bento_id"]');  //追溯到input标签中的属性
    var bento_id = bento_id_input.val();  //取value

    $.ajax({
        url: '/cart-change-quantity',
        type: 'post',
        data: {
            bento_id: bento_id,
            click: '+'  //对应cart.blade中的name和value
        },
        dataType: 'json'
    }).done(function (res){
        //ajax返回结果之后所作的处理：应该先做数据库实时变更，但是页面加载会慢，为了用户体验先做了上边的jq，所以这里不需要重复书写
        //console.log(res);
    });

});


$(".quantity-reduce").on('click', function () {
    // 点击变更购物车bento数量减少按钮事件，触发的逻辑(jq)
    //数量-1
    //商品小计重新计算
    //商品件数-1
    //合计金额重新计算
    //发送ajax请求改变数据库

    // 数量-1
    var cart_quantity = $(this).closest('span').find('.cart-quantity');  // 取得数量的元素
    var current_cart_quantity = cart_quantity.text();  // 取得当前数量
    current_cart_quantity = current_cart_quantity.replace(',', '');  // 将数量中的,去掉
    current_cart_quantity = parseInt(current_cart_quantity);  // 将字符串转换成数字
    if(current_cart_quantity === 1){    //已添加商品数量为1时，再减少1件则删除该收藏显示
        //整条删除
        var tr =$(this).closest('tr');
        tr.remove();
    }else{
        cart_quantity.text(current_cart_quantity - 1);

    // 商品小计重新计算
    var cart_subtal = $(this).closest('tr').find('.subtal');
    var cart_price = $(this).closest('tr').find('.unit');
    var current_cart_price = cart_price.text();
    current_cart_price = current_cart_price.replace(',', '');
    current_cart_price = parseInt(current_cart_price);
    var subtal = current_cart_price * (current_cart_quantity - 1);
    cart_subtal.text(subtal);

    }

    // 商品件数减1
    var goods_num = $('span.goods_num');
    var current_goods_num = goods_num.text();
    current_goods_num = current_goods_num.replace(',', '');
    current_goods_num = parseInt(current_goods_num);
    goods_num.text(current_goods_num - 1);

    // 合计金额重新计算
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

    //让レジに進む前边的金额也保持同步
    var reg_price_tal = $('span.procetal');
    var current_reg_price_tal = tal;
    reg_price_tal.text(current_reg_price_tal);

    // 发送ajax请求改变数据库
    var bento_id_input = $(this).closest('tr').find('input[name="bento_id"]');
    var bento_id = bento_id_input.val();

    $.ajax({
        url: '/cart-change-quantity',
        type: 'post',
        data: {
            bento_id: bento_id,
            click: '-'
        },
        dataType: 'json'
    }).done(function (res) {
        // ajax返回结果之后所作的处理
        //console.log(res);
    });
});

$(".delete").on('click',function(){

    //删除前台显示框
    var tr = $(this).closest('tr');
    tr.remove();

    //点击变更购物车bento删除按钮事件，触发的逻辑(jq)
    //商品件数重新计算
    //合计金额重新计算

    //商品件数重新计算
    var goods_num = $('span.goods_num');
    var current_goods_num = goods_num.text();
    var cart_quantity = $(this).closest('tr').find('.cart-quantity');
    var current_cart_quantity = cart_quantity.text();

    current_goods_num = current_goods_num.replace(',','');
    current_goods_num =parseInt(current_goods_num);
    current_cart_quantity = current_cart_quantity.replace(',','');
    current_cart_quantity = parseInt(current_cart_quantity);

    var new_goods_num = current_goods_num - current_cart_quantity;
    goods_num.text(new_goods_num);

    //合计金额重新计算
    var price_tal = $('span.pricetal');
    var current_price_tal = price_tal.text();
    var subtal = $(this).closest('tr').find('span.subtal').text();

    current_price_tal = current_price_tal.replace(',','');
    current_price_tal =parseInt(current_price_tal);
    subtal = subtal.replace(',','');
    subtal =parseInt(subtal);

    var new_price_tal = current_price_tal - subtal;
    price_tal.text(new_price_tal);

    //让レジに進む前边的金额也保持同步
    var reg_price_tal = $('span.procetal');
    var current_reg_price_tal = new_price_tal;
    reg_price_tal.text(current_reg_price_tal);

    //获取当前商品的id
    var bento_id_input = $(this).closest('tr').find('input[name="bento_id"]');
    var bento_id = bento_id_input.val();

    $.ajax({
        url: '/cart-change-quantity',
        type: 'post',
        data: {
            bento_id: bento_id,
            click: 'キャンセル'
        },
        dataType: 'json'
    }).done(function (res) {
        // ajax返回结果之后所作的处理
        //console.log(res);
    });
});
