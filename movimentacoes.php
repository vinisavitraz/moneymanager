<?php
require "db_functions.php";
require_once "authenticate.php";
ini_set('default_charset', 'UTF-8');

function verifica_campo($texto){
	$texto = trim($texto);
	$texto = stripslashes($texto);
	$texto = htmlspecialchars($texto);
	return $texto;
}

function buscar_categorias(){
	$conn = connect_db();

	$sql = "SELECT id_categoria, nome FROM categorias";
	
	$result = mysqli_query($conn, $sql);

	$resultados = [];

	array_push($resultados, "<option disabled selected value> -- categoria --</option>");

	while($row = mysqli_fetch_assoc($result)){
		$categoria = "<option value='" . $row["id_categoria"] ."' >" . $row["nome"] . "</li>";

		array_push($resultados, $categoria);
	}

	return $resultados;
}

function buscar_saldo_dinheiro($id){

	$conn = connect_db();

	$stmt = mysqli_prepare($conn, "SELECT usuarios.saldo_dinheiro FROM usuarios where usuarios.id_usuario = ?");
	
	mysqli_stmt_bind_param($stmt, "i", $id);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	disconnect_db($conn);

	while($row = mysqli_fetch_assoc($result)){
		$saldo = $row["saldo_dinheiro"];

		return $saldo;
	}
}

function buscar_saldo_conta($id){

	$conn = connect_db();

	$stmt = mysqli_prepare($conn, "SELECT usuarios.saldo_conta FROM usuarios where usuarios.id_usuario = ?");
	
	mysqli_stmt_bind_param($stmt, "i", $id);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	disconnect_db($conn);

	while($row = mysqli_fetch_assoc($result)){
		$saldo = $row["saldo_conta"];

		return $saldo;
	}
}

function mes_atual(){
	
	$meses = [
		'01'=>'Janeiro',
		'02'=>'Fevereiro',
		'03'=>'Março',
		'04'=>'Abril',
		'05'=>'Maio',
		'06'=>'Junho',
		'07'=>'Julho',
		'08'=>'Agosto',
		'09'=>'Setembro',
		'10'=>'Outubro',
		'11'=>'Novembro',
		'12'=>'Dezembro'
	];

	return $meses[date('m')];
}

if (isset($_POST['mes']))
{
	$mes = $_POST['mes'];

	echo json_encode(buscar_movimentos_mes($mes, $user_id), JSON_UNESCAPED_SLASHES);
}

function buscar_nome_categoria ($id){
	$conn = connect_db();

	$stmt = mysqli_prepare($conn, "SELECT categorias.nome FROM categorias where categorias.id_categoria = ?");
	
	mysqli_stmt_bind_param($stmt, "i", $id);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	disconnect_db($conn);

	if($row = mysqli_fetch_assoc($result)){
		$nome = $row["nome"];

		return $nome;
	}
}
function buscar_movimentos_mes($mes, $id_usuario){
	$conn = connect_db();
	$ano = date("Y");
	
	$stmt = mysqli_prepare($conn, "SELECT * FROM movimentos where id_usuario = ? and MONTH(data_mov) = ? and YEAR(data_mov) = ? order by id_mov");
	
	mysqli_stmt_bind_param($stmt, "iss", $id_usuario, $mes, $ano);
	
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	if($result){
		return montarTabela($result);	
	}
	else{
		return "Erro no banco";
	}
	
	disconnect_db($conn);
	
}

function formatar_data_tabela ($date){
	$data_formatada = strtotime($date);
	return date('d/m/Y', $data_formatada);
}

function montarTabela($result){
	$tabela = [];	

	while($row = mysqli_fetch_assoc($result)){
		$id_result = $row["id_mov"];
		$transacao_result = $row["transacao"];
		$tipo_result = $row["tipo"];
		$descricao_result = $row["descricao"];
		$valor_result = $row["valor"];
		$id_categoria = $row["id_categoria"];
		$categoria = buscar_nome_categoria($id_categoria);
		$forma_monetaria_result = $row["forma_monetaria"];
		$data_mov_result = formatar_data_tabela($row["data_mov"]);

		if($tipo_result == "E")
			$tipo_result = "Receita";
		else
			$tipo_result = "Despesa";

		array_push($tabela, "<tr>");
		array_push($tabela, "<td>$transacao_result</td>");
		array_push($tabela, "<td>$tipo_result</td>");
		array_push($tabela, "<td>$descricao_result</td>");
		array_push($tabela, "<td>$valor_result</td>");
		array_push($tabela, "<td id='$id_categoria'>$categoria</td>");
		array_push($tabela, "<td>$forma_monetaria_result</td>");
		array_push($tabela, "<td>$data_mov_result</td>");
		array_push($tabela, "<td id='editar_registro' value='$id_result'><span class='glyphicon glyphicon-edit'></span></td>");
		array_push($tabela, "<td id='excluir_registro' value='$id_result'><span class='glyphicon glyphicon-remove' id='remover_registro'></span></td>");
		array_push($tabela, "<tr>");
	}

	return $tabela;
}

