function addFavourite(bento_id, icon) {
    // 使用Ajax保持页面不跳转并传值
    $.ajax({                         //jquery中的文字数组写法{key：'value'}
        url: '/bento/favourite/add', //route
        type: 'post',                //传值方式
        data: {                      //传递数据，数组形式
            bento_id: bento_id       //user_id?
        },
        dataType: 'json'             //数据表现方式
    }).done(function (result) {      //操作方法
        var action = result.result;  //result函数的方法result?
        if (action === 'add') {
            $(icon).addClass('active');//选取icon元素，添加css class：style.css中的active->图标变红
        } else if (action === 'delete') {
            $(icon).removeClass('active');//删除css class
        }
    });
}

