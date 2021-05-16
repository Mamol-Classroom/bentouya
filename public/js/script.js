function addFavourite(bento_id, icon) {
    // Ajax
    $.ajax({
        url: '/bento/favourite/add',
        type: 'post',
        data: {
            bento_id: bento_id
        },
        dataType: 'json'
    }).done(function (result) {
        var action = result.result;
        if (action === 'add') {
            $(icon).addClass('active');
        } else if (action === 'delete') {
            $(icon).removeClass('active');
        }
    });
}

function removeFavourite(bento_id, icon)
{
    addFavourite(bento_id, icon);
    $(icon).closest('.bento').remove();
}


