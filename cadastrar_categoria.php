<?php
require "categorias.php";
require "authenticate.php";
ini_set('default_charset', 'UTF-8');
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
  <link type="text/css" rel="stylesheet" href="css/nav-bar.css"/>
  <link type="text/css" rel="stylesheet" href="css/movimentos.css"/>
  <script src="js/categorias.js"></script>
  
</head>
<body>
  <?php if ($login): ?>
    <nav id ="cabecalho" class="navbar navbar-default">
     <div class="container-fluid">
      <div class="navbar-header">
       <a class="navbar-brand" id="logo">MoneyManager</a>
     </div>
     <ul class="nav navbar-nav">
       <li><a href="index.php">Página Inicial</a></li>
       <li><a href="movimentos.php">Movimentos</a></li>
       <li class="active"><a href="cadastrar_categoria.php">Categorias</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
      <li><a>Usuário logado: <?php echo $user_name;?></a></li>
      <li><a href="logout.php">Sair</a></li>
    </ul>
  </div>
</nav>
<br>
<br>

<div class="col-lg-6 col-md-offset-3">
  <div class="panel panel-default">
    <div class="panel-heading"><h4>Dados da categoria</h4></div>
    <div class="panel-body">
      <form id="form-test" enctype="application/x-www-form-urlencoded">

        <div class="form-group col-lg-12">
          <input required type="text" class="form-control" name="nome" placeholder="Nome da categoria" value="<?php echo $nome; ?>">
          <br>
          <div id="resultado_submit" hidden = "<?php $mostrar?>"class="col-lg-12">
           <div class="alert alert-danger" id="erros">
            <ul id = "lista_erros">

            </ul>
          </div>
          <div class="alert alert-success" id="sucesso" hidden>Dados salvos!</div>
        </div>
        <button type="submit" class="btn btn-default pull-right">Cadastrar</button>
      </div>
    </form>
  </div>
</div>




</div>



<?php else: ?>
  <?php include("sem_permissao.php") ?>
<?php endif; ?>
</body>
</html>
