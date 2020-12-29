$(document).on('click', '.category-link', function(){
    if (!$('#catalog-data').length) {
        return true;
    }
    var self = $(this);
    $.ajax({
        url: '/index.php?page=catalog&action=index&id=' + self.attr('link') + '&asAjax=true',
        type: 'GET',
        dataType: 'json'
    }).done(function(data) {
        var categoryList = $('<ul></ul>');
        var catalogData = $('#catalog-data');
        catalogData.empty();
        for (var item in data.subcategories) {
            var category = $('<a>');
            category.attr('href', "/index.php?page=catalog&id=" + data.subcategories[item].id);
            category.attr('link', data.subcategories[item].id);
            category.addClass('category-link');
            category.html(data.subcategories[item].name);
            categoryList.append('<li>' + category[0].outerHTML + '</li>');
        }
        catalogData.html(categoryList.html());
    });
    return false;
});

function ajax_post(action, id, element) {
    console.log(action + id + element);
    $.post(
        "/index.php",
        {
            asAjax: true,
            action: action,
            id: id,
            element: element
        },
        onAjaxSuccess
    );

    function onAjaxSuccess(data)
    {
        // Здесь мы получаем данные, отправленные сервером и выводим их на экран.
        var arr = JSON.parse(data);
        alert(arr.message);
        //document.getElementById('status_'+arr.id).innerHTML = 'Статус: ' + arr.newstatus;
    }
}

$(document).on('click', '.order-btn', function(){
    $.post(
        "/index.php",
        {
            asAjax: true,
            action: $(this).attr('data-action'),
            id: $(this).parent().attr('data-id'),
            element: $(this).parent().attr('data-element')
        },
        onAjaxSuccess
    );

    function onAjaxSuccess(data)
    {
        // Здесь мы получаем данные, отправленные сервером и выводим их на экран.
        console.log(data);
        var arr = JSON.parse(data);
        // alert(arr.message);
        if (arr.result) {
            document.getElementById('status'+arr.result.id).innerHTML = arr.result.status;
        }
    }


    // if (!$('#order-data').length) {
    //     return true;
    // }

    // var self = $(this);
    // $.ajax({
    //     url: '/index.php?page=user&action=status&id=' + self.attr('link') + '&asAjax=true',
    //     type: 'GET',
    //     dataType: 'json'
    // }).done(function(data) {
    //     var orderList = $('<ul></ul>');
    //     var orderData = $('#order-data');
    //     orderData.empty();
    //     for (var item in data.subcategories) {
    //         var order = $('<a>');
    //         order.attr('href', "/index.php?page=catalog&id=" + data.subcategories[item].id);
    //         order.attr('link', data.subcategories[item].id);
    //         order.addClass('category-link');
    //         order.html(data.subcategories[item].name);
    //         orderList.append('<li>' + order[0].outerHTML + '</li>');
    //     }
    //     orderData.html(orderList.html());
    // });
    return false;
});
