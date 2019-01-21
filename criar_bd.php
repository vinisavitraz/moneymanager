<?php
require_once "db_functions.php";
ini_set('default_charset', 'UTF-8');

$conn = connect_db();

$criar_banco = "CREATE DATABASE IF NOT EXISTS $dbname";

if (mysqli_query($conn, $criar_banco)) {
    mysqli_select_db($conn, $dbname);
} else {
    echo "Error creating database: " . mysqli_error($conn);
}

$criar_tabela_usuarios = "CREATE TABLE IF NOT EXISTS Usuarios (
  id_usuario INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50) NOT NULL,
  email VARCHAR(50) NOT NULL UNIQUE,
  senha varchar(50),
  saldo_dinheiro DECIMAL(10,2),
  saldo_conta DECIMAL(10,2) 
)";

if (!mysqli_query($conn, $criar_tabela_usuarios)) {
  echo "Error creating table usuarios: " . mysqli_error($conn);
} 

$criar_tabela_categorias = "CREATE TABLE IF NOT EXISTS Categorias (
  id_categoria INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(50) UNIQUE NOT NULL
)";

if (!mysqli_query($conn, $criar_tabela_categorias)) {
    echo "Error creating table: " . mysqli_error($conn);
} 


$criar_tabela_movimentos = "CREATE TABLE IF NOT EXISTS Movimentos (
  id_mov INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  transacao CHAR(5),
  tipo CHAR(1),
  descricao VARCHAR(50),
  valor DECIMAL(10,2),
  forma_monetaria VARCHAR(20),
  data_mov DATE,
  id_categoria INT(6) UNSIGNED,
  id_usuario INT(6) UNSIGNED,  
  FOREIGN KEY (id_categoria) REFERENCES categorias (id_categoria),
  FOREIGN KEY (id_usuario) REFERENCES usuarios (id_usuario)
)";

if (!mysqli_query($conn, $criar_tabela_movimentos)) {
    echo "Error creating table: " . mysqli_error($conn);
} 

disconnect_db($conn);
?>
