<html>
<body>

<?php  
require("../phpsqlinfo_dbinfo.php"); 

$codUsuario_post = '';
$codColaboracao_post = '';
$tipoStatus_post = '';
$desJustificativa_post = '';

if(isset($_POST['codUsuario'])) $codUsuario_post = $_POST['codUsuario'];
if(isset($_POST["codColaboracao"])) $codColaboracao_post = $_POST["codColaboracao"]; 	
if(isset($_POST["tipoStatus"])) $tipoStatus_post = $_POST["tipoStatus"];
if(isset($_POST["desJustificativa"])) $desJustificativa_post = $_POST["desJustificativa"];
    
$sql = "UPDATE colaboracao SET desJustificativa = '$desJustificativa_post', tipoStatus = '$tipoStatus_post'  WHERE codColaboracao = '$codColaboracao_post'";

// Executa o comando SQL
  $result2 = $connection->query($sql, $connection);
  
  // Verifica se o comando foi executado com sucesso
  if(!$result2)
    die("Falha ao executar o comando: " . $connection->error);
  else
	
	echo 
		<<<HTML
		<html>
		<body>
			<br />
			<br />
			<p align = center><font size = 16>DADOS ATUALIZADOS COM SUCESSO !!!</p>
			<br />
		</body>
		</html>
HTML;

// Select all the rows in the colaboracao table 
$query = "SELECT * FROM colaboracao WHERE codColaboracao = '$codColaboracao_post'"; 
$result = $connection->query($query);
if (!$result) { 
  die('Invalid query: ' . $connection->error);
} 


echo "<table border = '3' cellpadding = '3' cellspacing = '3' align = center>
		<tr>
			<th align='center'>id</th>
			<th align='center'>Título</th>
			<th align='center'>Descrição</th>
			<th align='center'>Data da Criação</th>
			<th align='center'>Categoria</th>
			<th align='center'>Tipo</th>
			<th align='center'>Id Usuario</th>
			<th align='center'>Data Ocorrência</th>
			<th align='center'>Hora Ocorrência</th>
			<th align='center'>Latitude</th>
			<th align='center'>Longitude</th>
			<th align='center'>Status</th>
			<th align='center'>Justificativa</th>		
		</tr>";

/*Enquanto houver dados na tabela para serem mostrados será executado tudo que esta dentro do while */
while($escrever=$result->fetch_array()){

/*Escreve cada linha da tabela*/
echo "<tr><td align='center'>" . $escrever['codColaboracao'] . 
	 "</td><td align='center'>" . $escrever['desTituloAssunto'] . 
	 "</td><td align='center'>" . $escrever['desColaboracao'] . 
	 "</td><td align='center'>" . $escrever['datahoraCriacao'] . 
	 "</td><td align='center'>" . $escrever['codCategoriaEvento'] . 
	 "</td><td align='center'>" . $escrever['codTipoEvento'] . 
	 "</td><td align='center'>" . $escrever['codUsuario'] . 
	 "</td><td align='center'>" . $escrever['dataOcorrencia'] . 
	 "</td><td align='center'>" . $escrever['horaOcorrencia'] . 
	 "</td><td align='center'>" . $escrever['numLatitude'] . 
	 "</td><td align='center'>" . $escrever['numLongitude'] . 
	 "</td><td align='center'>" . $escrever['tipoStatus'] . 
	 "</td><td align='center'>" . $escrever['desJustificativa'] . 
	 
	"</td></tr>";

}/*Fim do while*/

echo "</table>"; /*fecha a tabela apos termino de impressão das linhas*/
//<input type="button" value="Avaliar" onClick="admin_tool.html"/>
?>



<br />
<form name="form" action="avaliar_colaboracao.php" method="post">
    <p align = center >
		
		<input class="button" type="submit" value="V o l t a r" style="width: 150px; height: 100px;  font-size: 22pt">
	</p>
</form>

<br />	


<form  name="form2" action="../PHPMailer_v5.1/examples/test_smtp_gmail_basic.php" method="post">
	<p align = center>
		
		<input name='codUsuario' id = 'codUsuario'  type='hidden'  value = '' />
		
		<input name='codColaboracao' id = 'codColaboracao'  type='hidden'  value = '' />
		
		<input name='desJustificativa'  id = 'desJustificativa' type='hidden' value = '' />	
				
		<input class='button' type='submit' value='Enviar Email' onClick= 'copia()' style="width: 180px; height: 100px;  font-size: 22pt"/>
	</p>
</form>

<script>
	function copia(){
		document.form2.desJustificativa.value = "<?php  echo $desJustificativa_post; ?>" ;
		document.form2.codColaboracao.value = "<?php  echo $codColaboracao_post; ?>" ;
		document.form2.codUsuario.value = "<?php  echo $codUsuario_post; ?>" ;
	}
</script>

</body>
</html>


