//voltar para a pagina de login
$(function(){
  $("#voltar").click(function(){
  	var root = document.location.hostname;

    window.location.replace("login.php");
  });

});
