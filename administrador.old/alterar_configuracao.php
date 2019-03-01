<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$novoNomeSite = '';
	$novaLatitude = '';
	$novaLongitude = '';
	$novoZoom = '';
	$novoTipoMapa = '';
	$novoLoginFacebook = '';
	$novoLoginGoogle = '';
	$novoLoginAnonimo = '';
	$novoEmailContato = '';
	$senhaEmailContato = '';
	$novoLink = '';
	$appIDFacebook = '';
	$appSecretFacebook = '';
	
	if(isset($_GET['novoNomeSite'])) $novoNomeSite = $_GET['novoNomeSite'];
	if(isset($_GET['novaLatitude'])) $novaLatitude = $_GET['novaLatitude'];
	if(isset($_GET['novaLongitude'])) $novaLongitude = $_GET['novaLongitude'];
	if(isset($_GET['novoZoom'])) $novoZoom = $_GET['novoZoom'];
	if(isset($_GET['novoTipoMapa'])) $novoTipoMapa = $_GET['novoTipoMapa'];
	if(isset($_GET['novoLoginF'])) $novoLoginFacebook = $_GET['novoLoginF'];
	if(isset($_GET['novoLoginG'])) $novoLoginGoogle = $_GET['novoLoginG'];
	if(isset($_GET['novoLoginA'])) $novoLoginAnonimo = $_GET['novoLoginA'];
	if(isset($_GET['novoEmailContato'])) $novoEmailContato = $_GET['novoEmailContato'];
	if(isset($_GET['senhaEmailContato'])) $senhaEmailContato = $_GET['senhaEmailContato'];
	if(isset($_GET['novoLink'])) $novoLink = $_GET['novoLink'];
	if(isset($_GET['appIDFacebook'])) $appIDFacebook = $_GET['appIDFacebook'];
	if(isset($_GET['appSecretFacebook'])) $appSecretFacebook = $_GET['appSecretFacebook'];
	
	$query = "UPDATE configuracoes SET nomeSite = '$novoNomeSite',
	latitude = '$novaLatitude',
	longitude = '$novaLongitude',
	zoom = '$novoZoom',
	tipoMapa = '$novoTipoMapa',
	loginFacebook = '$novoLoginFacebook',
	loginGoogle = '$novoLoginGoogle',
	loginAnonimo = '$novoLoginAnonimo',
	emailContato = '$novoEmailContato',
	senhaContato = '$senhaEmailContato',
	linkBase = '$novoLink',
	appIDFacebook = '$appIDFacebook',
	appSecretFacebook = '$appSecretFacebook'
	";
	// Executa a query
	$atualiza = mysql_query($query);
	
	
	header('Location: configuracoes.php');
?>