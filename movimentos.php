<?php
require "authenticate.php";
require "movimentacoes.php";
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
  <script src="js/movimentos.js"></script>
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
       <li class="active"><a href="movimentos.php">Movimentos</a></li>
       <li><a href="cadastrar_categoria.php">Categorias</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
      <li><a>Usuário logado: <?php echo $user_name;?></a></li>
      <li><a href="logout.php">Sair</a></li>
    </ul>
  </div>
</nav>


<div class="container">
 <div class="row">
  <div class="col-lg-3">
    <br>
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 >Dados da movimentação</h4>
      </div>
      <br>
      <div class="col-md-offset-1" id="texto_transacao" hidden><p>Alterando dados da transação: <b id="transacao_alterada"></b></p></div>
      

      <br>
      <div class="panel-body">
        <form enctype="application/x-www-form-urlencoded" id="form-test">

          <input type="hidden" name="id" id="id">

          <div class="form-group col-lg-12"> 
            <select class="form-control" id="tipo" name = "tipo">
              <option disabled selected value> -- tipo --</option>
              <option value="E">Receita</option>
              <option value="S">Despesa</option>
            </select>
          </div>

          <div class="form-group col-lg-12">
           <input required type="text" class="form-control" name="descricao" placeholder="Descrição" value="<?php echo $descricao; ?>">
         </div>

         <div class="form-group col-lg-12">
          <input required type="text" class="form-control" name="valor" placeholder="Valor" value="<?php echo $valor; ?>">
        </div>

        <div class="form-group col-lg-12">
          <input required type="date" class="form-control" id="data_mov" name="data_mov" placeholder="Data" value="<?php echo $data_mov; ?>">
        </div>

        <div class="form-group col-lg-12">

          <?php
          $categorias = buscar_categorias();
          echo "<select class='form-control' id='categoria' name='categoria'>";
          for ($i=0; $i <  sizeof($categorias); $i++) { 
            echo $categorias[$i];
          }
          echo "</select>";
          ?>
        </div>

        <div class="form-group col-lg-12">
          <select class="form-control" id="forma" name ="forma">
            <option id = "Desabilitado" disabled selected value> -- forma monetária --</option>
            <option id ="Dinheiro" value="Dinheiro" hidden>Dinheiro</option>
            <option id = "Debito" value="Debito" hidden>Débito</option>
            <option id = "Transferencia" value="Transferencia" hidden>Transferencia</option>
            <option id = "Deposito" value="Deposito" hidden>Deposito</option>
          </select>
        </div>


        <div id="resultado_submit" hidden class="col-lg-12">
         <div class="alert alert-danger" id="erros">
          <ul id = "lista_erros">

          </ul>
        </div>
        <div class="alert alert-success" id="sucesso" hidden>Dados salvos!</div>
      </div>
      <br>
      <br>
      <div class="col-lg-12" align="left">
        <button type="button"  id="limpar" class="btn btn-default">Limpar</button>
        <button type="submit" id="cadastrar" class="btn btn-default pull-right">Cadastrar</button>
      </div>

    </form>
  </div>
</div>


</div>
<div class="col-lg-9" >
  <br>
  <div class="panel panel-default">
    <div class="panel-heading"><h4>Extrato de <b id="mes_selecionado_atual"><?php echo mes_atual(); ?></b> </h4></div>
    <div class="panel-body">
      <br>
      <h3>Filtros</h3>
      <form id="filtro">
        <label class="radio-inline"><input type="radio" value ="tudo" id = "tudo" checked="true" name="optradio">Receitas e despesas</label>
        <label class="radio-inline"><input type="radio" value ="Receita" name="optradio">Somente receitas</label>
        <label class="radio-inline"><input type="radio" value ="Despesa" name="optradio">Somente despesas</label>
      </form>
      <div class="dropdown" align="right">
        <button class="btn btn-light dropdown-toggle" type="button" data-toggle="dropdown">Meses
          <span class="caret"></span></button>
          <ul class="dropdown-menu dropdown-menu-right">
            <li><a id="Janeiro">Janeiro</a></li>
            <li><a id="Fevereiro">Fevereiro</a></li>
            <li><a id="Marco">Março</a></li>
            <li><a id="Abril">Abril</a></li>
            <li><a id="Maio">Maio</a></li>
            <li><a id="Junho">Junho</a></li>
            <li><a id="Julho">Julho</a></li>
            <li><a id="Agosto">Agosto</a></li>
            <li><a id="Setembro">Setembro</a></li>
            <li><a id="Outubro">Outubro</a></li>
            <li><a id="Novembro">Novembro</a></li>
            <li><a id="Dezembro">Dezembro</a></li>
          </ul>
        </div>

        <br>
        <table id="tabela_inteira" class="table table-bordered table-striped">
          <thead>
            <tr>
              <th scope="col">Transação</th>
              <th id="tipo_tabela" scope="col">Tipo</th>
              <th scope="col">Descrição</th>
              <th scope="col">Valor</th>
              <th scope="col">Categoria</th>
              <th scope="col">Forma</th>
              <th scope="col">Data</th>
              <th scope="col">Editar</th>
              <th scope="col">Excluir</th>
            </tr>
          </thead>
          <tbody id ="tabela">
           <?php $tabela = buscar_movimentos_mes(date('m'), $user_id);

           for ($i=0; $i < count($tabela); $i++) { 
             echo $tabela[$i];
           }
           ?> 
         </tbody>
       </table>
     </div>
   </div>


 </div>



</div>
</div>


<?php else: ?>
  <?php include("sem_permissao.php") ?>
<?php endif; ?>

</body>
</html>