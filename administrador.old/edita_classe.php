<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$novoNomeClasse = '';
	$faixaPontos = '';
	$id = '';
	
	if(isset($_GET['novoNomeClasse'])) $novoNomeClasse = $_GET['novoNomeClasse'];
	if(isset($_GET['faixaPontos'])) $faixaPontos = $_GET['faixaPontos'];
	if(isset($_GET['id'])) $id = $_GET['id'];
	
	$query = "UPDATE classesdeusuarios SET nomeClasse = '$novoNomeClasse', desClasse = '$faixaPontos' WHERE codClasse = '$id'
	";
	// Executa a query
	$atualiza = mysql_query($query);
	
	
	header('Location: listar_classes.php');
?>