<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$novoNomeCategoria = '';
	$origem = '';
	
	if(isset($_GET['novoNomeCategoria'])) $novoNomeCategoria = $_GET['novoNomeCategoria'];
	if(isset($_GET['origem'])) $origem = $_GET['origem'];
	
	$query = "INSERT INTO categoriaevento (desCategoriaEvento) VALUES ('$novoNomeCategoria')
	";
	// Executa a query
	$insere = $connection->query($query);
	
	if($origem == 'salvar')
		header('Location: listar_categorias.php');
	else
		header('Location: adicionar_categoria.php');
?>