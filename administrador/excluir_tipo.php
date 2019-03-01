<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$count = 0;
	$cga = '';
	
	if(isset($_GET['count'])) $count = $_GET['count'];
	if(isset($_GET['cga'])) $cga = $_GET['cga'];
	
	for($i = 0; $i < $count; $i++){
		$id[$i] = '';
		if(isset($_GET['id'.$i])) $id[$i] = $_GET['id'.$i];
		
		$query = "DELETE FROM tipoevento WHERE codTipoEvento = '$id[$i]'";
		// Executa a query
		$remove = $connection->query($query);
	}
	
	
	
	header('Location: listar_tipos.php?cga='.$cga);
?>