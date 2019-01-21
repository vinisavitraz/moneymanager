<?php

require "inicial.php";
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
  <script src="js/highcharts.js"></script>
  <script src="js/index.js"></script>
  <link type="text/css" rel="stylesheet" href="css/nav-bar.css"/>
  <link type="text/css" rel="stylesheet" href="css/index.css"/>
  <link type="text/css" rel="stylesheet" href="css/movimentos.css"/>
</head>
<body>

  <?php if ($login): ?>
    <nav id ="cabecalho" class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" id="logo">MoneyManager</a>
        </div>
        <ul class="nav navbar-nav">
          <li class="active"><a href="index.php">Página Inicial</a></li>
          <li><a href="movimentos.php">Movimentos</a></li>
          <li><a href="cadastrar_categoria.php">Categorias</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
          <li><a>Usuário logado: <?php echo $user_name;?></a></li>
          <li><a href="logout.php">Sair</a></li>
        </ul>
      </div>
    </nav>

    <div id="container" style="width:100%; height:400px;"></div>
    <br>
    <div class="col-sm-3">
      <div class="panel panel-default fixo">
        <div class="panel-heading" align="center">Balanceamento atual</div>
        <div class="panel-body">Dinheiro <b class="pull-right">R$<?php echo number_format(buscar_saldo_dinheiro($user_id), 2, ",", "."); ?></b></div>
        <div class="panel-body">Conta Corrente <b class="pull-right">R$<?php echo number_format(buscar_saldo_conta($user_id), 2, ",", "."); ?></b></div>
        <div class="panel-body"><b>Total</b> <b class="pull-right">R$<?php echo number_format(buscar_saldo_conta($user_id) + buscar_saldo_dinheiro($user_id), 2, ",", "."); ?></b></div>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel panel-default fixo">
        <div class="panel-heading" align="center">Movimentos recentes</div>
        <?php
        $movimentos = buscar_ultimos_mov($user_id);
        for ($i=0; $i < count($movimentos) ; $i++) { 
          echo $movimentos[$i];  
        }
        ?>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel panel-default fixo">
        <div class="panel-heading" align="center">Maiores gastos (por categoria)</div>
        <?php
        $gastos = buscar_maiores_gastos($user_id);
        for ($i=0; $i < count($gastos) ; $i++) { 
          echo $gastos[$i];  
        }
        ?>
      </div>
    </div>
    <div class="col-sm-3">
      <div class="panel panel-default fixo">
        <div class="panel-heading" align="center">Maiores ganhos (por categoria)</div>
        <?php
        $ganhos = buscar_maiores_ganhos($user_id);
        for ($i=0; $i < count($ganhos) ; $i++) { 
          echo $ganhos[$i];  
        }
        ?>
      </div>
    </div>


    <?php else: ?>
      <?php include("sem_permissao.php") ?>
    <?php endif; ?>

  </body>
  </html>
