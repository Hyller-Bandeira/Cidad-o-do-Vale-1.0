<?php
error_reporting(E_ERROR | E_PARSE);

// Para fazer uma customização do site esses dados precisam ser alterados

$username = 'u207457402_cdv';												// Usuario do BD
$password = 'administrador'; 												// Senha do BD
$database = "u207457402_cdv"; 									// Nome do banco de dados
$destination_path = dirname(__FILE__) . "/arquivos/"; 			// Caminho do repositorio de arquivos
$destination_image = dirname(__FILE__) . "/imagensenviadas/";	// Caminho do repositorio de imagens

//variavel de controle de navegação
$voltar_pagina = "<a href=\"javascript:history.back(-1)\">voltar e tentar novamente</a>";

// Opens a connection to a MySQL server
$connection = new mysqli('localhost', $username, $password, $database);
if ($connection->connect_error)
    die('Não conectou com o servidor de dados: ' . $connection->connect_error);

if (!$connection->set_charset('utf8'))
    die('Error ao configurar a codificação utf8: ' . $connection->error);

if ($resultado = $connection->query("SELECT * FROM configuracoes"))
{
    $linha = $resultado->fetch_array(MYSQLI_ASSOC);

    $nome_site 			= $linha['nomeSite'];				// Nome do site
    $email_site 		= $linha['emailContato']; 			// Gmail para receber contatos do site
    $senha_email_site 	= $linha['senhaContato'];			// Senha do Gmail
    $longitude_inicial 	= $linha['longitude'];
    $latitude_inicial 	= $linha['latitude'];
    $zoom_inicial 		= $linha['zoom'];
    $tipoMapa_inicial 	= $linha['tipoMapa'];
    $login_facebook 	= $linha['loginFacebook'];
    $appIDFacebook 		= $linha['appIDFacebook'];
    $appSecretFacebook 	= $linha['appSecretFacebook'];
    $login_google 		= $linha['loginGoogle'];
    $login_anonimo 		= $linha['loginAnonimo'];
    $link_inicial 		= $linha['linkBase'];

    $resultado->close();
}
else
    die('Consulta inválida: ' . $connection->error);

$resultado = $connection->query("SELECT * FROM menu ORDER BY ordemItem ASC");
$expaux = explode("/", $_SERVER['PHP_SELF']);
$paginaAtual = end($expaux);

$nomePagina = '';

while($itemMenu = $resultado->fetch_array(MYSQLI_ASSOC))
    if($itemMenu['enderecoItem'] == $paginaAtual)
        $nomePagina = $itemMenu['nomeItem'] . ' - ';


//Configuracoes para passar para o banco depois

$tempo_minimo_usuario_veterano = 2*30;//Tempo minimo (em dias) para usuario ganhar o selo veterano, neste caso foi escolhido 4 meses
$numero_colaboracoes_consecutivas = 4;//Numero de colaboracoes que o usuario pode fazer consecutivamente sem ser bloqueado
$tempo_de_bloqueio = 60*24;//Tempo (em minutos) que o usuario ficara bloqueado caso faca muitas colaboacoes em um curto intervalo de tempo
$intervalo_entre_numero_colaboracoes_consecutivas = 2;//Tempo minimo (em minutos) para realizar colaboracoes consecutivas. Se usuario realizar mais colaboracoes consecutivas do que eh permitido em menos tempo do que esta variavel ele sera bloqueado. Ou seja, se o usuario fizer mais de $numero_colaboracoes_consecutivas colaboracoes em menos de $intervalo_entre_numero_colaboracoes_consecutivas minutos ele sera bloqueado por $tempo_de_bloqueio minutos
$tempo_minimo_leitura_tutorial = 5;//Tempo (em minutos) minimo que o usuario tera que ficar lendo o tutorial para ganhar o selo
$num_minimo_pagina_tutorial = 18; //Numero minimo de paginas distintas do tutorial que o usuario tera que acessar para ganhar o selo
$num_minimo_colaboracoes1 = 1;//Numero minimo de colaboracoes que o usuario tera de fazer para ganhar o selo numero colaboracoes 1
$num_minimo_colaboracoes2 = 10;//Numero minimo de colaboracoes que o usuario tera de fazer para ganhar o selo numero colaboracoes 1
$num_minimo_colaboracoes3 = 20;//Numero minimo de colaboracoes que o usuario tera de fazer para ganhar o selo numero colaboracoes 1
$num_minimo_colaboracoes4 = 31;//Numero minimo de colaboracoes que o usuario tera de fazer para ganhar o selo numero colaboracoes 1
$num_minimo_avaliacoes = 10;//Numero minimo de avaliacoes que o usuario deve realizar para ganhar o selo usuario avaliador
$num_minimo_edicoes = 10;//Numero minimo de edicoes que o usuario deve realizar para ganhar o selo usuario editor
$num_minimo_comentarios = 10;//Numero minimo de comentarios que o usuario deve realizar para ganhar o selo usuario comunicativo
$num_minimo_multimidias = 10;//Numero minimo de envio de imagens, videos ou arquivos que o usuario deve realizar para ganhar o selo usuario multimidia

