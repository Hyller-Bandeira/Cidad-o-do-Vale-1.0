<?php 
require 'phpsqlinfo_dbinfo.php';
function calc_idade( $data_nasc ){
	$data_nasc = explode("/", $data_nasc);

	$data = date("m-d-Y");
	$data = explode("-", $data);
	$anos = $data[2] - $data_nasc[2];

	if ( $data_nasc[1] >= $data[1] ){

		if ( $data_nasc[0] <= $data[0] ){
			return $anos; 
			break;
		}else{
			return $anos-1;
			break;
		} 
		}else{
			return $anos;
		}
}

require 'src/facebook.php';

$facebook = new Facebook(array(
  'appId'  => $appIDFacebook,
  'secret' => $appSecretFacebook,
  'cookie' => true
));

$session = $facebook->getUser();
$user = null;

if($session){
	try{
		$user = $facebook->api('/me');
		
		//print_r($user);
	}
	catch(FacebookApiException $e){
		echo $e->getMessage();
	}
}

if ($user) {
  //$logoutUrl = $facebook->getLogoutUrl();
  //echo "<a href='".$logoutUrl."'>Sair</a>";
  echo '<br>Nome: ' . $user['name'].'<br>';
  echo 'Email: ' . $user['email'].'<br>';
  echo 'Senha: ' . $user['id'].'<br>';
  if($user['birthday']){
	echo 'Aniversario: ' . $user['birthday'].'<br>';
	echo 'Idade: ' . calc_idade($user['birthday']);
	
	$faixaEtaria = 'Nao informado';
	
	if(calc_idade($user['birthday'] < 17))
		$faixaEtaria = 'até 17 anos';
	else if(calc_idade($user['birthday']) >= 17 && calc_idade($user['birthday']) < 26)
		$faixaEtaria = '18 - 25 anos';
	else if(calc_idade($user['birthday']) >= 26 && calc_idade($user['birthday']) <= 65)
		$faixaEtaria = '26 - 65 anos';
	else if(calc_idade($user['birthday'] > 65))
		$faixaEtaria = 'mais de 65 anos';
		
  }
   
  header("location: autentica_outros.php?login=". $user['email']."&senha=" . $user['id']."&apelidoUsuario=" . $user['name']."&faixaEtaria=" . $faixaEtaria);
  
}
else{
  $loginUrl = $facebook->getLoginUrl(array('scope' => 'email,user_birthday'));
  header("location:".$loginUrl);
  //echo "<a href='".$loginUrl."'>Entrar</a>";
}

?>
<!doctype html>
<html>
  <head>
    <title>Valida Facebook</title>
  
  </head>
  <body>
    
  </body>
</html>
