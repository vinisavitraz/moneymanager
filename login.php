<?php
require "db_functions.php";
require "criar_bd.php";
require "authenticate.php";
ini_set('default_charset', 'UTF-8');

$erro = false;
$password = $email = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (isset($_POST["email"]) && isset($_POST["password"])) {

   $conn = connect_db();

   $email = mysqli_real_escape_string($conn,$_POST["email"]);
   $password = mysqli_real_escape_string($conn,$_POST["password"]);
   $password = md5($password);

   $sql = "SELECT id_usuario, nome, email, senha FROM usuarios
   WHERE email = '$email';";

   $result = mysqli_query($conn, $sql);

   if($result){
    if (mysqli_num_rows($result) > 0) {
      $user = mysqli_fetch_assoc($result);

      if ($user["senha"] == $password) {

        $_SESSION["user_id"] = $user["id_usuario"];
        $_SESSION["user_name"] = $user["nome"];
        $_SESSION["user_email"] = $user["email"];

        header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
        exit();
      }
      else {
        $error_msg = "Senha incorreta!";
        $erro = true;
      }
    }
    else{
      $error_msg = "Email não cadastrado!";
      $erro = true;
    }
  }

}
else {
  $error_msg = "Por favor, preencha todos os dados.";
  $erro = true;
}
}

?>

<!DOCTYPE html>
<html>
<head>
  <title>Sistema Financeiro</title>
  <link rel="shortcut icon" href="img/ico.gif">
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <script src="js/jquery.min.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <link type="text/css" rel="stylesheet" href="css/login.css"/>
  
</head>
<body>
  <?php 
  if($login)
    header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
  ?>
  
  <div class="jumbotron" id ="cabecalho">
   <h1 align="center" id="titulo_cabecalho">MoneyManager</h1>
 </div>

 <div id="container">
  <h1 id="logo">MM</h1>

  <?php if ($erro): ?>
    <h5><?php echo $error_msg; ?></h5>
  <?php endif; ?>

  <div class="col-xs-12">
    <form id="form_login" action="login.php" method="post">
     <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
      <input required id="email" type="text" class="form-control" name="email" placeholder="Email">
    </div>

    <div class="input-group">
      <span class="input-group-addon"><i class="glyphicon glyphicon-lock"></i></span>
      <input required id="password" type="password" class="form-control" name="password" placeholder="Senha">
    </div>

    <button type="submit" class="btn btn-default">Entrar</button>
  </form>	

  <a id="cadastrar" href="cadastrar_usuario.php">Realizar cadastro</a>
</div>

</div>
</body>
</html>
