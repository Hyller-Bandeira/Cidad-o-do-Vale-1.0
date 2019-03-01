<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$count = 0;
	if(isset($_GET['count'])) $count = $_GET['count'];
	
	$aux = 0;
	for($i = 0; $i < $count; $i++){
		$id[$i] = '';
		if(isset($_GET['id'.$i])) $id[$i] = $_GET['id'.$i];
		
		$consulta = $connection->query("SELECT * FROM tipoevento WHERE codCategoriaEvento = '$id[$i]'");
		$numTipos = $consulta->num_rows;
		
		if($numTipos == 0){
			$query = "DELETE FROM categoriaevento WHERE codCategoriaEvento = '$id[$i]'";
			// Executa a query
			$remove = $connection->query($query);
		}
		else
			$aux++;
	}
	
	if($aux == 0)
		header('Location: listar_categorias.php');
	else
		header('Location: listar_categorias.php?msg=nao');
	
?>