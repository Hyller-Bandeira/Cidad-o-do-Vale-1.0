<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$id = '';
	$sta = '';
	$origem = '';
	
	if(isset($_GET['id'])) $id = $_GET['id'];
	if(isset($_GET['sta'])) $sta = $_GET['sta'];
	if(isset($_GET['origem'])) $origem = $_GET['origem'];
	$ordemAnterior = 0;
	$atual = 0;
	$ordemPosterior = 0;
	$idAnterior = '';
	$idPosterior = '';
	
	echo $id;
	
	
	//Consultas SQL
	$consulta = mysql_query("SELECT * FROM menu ORDER BY ordemItem ASC");
	
	while($itemMenu = mysql_fetch_array($consulta)){
	
		if($itemMenu['codMenu'] == $id){
			$atual = $itemMenu['ordemItem'];
			$itemMenu=mysql_fetch_array($consulta);
			$ordemPosterior = $itemMenu['ordemItem'];
			$idPosterior = $itemMenu['codMenu'];
			
			break;
		}
		$idAnterior = $itemMenu['codMenu'];
		$ordemAnterior = $itemMenu['ordemItem'];
	}
	
	if($origem == "Subir"){
		$query2 = "UPDATE menu SET ordemItem = '$atual' WHERE codMenu = '$idAnterior'";
		$query = "UPDATE menu SET ordemItem = '$ordemAnterior' WHERE codMenu = '$id'";
	}else{
		$query = "UPDATE menu SET ordemItem = '$atual' WHERE codMenu = '$idPosterior'";
		$query2 = "UPDATE menu SET ordemItem = '$ordemPosterior' WHERE codMenu = '$id'";
	}
	
	// Executa a query
	$atualiza = mysql_query($query)or die(mysql_error());
	$atualiza2 = mysql_query($query2)or die(mysql_error());
	
	header('Location: listar_menu.php?sta='.$sta);

?>