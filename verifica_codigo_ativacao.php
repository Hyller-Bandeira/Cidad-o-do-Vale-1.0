<?php
require 'phpsqlinfo_dbinfo.php';

$codigo_ativacao = '';
if(isset($_GET["codigo_ativacao"])) $codigo_ativacao = md5($_GET["codigo_ativacao"]);

$query = "SELECT * FROM usuario WHERE senha = '$codigo_ativacao' ";
$result = $connection->query($query);
$retorno = $result->num_rows;	//Verifica se encontrou algo

if($retorno > 0) { echo "0"; }
else { echo "1"; }