<?php
require 'phpsqlinfo_dbinfo.php';

// Checa os dados fornecidos pelo formulario e os trata adequadamente

$login = '';
$senha = '';
$nomPessoa_post = '';
$faixaEtaria = '';

if(isset($_GET["login"])) $login = $_GET["login"];
else if(isset($_GET['openid_ext1_value_email'])) $login = $_GET['openid_ext1_value_email'];

if(isset($_GET["senha"])) $senha = md5($_GET["senha"]);
else if(isset($_GET['openid_ext1_value_firstname'])) $senha = $_GET['openid_ext1_value_firstname'];

if(isset($_GET["apelidoUsuario"])) $nomPessoa_post = $_GET["apelidoUsuario"];
else if(isset($_GET['openid_ext1_value_firstname'])) $nomPessoa_post = $_GET['openid_ext1_value_firstname'];

$TipoUsuario_post = "C";

if(isset($_GET["faixaEtaria"])) $faixaEtaria = $_GET["faixaEtaria"];
else $faixaEtaria = "Não informado";

$classeUsuario = 2;
$pontos = 5;

$autentic = $connection->query("SELECT * FROM usuario WHERE (endEmail='$login' or apelidoUsuario='$login' )") or die ("Erro query:SELECT*FORM<br>");

$resultado = $autentic->num_rows;

if($resultado == 1)
{
	// Os dados estão corretos, a sessão é criada
	session_start();
	$_SESSION["user_".$link_inicial] = $login;
	$_SESSION["pass_".$link_inicial] = $senha;

	$codigo2 = $connection->query("SELECT * FROM usuario WHERE (endEmail='$login' or apelidoUsuario='$login' )") or die ("Erro consulta");
	$codigo3 = $codigo2->fetch_assoc();
	$_SESSION['code_user_'.$link_inicial] = $codigo3['codUsuario'];
	$_SESSION['name_user_'.$link_inicial] = $codigo3['apelidoUsuario'];
	$_SESSION['email_user_'.$link_inicial] = $codigo3['endEmail'];

	header("location: colaborar.php");//cria a sessão e redireciona a esta pagina
}
else
{
	$query = "SELECT * FROM usuario WHERE (endEmail='$login' or apelidoUsuario='$login' ) ";
	$result = $connection->query($query);
	$testaEndEmail = $result->fetch_array($result);

	$sql = "INSERT INTO usuario (apelidoUsuario, nomPessoa,  endEmail,  senha,  TipoUsuario, pontos, faixaEtaria, classeUsuario)
			VALUES('$nomPessoa_post', '$nomPessoa_post', '$login', '$senha', '$TipoUsuario_post', '$pontos', '$faixaEtaria', '$classeUsuario')";
	// Executa o comando SQL
	$result2 = $connection->query($sql);

	// Verifica se o comando foi executado com sucesso
	if(!$result2) die("Falha ao executar o comando: " . $connection->error);
	else
	{
		session_start();
		$login = $login;
		$senha = $senha;
		$_SESSION["user_".$link_inicial] = $login;
		$_SESSION["pass_".$link_inicial] = $senha;

		$codigo2 = $connection->query("SELECT * FROM usuario WHERE (endEmail='$login' or apelidoUsuario='$login' ) and senha='$senha'") or die ("Erro query:SELECT*FORM<br>");
		$codigo3 = @$codigo2->fetch_assoc();
		$_SESSION['code_user_'.$link_inicial] = $codigo3['codUsuario'];
		$_SESSION['name_user_'.$link_inicial] = $codigo3['apelidoUsuario'];

		header("location: colaborar.php");	// Cria a sessão e redireciona a esta pagina
	}
};