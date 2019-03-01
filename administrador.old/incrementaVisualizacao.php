<?php 
	header('Content-Type: text/html; charset=ISO-8859-1');

	require("../phpsqlinfo_dbinfo.php");

	$codColaboracao = '';
	
	if(isset($_GET["codColaboracao"])) $codColaboracao = addslashes(trim($_GET["codColaboracao"]));
	
	$consulta = mysql_query("UPDATE estatistica SET qtdVisualizacao = qtdVisualizacao + 1
									WHERE codColaboracao = '$codColaboracao' " );
	
	if (!$result) {
		  die('Update 1 errado: ' . mysql_error());
		}
?>