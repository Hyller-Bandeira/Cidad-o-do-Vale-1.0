<?php 
	require("../phpsqlinfo_dbinfo.php"); 

	$codCategoriaEvento = '';
	if(isset($_GET["codCategoriaEvento"])) $codCategoriaEvento = $_GET["codCategoriaEvento"];
	$consultaColaboracao = $connection->query("SELECT * FROM colaboracao WHERE codColaboracao = '$codCategoriaEvento'" );
	$rowColaboracao = $consultaColaboracao->fetch_assoc();
	echo $rowColaboracao['desJustificativa'] ;
?>