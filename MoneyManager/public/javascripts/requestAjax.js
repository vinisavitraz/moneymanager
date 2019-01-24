
function requestAjaxJson(type, url, data) {
    $.ajax({
        url: url,
        type: type,
        contentType: 'application/json',
        dataType: 'json',
        data: data,
        success: function (data) {
            console.log(data);
        },
        error: function (data) {
            console.log(data);
        }
    });
}

function requestReturn(url, type, data, sucess, error) {
    return new Promise(function (resolve, reject) {
        startLoader();

        var ajax = $.ajax({
            url: url,
            type: type,
            contentType: 'application/json',
            dataType: 'json',
            data: data
        });

        ajax.done(function(data){
            sucess(data);
            finishLoader();
            resolve();
        }).fail(function (data){
            console.log(data);
            finishLoader();
            reject();
        });
    });
}

function showDialogFail(data, redirecionar) {
    args = {
        id: 'dialogInfo',
        container: '#div_dialog',
        mensagem: data.responseJSON.response.messages[0].message,
        status: data.status,
        redicionar: redirecionar
    };
    var dialog = new DialogJs(args);
    dialog.showModel();
}

function showDialog(msg, redirecionar) {
    args = {
        id: 'dialogInfo',
        container: '#div_dialog',
        mensagem: msg,
        status: 503,
        redicionar: redirecionar
    };
    var dialog = new DialogJs(args);
    dialog.showModel();
}