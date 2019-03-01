<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$novoNomeTipo = '';
	$novaCategoria = '';
	$cga = '';
	$origem = '';
	
	if(isset($_GET['novoNomeTipo'])) $novoNomeTipo = $_GET['novoNomeTipo'];
	if(isset($_GET['novaCategoria'])) $novaCategoria = $_GET['novaCategoria'];
	if(isset($_GET['cga'])) $cga = $_GET['cga'];
	if(isset($_GET['origem'])) $origem = $_GET['origem'];
	
	$query = "INSERT INTO tipoevento (desTipoEvento, codCategoriaEvento) VALUES ('$novoNomeTipo', '$novaCategoria')
	";
	// Executa a query
	$insere = mysql_query($query);
	
	if($origem == 'salvar')
		header('Location: listar_tipos.php?cga='.$cga);
	else
		header('Location: adicionar_tipo.php?cga='.$cga);
?>