


function formToJson(campoForm) {
    return JSON.stringify(formToObject(campoForm));
}

function formToObject(campoForm) {
    var object = {};
    object['data_cadastro'] = getDataNow();
    //percorre os campos do formulario
    $(campoForm).each(function (index) {
        // verefica o type do campo para pegar atribuir diferentes valores
        var campo = $(this);
        if (campo.attr("type") == "checkbox") {
            if (campo.is(':checked')) {
                object[campo.attr("name")] = "S";
            } else {
                object[campo.attr("name")] = "N";
            }
        } else if (campo.attr("type") == "time") {
            object[campo.attr("name")] = convertStringToMillisecond(campo.val());
        } else {
            object[campo.attr("name")] = campo.val();
        }
    });
    return object;
}

function marcarMenuSelecionado(pagina){
    console.log(pagina);
    var menu = $('#menuCabecalho li')
    if(pagina == "Inicial"){
        menu.removeClass('active');
        var element = '';
        console.log(element);
        element.addClass('active');
        console.log(element.innerText);
        console.log(element.innerHTML);
        //console.log(element)



    }
}

function varPossuiConteudo(variavel){
    if( (typeof variavel != 'undefined') && (variavel != null) && (variavel != 'null') && (variavel != '')){
        return true;
    } else{
        return false;
    }
}