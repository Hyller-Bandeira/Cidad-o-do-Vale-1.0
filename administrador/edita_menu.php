<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$id = '';
	$novoNome = '';
	$novoEndereco = '';
	$novoStatus = '';
	$sta = '';
	
	if(isset($_GET['id'])) $id = $_GET['id'];
	if(isset($_GET['novoNome'])) $novoNome = $_GET['novoNome'];
	if(isset($_GET['novoEndereco'])) $novoEndereco = $_GET['novoEndereco'];
	if(isset($_GET['novoStatus'])) $novoStatus = $_GET['novoStatus'];
	if(isset($_GET['sta'])) $sta = $_GET['sta'];
	
	$query = "UPDATE menu SET nomeItem = '$novoNome',
	enderecoItem = '$novoEndereco',
	statusItem = '$novoStatus'
	WHERE codMenu = '$id'
	";
	
	// Executa a query
	$atualiza = $connection->query($query)or die($connection->error);
	
	header('Location: listar_menu.php?sta='.$sta);
?>