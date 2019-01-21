<?php
  require "usuarios.php";
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
  <link type="text/css" rel="stylesheet" href="css/cad_usuario.css"/>
  <script src="js/cadastrar_usuario.js"></script>
</head>
<body>
  <?php 
    if($login)
      header("Location: " . dirname($_SERVER['SCRIPT_NAME']) . "/index.php");
  ?>
  <div class="jumbotron" id ="cabecalho">
      <h1 align="center" id="titulo_cabecalho">MoneyManager</h1>
  </div>
<div class="container">
  <div class="row">
    <div class="col-xs-10">
      <h2 align="right">Dados do usuário</h2>
      <br>
      <form enctype="multipart/form-data" id="form-test" class="form-horizontal" method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <div class="form-group <?php if(!empty($erro_nome)){echo "has-error";}?>">
          <label for="inputNome" class="col-sm-4 control-label">Nome</label>
          <div class="col-sm-8">
            <input required type="text" class="form-control" name="nome" placeholder="Nome" value="<?php echo $nome; ?>">
            <div id="erro-nome">

            </div>
            <?php if (!empty($erro_nome)): ?>
              <span class="help-block"><?php echo $erro_nome ?></span>
            <?php endIf; ?>
          </div>
        </div>

        <div class="form-group <?php if(!empty($erro_email)){echo "has-error";}?>">
          <label for="inputEmail" class="col-sm-4 control-label">Email</label>
          <div class="col-sm-8">
            <input required type="email" class="form-control" name="email" placeholder="Email" value="<?php echo $email; ?>">
            <div id="erro-email">

            </div>
            <?php if (!empty($erro_email)): ?>
              <span class="help-block"><?php echo $erro_email ?></span>
            <?php endIf; ?>
          </div>
        </div>

        <div class="form-group <?php if(!empty($erro_senha)){echo "has-error";}?>">
          <label for="inputSenha" class="col-sm-4 control-label">Senha</label>
          <div class="col-sm-8">
            <input required type="password" class="form-control" name="senha" placeholder="Senha" value="<?php echo $senha; ?>">
            <div id="erro-senha">

            </div>
            <?php if (!empty($erro_senha)): ?>
              <span class="help-block"><?php echo $erro_senha ?></span>
            <?php endIf; ?>
          </div>
        </div>

        <div class="form-group <?php if(!empty($erro_confirmacao_senha)){echo "has-error";}?>">
          <label for="inputConfirmacaoSenha" class="col-sm-4 control-label">Confirmar senha</label>
          <div class="col-sm-8">
            <input required type="password" class="form-control" name="confirmacao_senha" placeholder="Confirmar senha" value="<?php echo $confirmacao_senha; ?>">
            <div id="erro-confirmacao-senha">

            </div>
            <?php if (!empty($erro_confirmacao_senha)): ?>
              <span class="help-block"><?php echo $erro_confirmacao_senha ?></span>
            <?php endIf; ?>
          </div>
        </div>

        <div class="col-sm-4">
        </div>        
        <div class="col-sm-8"><?php if ($_SERVER["REQUEST_METHOD"] == "POST"): ?>
          <?php if ($erro): ?>
            <div class="alert alert-danger">
              Erros no formulário.
            </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>

      <div id="erro-sql">
      </div>
      <?php if (!empty($erro_sql)): ?>
        <span class="help-block"><?php echo $erro_sql ?></span>
      <?php endIf; ?>

        <br>

        <div class="col-sm-6">
          <button type="button" id="voltar" class="btn btn-default">Voltar</button>
        </div>
        <div class="col-sm-6" align="right">
          <button type="submit" class="btn btn-default">Cadastrar</button>
        </div>
          
      </form>

    </div>
  </div>
</div>
</body>
</html>
