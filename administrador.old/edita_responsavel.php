<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$id = '';
	$novoNome = '';
	$novoEmail = '';
	$novaFaixaEtaria = '';
	$novoTipo = '';
	$novaPontuaηγo = '';
	$novaSenha = '';
	$repNovaSenha = '';
	$tpa = '';
	
	
	if(isset($_GET['id'])) $id = $_GET['id'];
	if(isset($_GET['novoNome'])) $novoNome = $_GET['novoNome'];
	if(isset($_GET['novoEmail'])) $novoEmail = $_GET['novoEmail'];
	if(isset($_GET['novaCoordenada'])) {
		$novaCoordenada = $_GET['novaCoordenada'];
		$obj = json_decode(file_get_contents("https://maps.googleapis.com/maps/api/geocode/json?latlng=".$novaCoordenada."&key=AIzaSyAHSnQ6TnIM1jXJCfc79MJw2jB5Qj5KwuM"), true); 
		foreach($obj['results'][0]['address_components'] as $retorno) {
			if($retorno['types'][0] == 'administrative_area_level_2')
				$cidade = $retorno['long_name'];
		}
		$novaCidade = $cidade;
	}
	if(isset($_GET['novaCategoria'])) $novaCategoria = $_GET['novaCategoria'];
	if(isset($_GET['tpa'])) $tpa = $_GET['tpa'];
	
		$query = "UPDATE responsavel SET nome = '$novoNome',
		endEmail = '$novoEmail',
		cidade = '$novaCidade',
		categoria_id = '$novaCategoria',
		lat_long = '$novaCoordenada'
		WHERE id = '$id'
		";
		
	// Executa a query
	$atualiza = mysql_query($query);
	
	
	header('Location: listar_responsaveis.php?tpa='.$tpa);
?>