<?php
require 'phpsqlinfo_dbinfo.php';

$apelido_post = '';
if(isset($_GET["apelido"])) $apelido_post = $_GET["apelido"];

$apelido_post = strtolower($apelido_post);
$sql = $connection->query("SELECT * FROM usuario WHERE LOWER(apelidoUsuario) = '$apelido_post'");
$retorno = $sql->num_rows; //Verifica se encontrou algo

if($retorno > 0) { echo "0"; }
else { echo "1"; }