<?php
require "db_functions.php";

function verifica_campo($texto){
  $texto = trim($texto);
  $texto = stripslashes($texto);
  $texto = htmlspecialchars($texto);
  return $texto;
}

function verificar_email ($email){
	$conn = connect_db();

	$stmt = mysqli_prepare($conn, "SELECT usuarios.email FROM usuarios where usuarios.email = ?");
	
	mysqli_stmt_bind_param($stmt, "s", $email);

	mysqli_stmt_execute($stmt);

	$result = mysqli_stmt_get_result($stmt);

	disconnect_db($conn);

    if (mysqli_num_rows($result) > 0) {
      return true;
	} else {
	  return false;
	}
}

$nome = "";
$senha = "";
$email = "";
$confirmacao_senha = "";
$erro = false;


if ($_SERVER["REQUEST_METHOD"] == "POST") {

	if(empty($_POST["nome"])){
    	$erro_nome = "Nome é obrigatório.";
    	$erro = true;
	}
	else{
		$nome = verifica_campo($_POST["nome"]);
	}

	if(empty($_POST["email"])){
		$erro_email = "Email é obrigatório.";
		$erro = true;
	}
	else{
		if(verificar_email($_POST["email"])){
			$erro_email = "Já existe um usuário cadastrado com o email '" . $_POST["email"] ."'";
			$erro = true;
		}

		$email = verifica_campo($_POST["email"]);
	}
	if(empty($_POST["senha"])){
    	$erro_senha = "Senha é obrigatória.";
    	$erro = true;
	}
	else{
		$senha = verifica_campo($_POST["senha"]);
	}

	if(empty($_POST["confirmacao_senha"])){
		$erro_confirmacao_senha = "Confirmação da senha é obrigatória.";
		$erro = true;
	}
	else{
		$confirmacao_senha = verifica_campo($_POST["confirmacao_senha"]);
	}

	if($senha != $confirmacao_senha){
		$erro_confirmacao_senha = "As senhas não correspondem.";
		$erro = true; 
	}

	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
		$erro_email = "Email inválido.";
		$erro = true; 
	}

	if(!$erro){
		$conn = connect_db();

		$senha = md5($senha);

		$sql = "INSERT INTO usuarios (nome, email, senha, saldo_dinheiro, saldo_conta)
		VALUES ('$nome', '$email', '$senha', 0, 0)";

		if (!mysqli_query($conn, $sql)) {
			$erro = true;
			$erro_sql = $sql . "<br>" . mysqli_error($conn);
	    	
		}

		$nome = "";
        $email = "";
        $senha = "";
        $confirmacao_senha = "";  

		disconnect_db($conn);

		header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/login.php");
	}
	
	
}
?>