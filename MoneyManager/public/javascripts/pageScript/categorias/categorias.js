$(function(){
    getJsonUsuarioAutenticado().done(function () {
        buscarCategorias();

    });


    $('#form-categorias').on('submit',function(e){
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

        var nome_input = $("input[name='descricao']").val();

        if(!varPossuiConteudo(nome_input)) {
            erro = true;

            $("#resultado_submit ul").append("<li>" + "Descrição é obrigatório" + "</li>");
        }

        $("#resultado_submit").show();

        return erro;
    }

    function inserirCategoria(){
        $('#form-categorias').append("<input type='hidden' class='campo_form' name='idUsuario' value='" + userAuthenticated.id + "'>");
        var dados = formToJson('.campo_form');

        console.log(dados);

        requestAjaxJson('POST', '/v1.0/categoria', dados);
        /*
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
        }); */

    }

    function buscarCategorias(){
        $.getJSON("/v1.0/categorias/usuario/" + userAuthenticated.id, function (json) {
            var tabelaCategorias = $('#tabelaCategorias');
            var linhasTabela = [];

            $.each(json.categorias, function (i, categoria) {
                var linha = '';

                linha += '<tr>';
                linha += '<td>' + categoria.id + '</td>';
                linha += '<td>' + categoria.descricao + '</td>';
                linha += '<td>' + categoria.ativo + '</td>';
                linha += "<td id= 'editar_registro' value='" + categoria.id + "'><span class='glyphicon glyphicon-edit'></span></td>";
                linha += "<td id='excluir_registro' value='" + categoria.id + "'><span class='glyphicon glyphicon-remove' id='remover_registro'></span></td>";
                linha += '<tr>';
                linhasTabela.push(linha);
            });

            $.each(linhasTabela, function (i, linha){
                tabelaCategorias.append(linha);
            });
        });
    }

});