function formatar_date($d){
	switch ($d) {
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
		return $d;
		break;
	}
}

function atualizar_saldo($saldo_anterior, $valor, $operador, $tipo, $id_usuario){
	$conn = connect_db();

	$stmt = mysqli_stmt_init($conn);

	if($operador === "+"){
		$novo_saldo = $saldo_anterior + $valor;
	}
	else if ($operador === "-"){
		$novo_saldo = $saldo_anterior - $valor;
	}
	
	if (mysqli_stmt_prepare($stmt, "UPDATE usuarios SET $tipo=$novo_saldo WHERE id_usuario=?")) {
		mysqli_stmt_bind_param($stmt, "i", $id_usuario);
		
		if (!mysqli_stmt_execute($stmt)) {
			$erro = true;
			$erro_sql = $sql . "<br>" . mysqli_error($conn);

			mysqli_stmt_close($stmt);

			return false;
		} 
		else{
			mysqli_stmt_close($stmt);

			return true;
		}
	}
}

function atualizar_saldo_edicao($id_mov, $valor, $forma, $tipo, $id_usuario){
	$conn = connect_db();
	
	$stmt = mysqli_prepare($conn, "SELECT tipo, valor, forma_monetaria FROM movimentos where id_usuario = ? and id_mov = ?");
	
	mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_mov);
	
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	if($row = mysqli_fetch_assoc($result)){
		$tipo_anterior = $row["tipo"];
		$valor_anterior = $row["valor"];
		$forma_anterior = $row["forma_monetaria"];

		if(($forma_anterior != $forma) || ($tipo_anterior != $tipo) ){
			return false;
		}
		else{
			if($forma == "Dinheiro"){
				$saldo_atual = buscar_saldo_dinheiro($id_usuario);

				if($tipo == "E"){
					$novo_saldo = $saldo_atual - $valor_anterior;
					$novo_saldo += $valor;	
				}
				else{
					$novo_saldo = $saldo_atual + $valor_anterior;
					$novo_saldo -= $valor;
				}
				

				return atualizar_saldo($novo_saldo, 0, "+", "saldo_dinheiro", $id_usuario);
			}
			else{
				$saldo_atual = buscar_saldo_conta($id_usuario);

				if($tipo == "E"){
					$novo_saldo = $saldo_atual - $valor_anterior;
					$novo_saldo += $valor;	
				}
				else{
					$novo_saldo = $saldo_atual + $valor_anterior;
					$novo_saldo -= $valor;
				}
				
				return atualizar_saldo($novo_saldo, 0, "+", "saldo_conta", $id_usuario);
			}	
		}
	}
	
	
	disconnect_db($conn);

}

function atualizar_saldo_exclusao($id_mov, $id_usuario){
	$conn = connect_db();
	
	$stmt = mysqli_prepare($conn, "SELECT tipo, valor, forma_monetaria FROM movimentos where id_usuario = ? and id_mov = ?");
	
	mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_mov);
	
	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	if($row = mysqli_fetch_assoc($result)){
		$tipo_anterior = $row["tipo"];	
		$valor_anterior = $row["valor"];
		$forma_anterior = $row["forma_monetaria"];

		if($tipo_anterior == "E"){
			if($forma_anterior == "Dinheiro"){
				$saldo_atual = buscar_saldo_dinheiro($id_usuario);

				$novo_saldo = $saldo_atual - $valor_anterior;

				return atualizar_saldo($novo_saldo, 0, "+", "saldo_dinheiro", $id_usuario);
			}
			else{
				$saldo_atual = buscar_saldo_conta($id_usuario);

				$novo_saldo = $saldo_atual - $valor_anterior;

				return atualizar_saldo($novo_saldo, 0, "+", "saldo_conta", $id_usuario);	
			}
		}
		else {
			if($forma_anterior == "Dinheiro"){
				$saldo_atual = buscar_saldo_dinheiro($id_usuario);

				$novo_saldo = $saldo_atual + $valor_anterior;

				return atualizar_saldo($novo_saldo, 0, "+", "saldo_dinheiro", $id_usuario);
			}
			else{
				$saldo_atual = buscar_saldo_conta($id_usuario);

				$novo_saldo = $saldo_atual + $valor_anterior;

				return atualizar_saldo($novo_saldo, 0, "+", "saldo_conta", $id_usuario);	
			}
		}
		
	}
	
	
	disconnect_db($conn);

}

