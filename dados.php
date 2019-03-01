<?php
header('content-type: text/html; charset=utf-8');

require 'phpsqlinfo_dbinfo.php';

$id = '';

if(isset($_POST["id"])) $id = utf8_decode($_POST["id"]);

$consulta = $connection->query("SELECT * FROM categoriaevento WHERE desCategoriaEvento = '$id'");
$row = $consulta->fetch_assoc();
$id2 = $row['codCategoriaEvento'];

$consulta2 = $connection->query("SELECT * FROM tipoevento WHERE codCategoriaEvento = '$id2'");

$resultado = "";

while($row2 = $consulta2->fetch_assoc())
	$resultado .= $row2['desTipoEvento'] . ",";

$resultado = substr($resultado, 0, -1);
echo $resultado;