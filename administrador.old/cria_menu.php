<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$novoNome = '';
	$novoEndereco = '';
	$statusItem = '';
	$origem = '';
	$sta = '';
	
	if(isset($_GET['novoNome'])) $novoNome = $_GET['novoNome'];
	if(isset($_GET['novoEndereco'])) $novoEndereco = $_GET['novoEndereco'];
	if(isset($_GET['statusItem'])) $statusItem = $_GET['statusItem'];
	if(isset($_GET['origem'])) $origem = $_GET['origem'];
	if(isset($_GET['sta'])) $sta = $_GET['sta'];
	
	$novaOrdem = '';
	
	$consulta = mysql_query("SELECT * FROM menu ORDER BY codMenu DESC");
	$resultado = mysql_fetch_assoc($consulta);
	$novaOrdem = intval($resultado['codMenu']);
	
	$query = "INSERT INTO menu (nomeItem, statusItem, enderecoItem, ordemItem) VALUES ('$novoNome', '$statusItem', '$novoEndereco', '$novaOrdem')";
	// Executa a query
	$insere = mysql_query($query)or die(mysql_error());
	
	if($origem == 'salvar')
		header('Location: listar_menu.php?sta='.$sta);
	else
		header('Location: adicionar_menu.php');
		
?>