<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$count = '';
	$sta = '';
	$origem = '';
	
	if(isset($_GET['count'])) $count = $_GET['count'];
	if(isset($_GET['sta'])) $sta = $_GET['sta'];
	if(isset($_GET['origem'])) $origem = $_GET['origem'];
	
	for($i = 0; $i < $count; $i++){
		$id[$i] = '';
		if(isset($_GET['id'.$i])) $id[$i] = $_GET['id'.$i];
		
		if($origem == "Publicar")
			$query = "UPDATE menu SET statusItem = '0' WHERE codMenu = '$id[$i]'";
		else
			$query = "UPDATE menu SET statusItem = '1' WHERE codMenu = '$id[$i]'";
	
	// Executa a query
	$atualiza = mysql_query($query)or die(mysql_error());
	}
	
	header('Location: listar_menu.php?sta='.$sta);
?>