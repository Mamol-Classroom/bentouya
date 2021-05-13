function addFavourite(bento_id, icon) { //top.blade页面中js传值的this，即onclick触发事件的div标签
    // 使用Ajax保持页面不跳转并传值
    $.ajax({                         //jquery中的文字数组写法{key：'value'}
        url: '/bento/favourite/add', //route
        type: 'post',                //传值方式
        data: {                      //传递数据，数组形式
            bento_id: bento_id       //user_id也使用，但是是从session中提取，没有使用ajax
        },
        dataType: 'json'             //数据表现方式
    }).done(function (result) {      //操作方法
        var action = result.result;  //result函数的key:'result'=>'add'
        if (action === 'add') {
            $(icon).addClass('active');//选取icon元素，添加css class：style.css中的active->图标变红
        } else if (action === 'delete') {
            $(icon).removeClass('active');//删除css class
        }
    });
}

function removeFavourite(bento_id,icon){
    //调用上边的函数，并将值bento_id,icon传入，因为执行操作一致，无需重复书写
    addFavourite(bento_id,icon);
    //closest向上追述到div，class是bento；remove删除
    $(icon).closest('.bento').remove();
}

