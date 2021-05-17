// 给后台传值用Ajax,重点记住jQuery的ajax的固定写法
function addFavourite(bento_id, icon) {

    $.ajax({
        url: '/bento/favourite/add', //传值路径
        type: 'post', //传值方法，一般都是POST方法
        //传值的数据
        data: {
            bento_id: bento_id  //data是键（前面的bento_id是后台接值时POST里的key）值（后面的bento_id是要传的值，是函数addFavourite的参数）对的类型
        },
        dataType: 'json' //数据的类型
    }).done(function (result) {  //result为自定义，写的是后台反馈给前台的逻辑
        //JavaScript有两种取值方式 1.通过点的方式（object.key）2.通过[]的方式(object[key])，通过[]的方式获取属性值，key是动态的，可以是字符串，也可以是数字，还可以是变量
        var action = result.result; //前面的result是该函数的变量，存的是后台的数组（'result' => 'add'），后面的result是后台数组里的result，用来取值。
        if (action === 'add') {
            $(icon).addClass('active');
        } else if (action === 'delete') {
            $(icon).removeClass('active');
        }
    });
}

function removeFavourite(bento_id, icon) {
    addFavourite(bento_id, icon);
    $(icon).closest('.bento').remove();
}
