<?php
require 'phpsqlinfo_dbinfo.php';
session_start();
$s = $_SESSION['tabela_'.$link_inicial];

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment;Filename=todas_colaboracoes.xls");

echo $s;

?>

