<?php  
require("../phpsqlinfo_dbinfo.php"); 

$nomPessoa_post = ''; 	
$endEmail_post = '';
$senha_post = '';
$tipoUsuario_post = '';
$endEmail_post2 = '';
$senha_post2 = '';

if(isset($_POST["nomPessoa"])) $nomPessoa_post = $_POST["nomPessoa"]; 	
if(isset($_POST["endEmail"])) $endEmail_post = $_POST["endEmail"];
if(isset($_POST["senha"])) $senha_post = md5($_POST["senha"]);
if(isset($_POST["tipoUsuario"])) $tipoUsuario_post = $_POST["tipoUsuario"];
if(isset($_POST["endEmail2"])) $endEmail_post2 = $_POST["endEmail2"];
if(isset($_POST["senha2"])) $senha_post2 = md5($_POST["senha2"]);

$query = "SELECT * FROM usuario WHERE endEmail = '$endEmail_post' ";
$result = mysql_query($query, $connection);
$testaEndEmail = mysql_fetch_array($result);

if (!$testaEndEmail)
	if ($endEmail_post == $endEmail_post2 && $senha_post == $senha_post2 ){
			
		$sql = "INSERT INTO usuario ( nomPessoa,  endEmail,  senha,  tipoUsuario)
				VALUES('$nomPessoa_post', '$endEmail_post', '$senha_post', '$tipoUsuario_post'  )";

		$result2 = mysql_query($sql, $connection);

		if(!$result2)
			die("Falha ao executar o comando: " . mysql_error());
		else
			header("location: registro_sucesso_admin.html");
	}

	else
		header("location: registro_falha_admin.html");
else
	header("location: registro_falha_2_admin.html");
	
?>