function inserir_banco($transacao, $tipo, $descricao, $valor, $forma, $data_mov, $categoria, $id_usuario){
	$conn = connect_db();
	$retorno = [];
	
	$sql = "INSERT INTO movimentos (transacao, tipo, descricao, valor, forma_monetaria, data_mov, id_categoria, id_usuario) VALUES ('$transacao', '$tipo', '$descricao', '$valor', '$forma', '$data_mov', $categoria, $id_usuario)";


	if (!mysqli_query($conn, $sql)) {
		$erro = true;
		$erro_sql = $sql . "<br>" . mysqli_error($conn);

		$retorno = [
			"status" => "erro",
			"descricao" => $erro_sql
		];
	}
	else{
		$mes = date_parse_from_format("Y-m-d", $data_mov);
		$mes_retornado = formatar_date($mes["month"]);

		$retorno = [
			"status" => "ok",
			"mes" => $mes_retornado
		];
	}

	disconnect_db($conn);

	return $retorno;
}

function alterar_mov($id, $tipo, $descricao, $valor, $forma, $data_mov, $categoria){
	$conn = connect_db();
	$retorno = [];

	$stmt = mysqli_stmt_init($conn);
	
	$sql = "UPDATE movimentos SET tipo=?, descricao=?, valor=?, forma_monetaria=?, data_mov=?, id_categoria = ? WHERE id_mov=?";

	if (mysqli_stmt_prepare($stmt, $sql)) {

		mysqli_stmt_bind_param($stmt, "ssdssii", $tipo, $descricao, $valor, $forma, $data_mov, $categoria, $id);

		if (!mysqli_stmt_execute($stmt)) {
			$erro = true;
			$erro_sql = $sql . "<br>" . mysqli_error($conn);

			$retorno = [
				"status" => "erro",
				"descricao" => $erro_sql
			];
		} 
		else{
			$mes = date_parse_from_format("Y-m-d", $data_mov);
			$mes_retornado = formatar_date($mes["month"]);

			$retorno = [
				"status" => "ok",
				"mes" => $mes_retornado
			];
		}

		mysqli_stmt_close($stmt);
	}

	disconnect_db($conn);

	return $retorno;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['dadosMov'])){
		$mov = json_decode($_POST["dadosMov"], true);
		$resposta = [];

		$erros = validar_edits($mov);

		if(count($erros) > 0){
			array_push($resposta, "erro");
			array_push($resposta, $erros);

			echo json_encode($resposta, JSON_UNESCAPED_SLASHES);
		}
		else{
			$id_movimento = verifica_campo($mov["id"]);
			$tipo_inserir = verifica_campo($mov["tipo"]);
			$descricao_inserir = verifica_campo($mov["descricao"]);
			$valor_inserir = verifica_campo($mov["valor"]);
			$data_mov_inserir = verifica_campo($mov["data_mov"]);
			$categoria_inserir = verifica_campo($mov["categoria"]);
			$forma_inserir = verifica_campo($mov["forma"]);
			$id_usuario = $_SESSION["user_id"];

			$descricao = "";
			$valor = "";
			$data_mov = "";
			$tipo = "";
			$descricao = "";
			$valor = "";
			$data_mov = "";
			$categoria = "";
			$forma = "";

			if($id_movimento != 0){
				if(atualizar_saldo_edicao($id_movimento, $valor_inserir, $forma_inserir, $tipo_inserir, $id_usuario)){
					$retorno = alterar_mov($id_movimento, $tipo_inserir, $descricao_inserir, $valor_inserir, $forma_inserir, $data_mov_inserir, $categoria_inserir);	
				}
				else{
					$retorno = [
						"status" => "erro",
						"descricao" => "Dados incoerentes"
					];
				}
			}
			else{
				$transacao = mt_rand(10000, 99999);	

				if($tipo_inserir === "E"){
					if($forma_inserir === "Dinheiro"){
						if(atualizar_saldo(buscar_saldo_dinheiro($id_usuario), $valor_inserir, '+', "saldo_dinheiro", $id_usuario)){
							$retorno = inserir_banco($transacao, $tipo_inserir, $descricao_inserir, $valor_inserir, $forma_inserir, $data_mov_inserir, $categoria_inserir, $id_usuario);
						}
					}
					else{
						if(atualizar_saldo(buscar_saldo_conta($id_usuario), $valor_inserir, '+', "saldo_conta", $id_usuario)){
							$retorno = inserir_banco($transacao, $tipo_inserir, $descricao_inserir, $valor_inserir, $forma_inserir, $data_mov_inserir, $categoria_inserir, $id_usuario);
						}
					}
				}
				else{
					if($forma_inserir == "Dinheiro"){
						if(atualizar_saldo(buscar_saldo_dinheiro($id_usuario), $valor_inserir, '-', "saldo_dinheiro", $id_usuario)){
							$retorno = inserir_banco($transacao, $tipo_inserir, $descricao_inserir, $valor_inserir, $forma_inserir, $data_mov_inserir, $categoria_inserir, $id_usuario);
						}
					}
					else {
						if(atualizar_saldo(buscar_saldo_conta($id_usuario), $valor_inserir, '-', "saldo_conta", $id_usuario)){
							$retorno = inserir_banco($transacao, $tipo_inserir, $descricao_inserir, $valor_inserir, $forma_inserir, $data_mov_inserir, $categoria_inserir, $id_usuario);
						}
					}
				}
			}

			if($retorno["status"] == "ok"){
				array_push($resposta, "ok");
				array_push($resposta, $retorno["mes"]);

				echo json_encode($resposta, JSON_UNESCAPED_SLASHES);
			}
			else if($retorno["status"] == "erro") {
				array_push($resposta, "erro_sql");
				array_push($resposta, $retorno["descricao"]);

				echo json_encode($resposta, JSON_UNESCAPED_SLASHES);
			}
		}
	}
	else if(isset($_POST["dadosExclusao"])){
		$conn = connect_db();
		$resposta = [];
		$id_usuario = $_SESSION["user_id"];

		$dados = json_decode($_POST["dadosExclusao"], true);
		$id = $dados["id"];

		if(atualizar_saldo_exclusao($id, $id_usuario)){
			$sql = "DELETE FROM movimentos WHERE id_mov=$id";

			if (mysqli_query($conn, $sql)) {
				array_push($resposta, "Movimento excluído com sucesso");

				echo json_encode($resposta, JSON_UNESCAPED_SLASHES);
			} 
			else{
				array_push($resposta, mysqli_error($conn));

				echo json_encode($resposta, JSON_UNESCAPED_SLASHES);
			}
		}
		else{

		}

		

		disconnect_db($conn);
	}

}

