$(function(){
	$('#filtro input').on('change', function() {
		$('#tabela_inteira tr').show();

		var selecionado = $('input[name=optradio]:checked', '#filtro').val();


		if(selecionado === 'tudo'){
			$('#tabela_inteira tr').show();
		}
		else {
			$("#tabela_inteira td:nth-child(2)").each(function(){
				var valor_coluna = $(this)[0].innerHTML;

				if(valor_coluna != selecionado){
					$(this).closest('tr').hide();
				}
			});
		}
		
	});

	$('#tipo').change(function() {
		$('#Debito').hide();
		$('#Transferencia').hide();
		$('#Deposito').hide();
		$('#Dinheiro').hide();

		if ($('#tipo').val() === 'E') {
			$("#Desabilitado").prop('selected', true);
			$('#Dinheiro').show();
			$('#Transferencia').show();
			$('#Deposito').show();
		}
		else{
			$("#Desabilitado").prop('selected', true);
			$('#Dinheiro').show();
			$('#Debito').show();
		}
	});

	var d = new Date();
	var m = d.getMonth() + 1;

	$("#mes_selecionado_atual").val(retornarNumeroMes(m));
	
	$('#Janeiro').click(function() {
		buscarMes("01");
	});
	$('#Fevereiro').click(function() {
		buscarMes("02");
	});
	$('#Marco').click(function() {
		buscarMes("03");
	});
	$('#Abril').click(function() {
		buscarMes("04");
	});
	$('#Maio').click(function() {
		buscarMes("05");
	});
	$('#Junho').click(function() {
		buscarMes("06");
	});
	$('#Julho').click(function() {
		buscarMes("07");
	});
	$('#Agosto').click(function() {
		buscarMes("08");
	});
	$('#Setembro').click(function() {
		buscarMes("09");
	});
	$('#Outubro').click(function() {
		buscarMes("10");
	});
	$('#Novembro').click(function() {
		buscarMes("11");
	});
	$('#Dezembro').click(function() {
		buscarMes("12");
	});

	//escuta eventos de clique na tabela, para verificar edicao e exclusao
	$('#tabela_inteira').on('click', 'tbody td', function () {
		var acao = $(this).attr('id');
		var id_mov = $(this).attr('value');

		if(acao == 'editar_registro'){
			var r = confirm("Confirma a edição do movimento? Ele será aberto para edição na tela ao lado");
			if (r) {

				var linha = (this).closest('tr');
				editarRegistro(id_mov, linha);	
			} 	
		}
		else if(acao == 'excluir_registro'){
			var r = confirm("Confirma a exclusão do movimento?");
			if (r) {
				excluirRegistro(id_mov);
			} 
		}
		
	});
	
	function buscarMes(mes){
		$('#mes_selecionado_atual').val(mes);

		$.post('movimentacoes.php', { mes: mes}, 
			function(returnedData){
				mes = formatarMes(mes);

				$('#mes_selecionado_atual').html(mes);

				if(returnedData == '[]'){
					$('#tabela').html('');
				}
				else{
					$('#tabela').html(returnedData);
				}

			});
	}

	function retornarNumeroMes(mes){
		switch(mes) {
			case '1':
			return '01';	
			break;
			case '2':
			return '02';
			break;
			case '3':
			return '03';
			break;
			case '4':
			return '04';
			break;
			case '5':
			return '05';
			break;
			case '6':
			return '06';
			break;
			case '7':
			return '07';
			break;
			case '8':
			return '08';
			break;
			case '9':
			return '09';
			break;
			default:
			return mes;
		}
	}
	function formatarMes(mes){
		switch(mes) {
			case '01':
			return 'Janeiro';	
			break;
			case '02':
			return 'Fevereiro';
			break;
			case '03':
			return 'Março';
			break;
			case '04':
			return 'Abril';
			break;
			case '05':
			return 'Maio';
			break;
			case '06':
			return 'Junho';
			break;
			case '07':
			return 'Julho';
			break;
			case '08':
			return 'Agosto';
			break;
			case '09':
			return 'Setembro';
			break;
			case '10':
			return 'Outubro';
			break;
			case '11':
			return 'Novembro';
			break;
			case '12':
			return 'Dezembro';
			break;
		}
	}

	$("#form-test").on("submit",function(e){

		$("#resultado_submit").hide();
		$("#erros").hide();
		$("#resultado_submit ul").html("");

		var erro = false;

		id_input = $("input[name='id']").val();		
		tipo_select = $("select[name='tipo']").val();
		descricao_input = $("input[name='descricao']").val();
		valor_input = $("input[name='valor']").val();
		data_mov_input = $("input[name='data_mov']").val();
		categoria_select = $("select[name='categoria']").val();
		forma_select = $("select[name='forma']").val();


		if(id_input == "" || id_input == null)
		{
			id_input = 0;
		}
		if(tipo_select == "" || tipo_select == null)
		{
			$("#resultado_submit ul").append("<li>" + "Selecione um tipo" + "</li>");

			erro = true;
		}
		if(descricao_input == "" || descricao_input == null)
		{
			$("#resultado_submit ul").append("<li>" + "Descrição é obrigatório" + "</li>");

			erro = true;
		}
		if(valor_input == "" || valor_input == null)
		{
			$("#resultado_submit ul").append("<li>" + "Valor é obrigatório" + "</li>");

			erro = true;
		}
		if(data_mov_input == "" || data_mov_input == null)
		{
			$("#resultado_submit ul").append("<li>" + "Data de movimento é obrigatória" + "</li>");

			erro = true;
		}
		if(categoria_select == "" || categoria_select == null)
		{
			$("#resultado_submit ul").append("<li>" + "Selecione uma categoria" + "</li>");

			erro = true;
		}
		if(forma_select == "" || forma_select == null)
		{
			$("#resultado_submit ul").append("<li>" + "Selecione uma forma" + "</li>");

			erro = true;
		}

		$("#resultado_submit").show();

		if(erro){ 
			$("#erros").show();

			return false;
		}
		else{
			e.preventDefault();

			inserirMovimento(id_input, tipo_select, descricao_input, valor_input, data_mov_input, categoria_select, forma_select);
		}
	});


	function inserirMovimento(id, tipo, descricao, valor, data_mov, categoria, forma){
		var dadosPost = 
		{
			"id": id,
			"tipo":tipo,
			"descricao":descricao,
			"valor":valor,
			"data_mov":data_mov,
			"categoria":categoria,
			"forma":forma
		};

		var dadosString = JSON.stringify(dadosPost);

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "movimentacoes.php",
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

			buscarMes(resposta[1]);

			$('#transacao_alterada').text("");
			$('#texto_transacao').hide();
			$("#tudo").prop("checked", true);
			$("#tudo").trigger('change');
			setTimeout(function() { $("#sucesso").hide(); }, 5000);
			setTimeout(function() { $("#resultado_submit").hide(); }, 5000);
		}
		else if(resposta[0] == 'erro'){
			console.log("erro validacao");
			var erros = resposta[1];

			for (var i = 0; i < erros.length; i++) {
				$("#resultado_submit ul").append(erros[i]);
			}
			$("#resultado_submit").show();
			$("#erros").show();
		}
		else if(resposta[0] == 'erro_sql'){
			console.log("erro sql");
			var descricao_erro = resposta[1];

			$("#resultado_submit ul").append("Erro no banco de dados: ");
			$("#resultado_submit ul").append(descricao_erro);

			$("#resultado_submit").show();
			$("#erros").show();
		}
	}

	function criarObjetoDate(data){
		const [day, month, year] = data.split("/");
		return new Date(year, month - 1, day);
	}

	function editarRegistro(id, linha){
		var id_editar = id;
		var transacao = linha.cells[0].innerHTML;
		var tipo = linha.cells[1].innerHTML;

		if(tipo == 'Receita')
			tipo = 'E';
		else 
			tipo = 'S';


		$("input[name='id']").val(id);		
		$("select[name='tipo']").val(tipo);
		$("input[name='descricao']").val(linha.cells[2].innerHTML);
		$("input[name='valor']").val(linha.cells[3].innerHTML);
		document.getElementById("data_mov").valueAsDate = criarObjetoDate(linha.cells[6].innerHTML);
		$("select[name='categoria']").val(linha.cells[4].id);
		$("#tipo").prop('disabled', true);
		$("#tipo").trigger('change');
		$("select[name='forma']").val(linha.cells[5].innerHTML);		
		$("#forma").prop('disabled', true);
		$('#cadastrar').text("Alterar");
		$('#transacao_alterada').text(linha.cells[0].innerHTML);
		$('#texto_transacao').show();
		$('#tabela_inteira tr').show();
	}

	function excluirRegistro(id){		
		var dados = 
		{
			"id":id
		};

		var dadosString = JSON.stringify(dados);

		$.ajax({
			type: "POST",
			dataType: "json",
			url: "movimentacoes.php",
			data: {dadosExclusao:dadosString},
			success: function(data){
				alert(data);

				$('#tabela').html('');
				buscarMes($('#mes_selecionado_atual').val());

			},
			error: function(e){
				console.log(e);
			}
		});
	}

	$("#limpar").click(function(){
		$("input[name='id']").val(0);		
		$("select[name='tipo']").val("");
		$("input[name='descricao']").val("");
		$("input[name='valor']").val("");
		$("input[name='data_mov']").val("");
		$("select[name='categoria']").val("");
		$("#tipo").prop('disabled', false);
		$("select[name='forma']").val("");		
		$("#forma").prop('disabled', false);
		$('#transacao_alterada').text("");
		$('#texto_transacao').hide();
		$('#cadastrar').text("Cadastrar");
	});
});
