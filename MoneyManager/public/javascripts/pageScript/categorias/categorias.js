$(function(){
    getJsonUsuarioAutenticado().done(function () {
        buscarCategorias();

    });


    $('#form-test').on('submit',function(e){
        if(validarForm()){
            $("#erros").show();
            return false;
        }
        else{
            e.preventDefault();

            inserirCategoria();

            setTimeout(function() { $("#sucesso").hide(); }, 5000);
            setTimeout(function() { $("#resultado_submit").hide(); }, 5000);
        }
    });

    function validarForm(){
        $('#resultado_submit').hide();
        $('#erros').hide();
        $('#resultado_submit ul').html('');

        var erro = false;

        var nome_input = $("input[name='nome']").val();

        if(!varPossuiConteudo(nome_input)) {
            erro = true;

            $("#resultado_submit ul").append("<li>" + "Nome é obrigatório" + "</li>");
        }

        $("#resultado_submit").show();

        return erro;
    }

    function inserirCategoria(nome){
        var dados = formToJson('.campo_form');

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "categorias.php",
            data: {dadosMov:dadosString},
            success: function(data){
                callBack(data);
            },
            error: function(e){
                console.log(e);
            }
        });

    }

    function callBack(data){
        var resposta = data;

        if(resposta[0] == 'ok'){
            $("#resultado_submit").show();
            $("#sucesso").show();

            $('#form-test').each (function(){
                this.reset();
            });

            setTimeout(function() { $("#sucesso").hide(); }, 5000);
            setTimeout(function() { $("#resultado_submit").hide(); }, 5000);
        }
        else if(resposta[0] == 'erro'){
            var erros = resposta[1];

            for (var i = 0; i < erros.length; i++) {
                $("#resultado_submit ul").append(erros[i]);
            }
            $("#resultado_submit").show();
            $("#erros").show();
        }
        else if(resposta[0] == 'erro_sql'){
            var descricao_erro = resposta[1];

            $("#resultado_submit ul").append("Erro no banco de dados: ");
            $("#resultado_submit ul").append(descricao_erro);

            $("#resultado_submit").show();
            $("#erros").show();
        }
    }

    function buscarCategorias(){
        $.getJSON("/v1.0/categorias/usuario/" + userAuthenticated.id, function (json) {
            console.log(json);

            $.each(json.categorias, function (i, item) {
                console.log()
                //criar tabela
                //$('#unidadeDest').append($('<option>', {value: item.codigo, text: item.codigo + " - " + item.nome}));
            });
        });

    }

});