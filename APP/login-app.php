<?php
    require 'phpsqlinfo_dbinfo.php';

	$login = (isset($_POST["email"]))?$_POST["email"]: '0';
	$senha = (isset($_POST["senha"]))?$_POST["senha"]: '0';
	$response = array();

	if(isset($_POST["email"])) $Email_post = $_POST["email"];
	if(isset($_POST["senha"])) $Senha_post = $_POST["senha"];

	$teste = 0;
	$query = "SELECT * FROM usuario WHERE (endEmail='$login' or apelidoUsuario='$login' ) and senha='$senha'";
	$result = $connection->query($query);
	$resultado = $result->num_rows;

	if($resultado == 1)
	{
        $response["success"] = true;
        
		$result = $connection->query("SELECT * FROM usuario WHERE (endEmail='$login' or apelidoUsuario='$login' ) and senha='$senha'");

		$result = @$result->fetch_assoc() ;
		$response["usuario_id"] = $result['codUsuario'];
		$response["usuario_nome"]  = $result['apelidoUsuario'];
		$response["usuario_email"] = $result['endEmail'];
		$response["usuario_senha"] = $result['senha'];
	}
	else
    {
        $response["success"] = false;
        $response["error"] =  $connection->error;
    }
    
	echo json_encode($response);
?>