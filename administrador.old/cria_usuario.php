<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$novoNome = '';
	$novoEmail = '';
	$repNovoEmail = '';
	$novaFaixaEtaria = '';
	$novoTipo = '';
	$novaSenha = '';
	$repNovaSenha = '';
	$origem = '';
	$tpa = '';
	
	if(isset($_GET['novoNome'])) $novoNome = $_GET['novoNome'];
	if(isset($_GET['novoEmail'])) $novoEmail = $_GET['novoEmail'];
	if(isset($_GET['repNovoEmail'])) $repNovoEmail = $_GET['repNovoEmail'];
	if(isset($_GET['novaFaixaEtaria'])) $novaFaixaEtaria = $_GET['novaFaixaEtaria'];
	if(isset($_GET['novoTipo'])) $novoTipo = $_GET['novoTipo'];
	if(isset($_GET['novaSenha'])) $novaSenha = md5($_GET['novaSenha']);
	if(isset($_GET['repNovaSenha'])) $repNovaSenha = md5($_GET['repNovaSenha']);
	if(isset($_GET['origem'])) $origem = $_GET['origem'];
	if(isset($_GET['tpa'])) $tpa = $_GET['tpa'];
	
	$query = "INSERT INTO usuario (nomPessoa, endEmail, senha, tipoUsuario, pontos, faixaEtaria, classeUsuario) VALUES ('$novoNome', '$novoEmail', '$novaSenha', '$novoTipo', '5.00', '$novaFaixaEtaria', '2')
	";
	// Executa a query
	$insere = mysql_query($query);
	
	if($origem == 'salvar')
		header('Location: listar_usuario.php?tpa='.$tpa);
	else
		header('Location: adicionar_usuario.php');
?>