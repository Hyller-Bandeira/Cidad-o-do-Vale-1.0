<?php 
	require("../phpsqlinfo_dbinfo.php");
	//checa os dados fornecidos pelo formulario e os trata adequadamente
	
	$login = '';
	$senha = '';
	
	if(isset($_POST["login"])) $login = $_POST["login"];
	if(isset($_POST["senha"])) $senha = md5($_POST["senha"]);
	
	$autentic = mysql_query("SELECT * FROM usuario WHERE endEmail='$login' and senha='$senha' and TipoUsuario = 'A'") or die ("Erro query:SELECT*FORM<br>");
	
	
	
	$resultado = mysql_num_rows($autentic);
			
	if($resultado == 1){
		//os dados estão corretos a sessão é criada
		session_start();
		$_SESSION["user"] = $login;
		$_SESSION["pass"] = $senha;
		$_SESSION["nivel_acesso"] = 'A';

		$codigo2 = mysql_query("SELECT * FROM usuario WHERE endEmail='$login' and senha='$senha'") or die ("Erro query:SELECT*FORM<br>");
		//$codigo = @mysql_fetch_assoc($codigo2);
		
		$codigo3 = @mysql_fetch_assoc($codigo2) ;
		$_SESSION['code_user'] = $codigo3['codUsuario'];
		$_SESSION['name_user'] = $codigo3['nomPessoa'];
		
		
		header("location: admin_tool.php");//cria a sessão e redireciona a esta pagina
	}
	else{
		//incorretos
		header("location: login_admin_falha.php");
	};
?>