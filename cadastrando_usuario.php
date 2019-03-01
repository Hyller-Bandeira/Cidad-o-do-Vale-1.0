<?php
require 'phpsqlinfo_dbinfo.php';

$nomPessoa_post = '';
$apelidoPessoa_post = '';
$endEmail_post = '';
$senha_post = '';
$endEmail_post2 = '';
$senha_post2 = '';
$faixaEtaria = '';

if(isset($_POST["nomPessoa"])) $nomPessoa_post = $_POST["nomPessoa"];
if(isset($_POST["apelidoPessoa"])) $apelidoPessoa_post = $_POST["apelidoPessoa"];
if(isset($_POST["endEmail"])) $endEmail_post = $_POST["endEmail"];
if(isset($_POST["senha"])) $senha_post = md5($_POST["senha"]);
if(isset($_POST["endEmail2"])) $endEmail_post2 = $_POST["endEmail2"];
if(isset($_POST["senha2"])) $senha_post2 = md5($_POST["senha2"]);
if(isset($_POST["faixaEtaria"])) $faixaEtaria = $_POST["faixaEtaria"];
$TipoUsuario_post = "C";
$classeUsuario = 2;
$pontos = 5;

if ($nomPessoa_post == '' || $apelidoPessoa_post == '' || $endEmail_post == '' || $senha_post == '' || $endEmail_post2 == '' || $senha_post2 == '' || $faixaEtaria == '') {
    header("location: colaborar.php?erro=2");
}


$query = "SELECT * FROM usuario WHERE endEmail = '$endEmail_post' ||  apelidoUsuario = '$apelidoPessoa_post' ";
$result = $connection->query($query);
//die(print_r($connection));
$testaEndEmail = $result->fetch_array();

$sql = "INSERT INTO usuario (apelidoUsuario, nomPessoa,  endEmail,  senha,  TipoUsuario, pontos, faixaEtaria, classeUsuario)
		VALUES('$apelidoPessoa_post', '$nomPessoa_post', '$endEmail_post', '$senha_post', '$TipoUsuario_post', '$pontos', '$faixaEtaria', '$classeUsuario')";
// Executa o comando SQL
$result2 = $connection->query($sql);

// Verifica se o comando foi executado com sucesso
if(!$result2) die("Falha ao executar o comando: " .$connection->error);
else
{
	session_start();
	$login = $endEmail_post;
	$senha = $senha_post;
	$_SESSION["user_".$link_inicial] = $login;
	$_SESSION["pass_".$link_inicial] = $senha;

	$codigo2 = $connection->query("SELECT * FROM usuario WHERE endEmail='$login' and senha='$senha'") or die ("Erro query:SELECT*FORM<br>");
	$codigo3 = @$codigo2->fetch_assoc() ;
	$_SESSION['code_user_'.$link_inicial] = $codigo3['codUsuario'];
	$_SESSION['name_user_'.$link_inicial] = $codigo3['apelidoUsuario'];

	header("location: colaborar.php");	// Cria a sessão e redireciona a esta pagina
}