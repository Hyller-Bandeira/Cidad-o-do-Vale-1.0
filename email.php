<?php
require 'phpsqlinfo_dbinfo.php';
header('content-type: text/html; charset=utf-8');

error_reporting(E_STRICT);
date_default_timezone_set('America/Sao_Paulo');

require_once 'PHPMailer_v5.1/class.phpmailer.php';

$titulo = '';
$email = '';
$descricao = '';

if(isset($_POST["titulo"])) $titulo = $_POST["titulo"];
if(isset($_POST["email"])) $email = $_POST["email"];
if(isset($_POST["descricao"])) $descricao = $_POST["descricao"];

$mail = new PHPMailer();

$body = "<html><body><div align = 'center'><b>Contato do Usuário via ". $nome_site ."</b><br /><br />";
$body .= "<table border = '1' cellpadding = '5' cellspacing = '5' align = center>
		<tr>
			<th align='center'>Título: </th> <td align='center'>". $titulo .
    "</td></tr><tr><th align='center'>Email: </th> <td align='center'>" . $email .
    "</td></tr><tr><th align='center'>Descrição: </th>	<td align='center'>" . $descricao .
    "</td></tr>";
$body .= "</table>";
$body .= "</body></html>";

$mail->IsSMTP(); // telling the class to use SMTP
//$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
$mail->SMTPAuth   = true;                  // enable SMTP authentication
$mail->SMTPSecure = "tls";                 // sets the prefix to the servier
$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
$mail->Port       = 587;                   // set the SMTP port for the GMAIL server
$mail->Username   = $email_site;  		   // GMAIL username
$mail->Password   = $senha_email_site;     // GMAIL password

$mail->SetFrom( $email_site , utf8_decode("Mensagem do ".$nome_site) );

$mail->AddReplyTo( $email_site , utf8_decode("Mensagem do ".$nome_site) );

$mail->Subject    = utf8_decode("Retorno da Colaboração");

$mail->MsgHTML($body);

$mail->AddAddress( $email_site , $email );

if($mail->Send()) {
    echo 1;
}
else {
    echo 0;
}