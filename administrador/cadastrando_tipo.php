<?php  
require("../phpsqlinfo_dbinfo.php"); 

$codCategoriaEvento_post = '';
$desTipoEvento_post = '';

if(isset($_POST["codCategoriaEvento"])) $codCategoriaEvento_post = $_POST["codCategoriaEvento"];
if(isset($_POST["desTipoEvento"])) $desTipoEvento_post = $_POST["desTipoEvento"];
    
$sql = "INSERT INTO tipoevento ( desTipoEvento, codCategoriaEvento )
			VALUES('$desTipoEvento_post', '$codCategoriaEvento_post'   )";
// Executa o comando SQL
  $result2 = $connection->query($sql, $connection);
  
  // Verifica se o comando foi executado com sucesso
  if(!$result2)
    die("Falha ao executar o comando: " . $connection->error);
  else
    echo 
	header("location: registro_sucesso_tipo.html");

	
?>

<form name="form" action="cadastrar_categ.php" method="post">
    <p style="margin-left: 300">
		
		<input class="button" type="submit" value="Voltar"/>
	</p>
</form>