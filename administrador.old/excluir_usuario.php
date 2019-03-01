<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$count = 0;
	$tpa = '';
	
	if(isset($_GET['count'])) $count = $_GET['count'];
	if(isset($_GET['tpa'])) $tpa = $_GET['tpa'];
	
	for($i = 0; $i < $count; $i++){
	    $id[$i] = '';
		if(isset($_GET['id'.$i])) $id[$i] = $_GET['id'.$i];
		
		$query = "DELETE FROM usuario WHERE codUsuario = '$id[$i]'";
		// Executa a query
		$remove = mysql_query($query);
	}
	
	
	
	header('Location: listar_usuarios.php?tpa='.$tpa);
?>