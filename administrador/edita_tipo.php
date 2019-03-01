<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$novoNomeTipo = '';
	$novaCategoria = '';
	$id = '';
	$cga = '';
	
	if(isset($_GET['novoNomeTipo'])) $novoNomeTipo = $_GET['novoNomeTipo'];
	if(isset($_GET['novaCategoria'])) $novaCategoria = $_GET['novaCategoria'];
	if(isset($_GET['id'])) $id = $_GET['id'];
	if(isset($_GET['cga'])) $cga = $_GET['cga'];
	
	$query = "UPDATE tipoevento SET desTipoEvento = '$novoNomeTipo', 
	codCategoriaEvento = '$novaCategoria' 
	WHERE codTipoEvento = '$id'
	";
	// Executa a query
	$atualiza = $connection->query($query);
	
	
	header('Location: listar_tipos.php?cga='.$cga);
?>