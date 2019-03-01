<?php
require 'phpsqlinfo_dbinfo.php';


$email = '';
$codigo_ativacao = '';
$nova_senha = '';

if(isset($_POST["endEmail"])) $email = $_POST["endEmail"];
if(isset($_POST["codigo_ativacao"])) $codigo_ativacao = md5($_POST["codigo_ativacao"]);
if(isset($_POST["nova_senha"])) $nova_senha = md5($_POST["nova_senha"]);

$query = "SELECT * FROM usuario WHERE endEmail = '$email' ";
$result = $connection->query($query);
$linhas = $result->num_rows;

$senha_bd = $result->fetch_array();

if($linhas > 0)
{
	if($codigo_ativacao == $senha_bd['senha'])
	{
		$alt = "UPDATE usuario SET senha = '$nova_senha' WHERE endEmail = '$email'";
        $connection->query($alt);

		session_start();
		$login = $email;
		$senha = $nova_senha;
		$_SESSION["user_".$link_inicial] = $login;
		$_SESSION["pass_".$link_inicial] = $senha;

		$codigo2 = $connection->query("SELECT * FROM usuario WHERE endEmail='$login' and senha='$senha'");

		$codigo3 = $codigo2->fetch_assoc();
		$_SESSION['code_user_'.$link_inicial] = $codigo3['codUsuario'];
		$_SESSION['name_user_'.$link_inicial] = $codigo3['apelidoUsuario'];

		header("location: colaborar");	// Cria a sessão e redireciona a esta pagina
	}
	else { echo "<script>alert('Codigo de ativação errado!');window.location.href = 'inicio';</script>"; }

}
else { echo "<script>alert('Email não existe!');window.location.href = 'inicio';</script>"; }