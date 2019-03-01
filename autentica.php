<?php
	require 'phpsqlinfo_dbinfo.php';
	//checa os dados fornecidos pelo formulario e os trata adequadamente

	$login = '';
	$senha = '';
	if(isset($_POST["login"])) $login = $_POST["login"];
	if(isset($_POST["senha"])) $senha = md5($_POST["senha"]);

	$autentic = $connection->query("SELECT * FROM usuario WHERE (endEmail='$login' or apelidoUsuario='$login' ) and senha='$senha'") or die ("Erro query: SELECT * FROM<br />");

	$resultado = $autentic->num_rows;

	if($resultado == 1)
	{
		// Os dados estão corretos a sessão é criada
		session_start();
		$_SESSION["user_".$link_inicial] = $login;
		$_SESSION["pass_".$link_inicial] = $senha;

		$codigo2 = $connection->query("SELECT * FROM usuario WHERE (endEmail='$login' or apelidoUsuario='$login' ) and senha='$senha'") or die ("Erro query: SELECT * FROM<br />");

		$codigo3 = @$codigo2->fetch_assoc() ;
		$_SESSION['code_user_'.$link_inicial]  = $codigo3['codUsuario'];
		$_SESSION['name_user_'.$link_inicial]  = $codigo3['apelidoUsuario'];
		$_SESSION['email_user_'.$link_inicial] = $codigo3['endEmail'];

		header("location: colaborar.php"); // Cria a sessão e redireciona a esta pagina
	}
	else
	{
		// Incorretos
		header("location: registro.php?erro=1");
	};