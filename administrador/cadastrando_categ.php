<?php  
require("../phpsqlinfo_dbinfo.php"); 

$desCategoriaEvento_post = ''; 	
if(isset($_POST["desCategoriaEvento"])) $desCategoriaEvento_post = $_POST["desCategoriaEvento"]; 
    
$sql = "INSERT INTO categoriaevento ( desCategoriaEvento )
			VALUES('$desCategoriaEvento_post'  )";
// Executa o comando SQL
  $result2 = $connection->query($sql, $connection);
  
  // Verifica se o comando foi executado com sucesso
  if(!$result2)
    die("Falha ao executar o comando: " . $connection->error);
  else
    echo 
	header("location: registro_sucesso_categoria.html");

	
?>

<form name="form" action="cadastrar_categ.php" method="post">
    <p style="margin-left: 300">
		
		<input class="button" type="submit" value="Voltar"/>
	</p>
</form>