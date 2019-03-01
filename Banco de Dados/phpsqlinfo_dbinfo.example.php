<?php 
// Para fazer uma customização do site esses dados precisam ser alterados

$username='DATABASE_USERNAME'; 																//usuario do BD
$password='DATABASE_PASSWORD'; 														// senha do BD
$database="DATABASE_NAME"; 													// nome do banco de dados
$destination_path = "FILE_DIRECTORY_PATH"; 		//caminho do repositorio de arquivos
$destination_image = "IMAGE_DIRECTORY_PATH";	//caminho do repositorio de imagens


//variavel de controle de navegação
$voltar_pagina =" <a href=\"javascript:history.back(-1)\">voltar e tentar novamente</a>";

// Opens a connection to a MySQL server 
$connection=mysql_connect ('localhost', $username, $password); 
if (!$connection) { 
	die('Não conectou com o servidor de dados : ' . mysql_error()); 
} 
 
// Set the active MySQL database 
$db_selected = mysql_select_db($database, $connection); 
if (!$db_selected) { 
	die ('Não pode usar o banco de dados : ' . mysql_error()); 
} 

$consulta = "SELECT * FROM configuracoes";
$resultado = mysql_query($consulta);
if (!$resultado) { 
	die('Invalid consulta: ' . mysql_error()); 
}
$linhaConsulta = mysql_fetch_array($resultado);	
$nome_site = $linhaConsulta['nomeSite'];								//nome do site
$email_site = $linhaConsulta['emailContato']; 							//Gmail para receber contatos do site
$senha_email_site = $linhaConsulta['senhaContato'];						//senha do Gmail
$longitude_inicial = $linhaConsulta['longitude'];
$latitude_inicial = $linhaConsulta['latitude'];
$zoom_inicial = $linhaConsulta['zoom'];
$tipoMapa_inicial = $linhaConsulta['tipoMapa'];	
$login_facebook = $linhaConsulta['loginFacebook'];	
$appIDFacebook = $linhaConsulta['appIDFacebook'];
$appSecretFacebook = $linhaConsulta['appSecretFacebook'];
$login_google = $linhaConsulta['loginGoogle'];	
$login_anonimo = $linhaConsulta['loginAnonimo'];
$link_inicial = $linhaConsulta['linkBase'];

$consulta = mysql_query("SELECT * FROM menu ORDER BY ordemItem ASC");
$paginaAtual = end(explode("/", $_SERVER['PHP_SELF']));

$nomePagina = '';

while($itemMenu = mysql_fetch_array($consulta)){
	if($itemMenu['enderecoItem'] == $paginaAtual)
		$nomePagina = $itemMenu['nomeItem'] . ' - ';
}

?>
