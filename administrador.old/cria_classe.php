<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$novonomeclasse = '';
	$novafaixa = '';
	$origem = '';
	
	if(isset($_GET['novonomeclasse'])) $novonomeclasse = $_GET['novonomeclasse'];
	if(isset($_GET['novafaixa'])) $novafaixa = $_GET['novafaixa'];
	if(isset($_GET['origem'])) $origem = $_GET['origem'];
	
	$query = "INSERT INTO classesdeusuarios (nomeClasse, desClasse) VALUES ('$novonomeclasse', '$novafaixa')
	";
	// Executa a query
	$insere = mysql_query($query);
	
	if($origem == 'salvar')
		header('Location: listar_classes.php');
	else
		header('Location: adicionar_classe.php');
?>