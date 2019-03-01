<?php
require 'phpsqlinfo_dbinfo.php';

$endEmail_post = '';
if(isset($_GET["endEmail"])) $endEmail_post = $_GET["endEmail"];

$endEmail_post = strtolower($endEmail_post);
$sql = $connection->query("SELECT * FROM usuario WHERE LOWER(endEmail) = '$endEmail_post'");
$retorno = $sql->num_rows; //Verifica se encontrou algo

if($retorno > 0) { echo "0"; }
else { echo "1"; }