function addFavourite(bento_id,icon){
    //ajax
    $.ajax({
        url:'/bento/favourite/add',
        type:'post',
        data:{
            bento_id:bento_id
        },
        dataType:'json'
    }).done(function (result){

    })


}
