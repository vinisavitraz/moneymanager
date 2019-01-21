<?php
require "db_functions.php";
ini_set('default_charset', 'UTF-8');

function verifica_campo($texto){
	$texto = trim($texto);
	$texto = stripslashes($texto);
	$texto = htmlspecialchars($texto);
	return $texto;
}

$nome = "";
$erro = false;
$mostrar=true;

function verificar_nome($nome){
	$conn = connect_db();
	$nome_cadastrado = false;

	$stmt = mysqli_prepare($conn, "SELECT nome FROM categorias where nome = ?");
	
	mysqli_stmt_bind_param($stmt, "s", $nome);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	if (mysqli_num_rows($result) > 0) {
		$nome_cadastrado = true;
	}
	
	disconnect_db($conn);

	return $nome_cadastrado;
}

function inserir_banco($nome){
	$conn = connect_db();
	$retorno = [];
	
	if(!verificar_nome($nome)){
		$sql = "INSERT INTO categorias (nome) VALUES ('$nome')";


		if (!mysqli_query($conn, $sql)) {
			$erro = true;
			$erro_sql = $sql . "<br>" . mysqli_error($conn);

			$retorno = [
				"status" => "erro_sql",
				"descricao" => $erro_sql
			];
		}
		else{
			$retorno = [
				"status" => "ok"
			];
		}
	}
	else{
		$retorno = [
			"status" => "erro",
			"descricao" => "Já existe uma categoria com o nome " . $nome
		];
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
			$nome_inserir = verifica_campo($mov["nome"]);

			$nome = "";

			$retorno = inserir_banco($nome_inserir);

			if($retorno["status"] == "ok"){
				array_push($resposta, "ok");

				echo json_encode($resposta, JSON_UNESCAPED_SLASHES);
			}
			else if($retorno["status"] == "erro") {
				array_push($resposta, "erro_sql");
				array_push($resposta, $retorno["descricao"]);

				echo json_encode($resposta, JSON_UNESCAPED_SLASHES);
			}
		}

		
	}
}
function validar_edits($mov){
	$erros = [];

	if(empty($mov["nome"])){
		$erro = "<li>" . "Nome é obrigatório" . "</li>";
		array_push($erros, $erro);
	}
	if(verificar_nome($mov["nome"])){
		$erro = "<li>" . "Já existe uma categoria com o nome " . $mov["nome"] . "</li>";
		array_push($erros, $erro);	
	}

	return $erros;

}
?>