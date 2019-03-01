<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$novoNomeCategoria = '';
	$id = '';
	
	if(isset($_GET['novoNomeCategoria'])) $novoNomeCategoria = $_GET['novoNomeCategoria'];
	if(isset($_GET['id'])) $id = $_GET['id'];
	
	$query = "UPDATE categoriaevento SET desCategoriaEvento = '$novoNomeCategoria' WHERE codCategoriaEvento = '$id'
	";
	// Executa a query
	$atualiza = $connection->query($query);
	
	
	header('Location: listar_categorias.php');
?>