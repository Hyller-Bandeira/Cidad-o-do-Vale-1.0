<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$count = 0;
	$cga = '';
	$tpa = '';
	$sta = '';
	
	if(isset($_GET['count'])) $count = $_GET['count'];
	if(isset($_GET['cga'])) $cga = $_GET['cga'];
	if(isset($_GET['tpa'])) $tpa = $_GET['tpa'];
	if(isset($_GET['sta'])) $sta = $_GET['sta'];
	
	for($i = 0; $i < $count; $i++){
		$id[$i] = '';
		if(isset($_GET['id'.$i])) $id[$i] = $_GET['id'.$i];
		
		$query = "DELETE FROM arquivos WHERE codColaboracao = '$id[$i]'";
		// Executa a query
		$remove = mysql_query($query);
		
		$query2 = "DELETE FROM avaliacao WHERE codColaboracao = '$id[$i]'";
		// Executa a query
		$remove2 = mysql_query($query2);
		
		$query3 = "DELETE FROM estatistica WHERE codColaboracao = '$id[$i]'";
		// Executa a query
		$remove3 = mysql_query($query3);
		
		$query4 = "DELETE FROM comentario WHERE codColaboracao = '$id[$i]'";
		// Executa a query
		$remove4 = mysql_query($query4);
		
		$query5 = "DELETE FROM multimidia WHERE codColaboracao = '$id[$i]'";
		// Executa a query
		$remove5 = mysql_query($query5);
		
		$query6 = "DELETE FROM videos WHERE codColaboracao = '$id[$i]'";
		// Executa a query
		$remove6 = mysql_query($query6);
		
		$query7 = "DELETE FROM historicocolaboracoes WHERE codColaboracao = '$id[$i]'";
		// Executa a query
		$remove7 = mysql_query($query7);
		
		$query8 = "DELETE FROM colaboracao WHERE codColaboracao = '$id[$i]'";
		// Executa a query
		$remove8 = mysql_query($query8);
	}
	
	
	
	header('Location: listar_colaboracoes.php?cga='.$cga.'&tpa='.$tpa.'&sta='.$sta);
?>