<?php
require "db_functions.php";
require_once "authenticate.php";
ini_set('default_charset', 'UTF-8');

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

function buscar_ultimos_mov($id){
	$movimentos = [];

	$conn = connect_db();

	$stmt = mysqli_prepare($conn, "SELECT movimentos.tipo, movimentos.descricao, movimentos.valor FROM movimentos where id_usuario = ? order by id_mov desc limit 3");
	
	mysqli_stmt_bind_param($stmt, "i", $id);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	disconnect_db($conn);

	while($row = mysqli_fetch_assoc($result)){

		$tipo = $row["tipo"];
		$descricao = $row["descricao"];
		$valor = $row["valor"];

		if($tipo == "E")
			$icone = "<span class='glyphicon glyphicon-plus-sign'></span>";
		else
			$icone = "<span class='glyphicon glyphicon-minus-sign'></span>";

		$valor = number_format($valor, 2, ",", ".");

		array_push($movimentos, "<div class='panel-body'>" . $descricao . "  <b class ='pull-right'>R$" . $valor. " " .$icone. "</b></div>");
		
	}

	return $movimentos;
}


function buscar_receitas_anuais(){
	$receitas = [];
	$id_usuario = $_SESSION["user_id"];

	$meses = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
	$ano = date("Y");

	$conn = connect_db();

	for ($i=0; $i < 12 ; $i++) { 

		$stmt = mysqli_prepare($conn, "SELECT sum(valor) as valor FROM movimentos WHERE id_usuario = ? AND movimentos.tipo = 'E' AND MONTH(data_mov) = ? and YEAR(data_mov) = ?");

		mysqli_stmt_bind_param($stmt, "iss", $id_usuario , $meses[$i], $ano);
		
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		
		while($row = mysqli_fetch_assoc($result)){
			$valor = $row["valor"];

			if(isset($valor))
				array_push($receitas, intval($valor));
			else
				array_push($receitas, 0);
		}
		
	}

	disconnect_db($conn);

	return $receitas;
}

function buscar_despesas_anuais(){
	$despesas = [];
	$id_usuario = $_SESSION["user_id"];

	$meses = ["01", "02", "03", "04", "05", "06", "07", "08", "09", "10", "11", "12"];
	$ano = date("Y");

	$conn = connect_db();

	for ($i=0; $i < 12 ; $i++) { 

		$stmt = mysqli_prepare($conn, "SELECT sum(valor) as valor FROM movimentos WHERE id_usuario = ? AND movimentos.tipo = 'S' AND MONTH(data_mov) = ? and YEAR(data_mov) = ?");

		mysqli_stmt_bind_param($stmt, "iss", $id_usuario , $meses[$i], $ano);
		
		mysqli_stmt_execute($stmt);

		$result = mysqli_stmt_get_result($stmt);

		
		while($row = mysqli_fetch_assoc($result)){
			$valor = $row["valor"];

			if(isset($valor))
				array_push($despesas, intval($valor));
			else
				array_push($despesas, 0);
		}
		
	}

	disconnect_db($conn);

	return $despesas;
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

function buscar_maiores_gastos($id){
	$gastos = [];

	$conn = connect_db();

	$stmt = mysqli_prepare($conn, "SELECT id_categoria, sum(valor) as total FROM movimentos WHERE tipo = 'S' AND id_usuario = ? GROUP BY id_categoria ORDER BY total DESC LIMIT 3");
	
	mysqli_stmt_bind_param($stmt, "i", $id);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	disconnect_db($conn);

	while($row = mysqli_fetch_assoc($result)){
		$total_categoria = $row["total"];
		$id_categoria = $row["id_categoria"];
		
		$total = number_format($total_categoria, 2, ",", ".");
		$categoria = buscar_nome_categoria($id_categoria);

		array_push($gastos, "<div class='panel-body'>". $categoria . "<b class='pull-right'>R$" . $total . "</b></div>");
		
	}

	return $gastos;
}

function buscar_maiores_ganhos($id){
	$ganhos = [];

	$conn = connect_db();

	$stmt = mysqli_prepare($conn, "SELECT id_categoria, sum(valor) as total FROM movimentos WHERE tipo = 'E' AND id_usuario = ? GROUP BY id_categoria ORDER BY total DESC LIMIT 3");
	
	mysqli_stmt_bind_param($stmt, "i", $id);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	disconnect_db($conn);

	while($row = mysqli_fetch_assoc($result)){
		$total_categoria = $row["total"];
		$id_categoria = $row["id_categoria"];
		
		$total = number_format($total_categoria, 2, ",", ".");
		$categoria = buscar_nome_categoria($id_categoria);

		array_push($ganhos, "<div class='panel-body'>". $categoria . "<b class='pull-right'> R$" . $total . "</b></div>");
		
	}

	return $ganhos;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$movimentos = [];

	array_push($movimentos, buscar_despesas_anuais());
	array_push($movimentos, buscar_receitas_anuais());

	echo json_encode($movimentos);
}

?>