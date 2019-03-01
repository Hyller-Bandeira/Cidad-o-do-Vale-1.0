<?php
require 'phpsqlinfo_dbinfo.php';

$codColaboracao = '';
if(isset($_GET["codColaboracao"])) $codColaboracao = addslashes(trim($_GET["codColaboracao"]));

$consulta = $connection->query("SELECT * FROM colaboracao WHERE codColaboracao = '$codColaboracao' ");

$resultado = "";
$row = $consulta->fetch_assoc();

$temp1 = $row['codCategoriaEvento'];
$temp2 = $row['codTipoEvento'];
$temp3 = $row['desTituloAssunto'];
$temp4 = $row['desColaboracao'];
$temp5 = $row['datahoraCriacao'];
$temp6 = $row['dataOcorrencia'];
$temp7 = $row['horaOcorrencia'];

$consultaCategoria = $connection->query("SELECT * FROM categoriaevento WHERE codCategoriaEvento = '$temp1'");
$rowCategoria = $consultaCategoria->fetch_assoc();
$temp8 = $rowCategoria['desCategoriaEvento'];

$consultaTipo = $connection->query("SELECT * FROM tipoevento WHERE codTipoEvento = '$temp2'");
$rowTipo = $consultaTipo->fetch_assoc();
$temp9 = $rowTipo['desTipoEvento'];

$resultado .= $temp8 . ">>>" . $temp9 . ">>>" . $temp3 . ">>>" . $temp4 . ">>>" . $temp5 . ">>>" . $temp6 . ">>>" . $temp7;
$resultado .= ">>>";

echo $resultado;