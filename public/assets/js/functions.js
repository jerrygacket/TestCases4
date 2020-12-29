function changeStatus(Elem, taskId) {
    $.post(
        "/",
        {
            asAjax:true,
            element: 'task',
            action: 'change',
            status: Elem.checked ? '1' : '0',
            id: taskId,
        },
        onAjaxSuccess
    );

    function onAjaxSuccess(data)
    {
        // Здесь мы получаем данные, отправленные сервером и выводим их на экран.
        console.log(data);
        // var arr = JSON.parse(data);
        // console.log(arr.result);
        // var goodCount = 0;
        // Object.entries(arr.result).forEach(function(element) {
        //     goodCount = goodCount + element[1];
        // });
        // document.getElementById('goods_count').innerHTML = goodCount;
    }
}