$descricao = "";
$valor = "";
$data_mov = "";
$tipo = "";
$descricao = "";
$valor = "";
$data_mov = "";
$categoria = "";
$forma = "";


function validar_edits($mov){
	$erros = [];

	if(empty($mov["tipo"])){
		$erro = "<li>" . "Selecione um tipo" . "</li>";
		array_push($erros, $erro);
	}

	if(empty($mov["descricao"])){
		$erro = "<li>" . "Descrição é obrigatório" . "</li>";
		array_push($erros, $erro);
	}

	if(empty($mov["valor"])){
		$erro = "<li>" . "Valor é obrigatório" . "</li>";
		array_push($erros, $erro);
	}
	if(!is_numeric($mov["valor"])){
		$erro = "<li>" . "Valor inválido" . "</li>";
		array_push($erros, $erro);
	}
	if(empty($mov["data_mov"])){
		$erro = "<li>" . "Data de movimento é obrigatória" . "</li>";
		array_push($erros, $erro);
	}

	if(empty($mov["categoria"])){
		$erro = "<li>" . "Selecione uma categoria" . "</li>";
		array_push($erros, $erro);
	}

	if(empty($mov["forma"])){
		$erro = "<li>" . "Selecione uma forma" . "</li>";
		array_push($erros, $erro);
	}

	return $erros;

}



?>