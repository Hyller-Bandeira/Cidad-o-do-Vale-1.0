<?php
require 'phpsqlinfo_dbinfo.php';

$codUsuario = '';
$codColaboracao = '';

if(isset($_GET["codUsuario"])) $codUsuario = addslashes(trim($_GET["codUsuario"]));
if(isset($_GET["codColaboracao"])) $codColaboracao = addslashes(trim($_GET["codColaboracao"]));

$consulta = $connection->query("SELECT * FROM avaliacao WHERE codUsuario = '$codUsuario' AND codColaboracao = '$codColaboracao' ");

$resultado = 0;

if($row = $consulta->fetch_assoc())
{
	$resultado = 1;
}

echo $resultado;