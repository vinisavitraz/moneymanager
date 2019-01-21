<?php
require("credentials.php");
ini_set('default_charset', 'UTF-8');

function connect_db(){
  global $servername, $username, $db_password, $dbname;
  $conn = mysqli_connect($servername, $username, $db_password);

  if (!$conn) {
  		echo $servername;
  		echo $username;
  		echo "senha:";
  		echo $db_password;
  		echo $dbname;
      die("Connection failed: " . mysqli_connect_error());
  }
  
  mysqli_select_db($conn, $dbname);
  mysqli_set_charset($conn,"utf8");
  return($conn);
}

function disconnect_db($conn){
  mysqli_close($conn);
}

?>
