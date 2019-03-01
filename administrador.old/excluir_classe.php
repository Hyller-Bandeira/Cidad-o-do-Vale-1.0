<?php 

	require("../phpsqlinfo_dbinfo.php");
	$count = 0;
	if(isset($_GET['count'])) $count = $_GET['count'];
	
	$aux = 0;
	for($i = 0; $i < $count; $i++){
		$id[$i] = '';
		if(isset($_GET['id'.$i])) $id[$i] = $_GET['id'.$i];
		
			$query = "DELETE FROM classesdeusuarios WHERE codClasse = '$id[$i]'";
			// Executa a query
			$remove = mysql_query($query);
		
	}
	
	header('Location: listar_classes.php');
	
	
?>