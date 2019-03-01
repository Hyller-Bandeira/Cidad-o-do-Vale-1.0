<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$count = 0;
	$sta = '';
	
	if(isset($_GET['count'])) $count = $_GET['count'];
	if(isset($_GET['sta'])) $sta = $_GET['sta'];
	
	for($i = 0; $i < $count; $i++){
		$id[$i] = '';
		if(isset($_GET['id'.$i])) $id[$i] = $_GET['id'.$i];
		
		$query = "DELETE FROM menu WHERE codMenu = '$id[$i]'";
		// Executa a query
		$remove = $connection->query($query);
	}
	
	
	
	header('Location: listar_menu.php?sta='.$sta);
?>