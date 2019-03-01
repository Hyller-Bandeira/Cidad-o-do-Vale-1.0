<?php 
	require("../phpsqlinfo_dbinfo.php"); 

	$codCategoriaEvento = '';
	if(isset($_GET["codCategoriaEvento"])) $codCategoriaEvento = $_GET["codCategoriaEvento"];
	$consultaColaboracao = mysql_query("SELECT * FROM colaboracao WHERE codColaboracao = '$codCategoriaEvento'" );
	$rowColaboracao = mysql_fetch_assoc($consultaColaboracao);
	echo $rowColaboracao['desJustificativa'] ;
?>