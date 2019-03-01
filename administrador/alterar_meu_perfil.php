<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$id = '';
	$novoNome = '';
	$novoEmail = '';
	$novaFaixaEtaria = '';
	$novoTipo = '';
	$novaPontuação = '';
	$senhaAntiga = '';
	$novaSenha = '';
	$repNovaSenha = '';
	
	if(isset($_GET['id'])) $id = $_GET['id'];
	if(isset($_GET['novoNome'])) $novoNome = $_GET['novoNome'];
	if(isset($_GET['novoEmail'])) $novoEmail = $_GET['novoEmail'];
	if(isset($_GET['novaFaixaEtaria'])) $novaFaixaEtaria = $_GET['novaFaixaEtaria'];
	if(isset($_GET['novoTipo'])) $novoTipo = $_GET['novoTipo'];
	if(isset($_GET['novaPontuação'])) $novaPontuação = $_GET['novaPontuação'];
	if(isset($_GET['senhaAntiga'])) $senhaAntiga = md5($_GET['senhaAntiga']);
	if(isset($_GET['novaSenha'])) $novaSenha = $_GET['novaSenha'];
	if(isset($_GET['repNovaSenha'])) $repNovaSenha = $_GET['repNovaSenha'];
	
	$novaSenhaCodificada = md5($novaSenha);
	if($novaSenha != '' && $repNovaSenha != ''){
	
		$query = "UPDATE usuario SET nomPessoa = '$novoNome',
		endEmail = '$novoEmail',
		senha = '$novaSenhaCodificada',
		tipoUsuario = '$novoTipo',
		pontos = '$novaPontuação',
		faixaEtaria = '$novaFaixaEtaria'
		WHERE codUsuario = '$id'
		";
	}
	else{
		$query = "UPDATE usuario SET nomPessoa = '$novoNome',
		endEmail = '$novoEmail',
		tipoUsuario = '$novoTipo',
		pontos = '$novaPontuação',
		faixaEtaria = '$novaFaixaEtaria'
		WHERE codUsuario = '$id'
		";
	}
	// Executa a query
	$atualiza = $connection->query($query);
	
	
	header('Location: index.php');
?>