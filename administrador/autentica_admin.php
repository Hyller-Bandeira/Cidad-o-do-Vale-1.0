<?php 
	require("../phpsqlinfo_dbinfo.php");
	//checa os dados fornecidos pelo formulario e os trata adequadamente
	
	$login = '';
	$senha = '';
	if(isset($_POST["login"])) $login = $_POST["login"];
	if(isset($_POST["senha"])) $senha = md5($_POST["senha"]);
	
	$autentic = $connection->query("SELECT * FROM usuario WHERE endEmail='$login' and senha='$senha' and TipoUsuario = 'A'") or die ("Erro query:SELECT*FORM<br>");

	$resultado = $autentic->num_rows;
			
	if($resultado == 1){
		//os dados estão corretos a sessão é criada
		session_start();
		$_SESSION["user_admin_".$link_inicial] = $login;
		$_SESSION["pass_admin_".$link_inicial] = $senha;

		$codigo2 = $connection->query("SELECT * FROM usuario WHERE endEmail='$login' and senha='$senha'") or die ("Erro query:SELECT*FORM<br>");
		
		$codigo3 = $codigo2->fetch_assoc() ;
		$_SESSION['code_user_admin_'.$link_inicial] = $codigo3['codUsuario'];
		$_SESSION['name_user_admin_'.$link_inicial] = $codigo3['nomPessoa'];
		
		
		header("location: admin_tool.php");//cria a sessão e redireciona a esta pagina
	}
	else{
		//incorretos
		header("location: login_admin_falha.php");
	};
?>