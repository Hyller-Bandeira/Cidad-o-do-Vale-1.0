<?php 

//error_reporting(E_ALL);
error_reporting(E_STRICT);

date_default_timezone_set('America/Sao_Paulo');

require_once('../class.phpmailer.php');
//include("class.smtp.php"); // optional, gets called from within class.phpmailer.php if not already loaded

//codigo do usuario passado por formulario
$codUsuario_post = '';
$desJustificativa_post = ''; 
$codColaboracao_post = '';

if(isset($_POST["codUsuario"])) $codUsuario_post = $_POST["codUsuario"];
if(isset($_POST["desJustificativa"])) $desJustificativa_post = $_POST["desJustificativa"];
if(isset($_POST["codColaboracao"])) $codColaboracao_post = $_POST["codColaboracao"];

$flagger = 0;

if ($codUsuario_post == ''){
	echo "Selecione um Usuario ..." ;
	$flagger = 1;
	}

$nome_usuario;
$email_usuario;

require("../../phpsqlinfo_dbinfo.php");

$query = "SELECT * FROM usuario WHERE codUsuario = '$codUsuario_post' "; 
$result = mysql_query($query); 
if (!$result) { 
  die('Invalid query: ' . mysql_error()); 
}

while ($row = @mysql_fetch_assoc($result)){ 
	$nome_usuario =  $row['nomPessoa'];
	$email_usuario = $row['endEmail'];
}

if($flagger == 0){
	if ( (!$nome_usuario || !$email_usuario) ){
		echo "Usuario Não Existe Mais ...";
	}
}


$mail             = new PHPMailer();

//$body             = file_get_contents('contents.html');

//$body             = eregi_replace("[\]",'',$body);


$query = "SELECT * FROM colaboracao WHERE codColaboracao = '$codColaboracao_post'"; 
$result = mysql_query($query); 
if (!$result) { 
  die('Invalid query: ' . mysql_error()); 
} 


$body = "<html><body><div align = 'center'><b>Retorno de sua colaboração no Geobrowser</b><br><br>";
$body .= "<table border = '3' cellpadding = '3' cellspacing = '3' align = center>
			<tr>
				<th align='center'>Título</th>
				<th align='center'>Descrição</th>
				<th align='center'>Data da Criação</th>
				<th align='center'>Categoria</th>
				<th align='center'>Tipo</th>
				<th align='center'>Id Usuario</th>
				<th align='center'>Data Ocorrência</th>
				<th align='center'>Hora Ocorrência</th>
				<th align='center'>Latitude</th>
				<th align='center'>Longitude</th>	
			</tr>";


while($escrever=mysql_fetch_array($result)){
	$tipostatus_1 ;
	if ($escrever['tipoStatus'] == 'a' || $escrever['tipoStatus'] == 'A')
		$tipostatus_1 = 'Aprovada';
	else
		$tipostatus_1 = 'Reprovada';

	$temp1 = $escrever['codCategoriaEvento'];
	$temp2 = $escrever['codTipoEvento'];
	$temp3 = $escrever['codUsuario'];
		
	$consultaCategoria = mysql_query("SELECT * FROM categoriaevento WHERE codCategoriaEvento = '$temp1'" );
	$rowCategoria = mysql_fetch_assoc($consultaCategoria);
	$desCategoriaEvento_1 = $rowCategoria['desCategoriaEvento'] ;

	$consultaTipo = mysql_query("SELECT * FROM tipoevento WHERE codTipoEvento = '$temp2'" );
	$rowTipo = mysql_fetch_assoc($consultaTipo);
	$desTipoEvento_1 = $rowTipo['desTipoEvento'] ;

	$consultaUsuario = mysql_query("SELECT * FROM usuario WHERE codUsuario = '$temp3'" );
	$rowUsuario = mysql_fetch_assoc($consultaUsuario);
	$nomPessoa_1 = $rowUsuario['nomPessoa'] ;

	$body .= "<tr><td align='center'>" . $escrever['desTituloAssunto'] . 
			 "</td><td align='center'>" . $escrever['desColaboracao'] . 
			 "</td><td align='center'>" . $escrever['datahoraCriacao'] . 
			 "</td><td align='center'>" . $desCategoriaEvento_1 . 
			 "</td><td align='center'>" . $desTipoEvento_1 . 
			 "</td><td align='center'>" . $nomPessoa_1 . 
			 "</td><td align='center'>" . $escrever['dataOcorrencia'] . 
			 "</td><td align='center'>" . $escrever['horaOcorrencia'] . 
			 "</td><td align='center'>" . $escrever['numLatitude'] . 
			 "</td><td align='center'>" . $escrever['numLongitude'] . 
			 
			 "</td></tr></table>";
}
$body .= "<br><br><b>Sua colaboração foi: " . $tipostatus_1 . ".</b>";
$body .= "<br><br><b>Justificativa</b><br><br>" . $desJustificativa_post . "</div>";
$body .= "</body></html>";

$mail->IsSMTP(); // telling the class to use SMTP
$mail->Host       = $email_site; // SMTP server
$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
                                           // 1 = errors and messages
                                           // 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
$mail->Username   = $email_site;  // GMAIL username
$mail->Password   = $senha_email_site;            // GMAIL password

$mail->SetFrom($email_site, $nome_site);

$mail->AddReplyTo($email_site, $nome_site);

$mail->Subject    = "Retorno da Colaboração";

$mail->AltBody    = "Retorno da Colaboração"; // optional, comment out and test

$mail->MsgHTML($body);

$address = $email_usuario;
$mail->AddAddress($address, $nome_usuario);

//$mail->AddAttachment("images/phpmailer.gif");      // attachment
//$mail->AddAttachment("images/phpmailer_mini.gif"); // attachment
$teste=0;

if($mail->Send()){
	echo "Email Enviado";
	$teste = 1 ;
	header("location: email_sucesso.html");
	}
else 
	echo "Mailer Error: " . $mail->ErrorInfo;

?>


<?php if ($teste == 1){?>
<script type="text/javascript" src="links.js"></script>
<html>
<meta http-equiv="refresh" content="0;url=http://www.ide.ufv.br:8008/geobrowser/PHPMailer_v5.1/examples/email_sucesso.html">
</html>
<?php }?>
