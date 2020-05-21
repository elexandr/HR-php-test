// Обновление цены ajax на странице списка продуктов
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
function price_update(el) {
    var myEl = $(el);
    var edit_id = myEl.attr('id')
    var price = myEl.val()

    if (edit_id != '' && price != '') {
        $.ajax({
            url: 'products/updateprice',
            type: 'post',
            data: {id: edit_id, price: price},
            success: function (response) {
                if (response.result) {
                    myEl.removeClass(['border-danger', 'text-danger']);
                    myEl.addClass('border-success')
                    setTimeout(function () {
                        myEl.removeClass('border-success');
                    }, 2000);
                }
            },
            error: function error(allresonse) {// Обрабатываем ошибки валидации с сервера
                // Извлекаем ошибки
                let responseText = JSON.parse(allresonse.responseText);
                let err = responseText.errors;
                // Формируем текст с ошибками и задаем стили для полей
                var errortext;
                for (let key in err) {
                    // текст ошибок
                    errortext = err[key] + '\n';
                }
                // бордер
                myEl.addClass(['border-danger', 'text-danger']);
                alert(errortext)
            }
        });
    } else {
        alert('Не оставляйте поле цены пустым');
        myEl.addClass(['border-danger']);
    }
}