<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$id = '';
	$novoNome = '';
	$novoEmail = '';
	$novaFaixaEtaria = '';
	$novoTipo = '';
	$novaPontuaηγo = '';
	$novaSenha = '';
	$repNovaSenha = '';
	$tpa = '';
	
	if(isset($_GET['id'])) $id = $_GET['id'];
	if(isset($_GET['novoNome'])) $novoNome = $_GET['novoNome'];
	if(isset($_GET['novoEmail'])) $novoEmail = $_GET['novoEmail'];
	if(isset($_GET['novaFaixaEtaria'])) $novaFaixaEtaria = $_GET['novaFaixaEtaria'];
	if(isset($_GET['novoTipo'])) $novoTipo = $_GET['novoTipo'];
	if(isset($_GET['novaPontuaηγo'])) $novaPontuaηγo = $_GET['novaPontuaηγo'];
	if(isset($_GET['novaSenha'])) $novaSenha = md5($_GET['novaSenha']);
	if(isset($_GET['repNovaSenha'])) $repNovaSenha = md5($_GET['repNovaSenha']);
	if(isset($_GET['tpa'])) $tpa = $_GET['tpa'];
	
	if($novaSenha != '' && $repNovaSenha != ''){
	
		$query = "UPDATE usuario SET nomPessoa = '$novoNome',
		endEmail = '$novoEmail',
		senha = '$novaSenha',
		tipoUsuario = '$novoTipo',
		pontos = '$novaPontuaηγo',
		faixaEtaria = '$novaFaixaEtaria'
		WHERE codUsuario = '$id'
		";
	}
	else{
		$query = "UPDATE usuario SET nomPessoa = '$novoNome',
		endEmail = '$novoEmail',
		tipoUsuario = '$novoTipo',
		pontos = '$novaPontuaηγo',
		faixaEtaria = '$novaFaixaEtaria'
		WHERE codUsuario = '$id'
		";
	}
	// Executa a query
	$atualiza = mysql_query($query);
	
	
	header('Location: listar_usuarios.php?tpa='.$tpa);
?>