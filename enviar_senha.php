<?php
// Inclui o arquivo class.phpmailer.php localizado na pasta phpmailer
require 'PHPMailer_v5.1/class.phpmailer.php';
require 'phpsqlinfo_dbinfo.php';

$email = '';

if(isset($_POST["endEmail"])) $email = $_POST["endEmail"];


$query = "SELECT * FROM usuario WHERE endEmail = '$email' ";
$result = $connection->query($query);
$linhas = $result->num_rows;

if($linhas > 0)
{
	// Inicia a classe PHPMailer
	$mail = new PHPMailer();

	// Define os dados do servidor e tipo de conexão
	$mail->IsSMTP(); // Define que a mensagem será SMTP
	$mail->Host = "smtp.gmail.com"; // Endereço do servidor SMTP
	$mail->Port = 465;
	$mail->SMTPAuth = true; // Usa autenticação SMTP? (opcional)
	$mail->SMTPSecure = "ssl";
	$mail->Username = $email_site; // Usuário do servidor SMTP
	$mail->Password = $senha_email_site; // Senha do servidor SMTP

	// Define o remetente
	$mail->From = $email_site; // Seu e-mail
	$mail->FromName = $nome_site; // Seu nome

	// Define os destinatário(s)
	$mail->AddAddress($email);

	// Define os dados técnicos da Mensagem
	$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
	$codigo_ativacao = gera_codigo();

	// Define a mensagem (Texto e Assunto)
	$mail->Subject  = utf8_decode("Recuperação de Senha"); // Assunto da mensagem
	$mail->Body = "Olá,<br>
	<br>
	Uma senha nova foi requisitada no site <a href='".$link_inicial."' target='_blank'>".$nome_site."</a>.<br>
	<br>
	Clique no link abaixo para fornecer uma nova senha.<br>
	<br>
	<b>Código de Validação</b>: $codigo_ativacao<br>
	<b>Link</b>: <a href='".$link_inicial."/nova_senha.php' target='_blank'>Nova Senha</a><br>";

	// Envia o e-mail
	$enviado = $mail->Send();

	$codigo_ativacao = md5($codigo_ativacao);
	$alt = "UPDATE usuario SET senha = '$codigo_ativacao' WHERE endEmail = '$email'";
	$connection->query($alt);

	// Limpa os destinatários e os anexos
	$mail->ClearAllRecipients();
	$mail->ClearAttachments();

	// Exibe uma mensagem de resultado
	if ($enviado)
		echo "<script>window.location='nova_senha.php';bootbox.alert('Um e-mail foi enviado ao endereço fornecido. Siga as instruções encontradas no e-mail para criar uma nova senha!');</script>";
	else
		echo "<script>window.location='enviar_senha.php';bootbox.alert('Não foi possível enviar o e-mail, tente novamente mais tarde!');</script>";


}
else { echo "<script>window.location='recupera_senha.php';bootbox.alert('Este email não existe');</script>"; }

function gera_codigo($tamanho = 8, $maiusculas = true, $numeros = true)
{
	// Caracteres de cada tipo
	$lmin = 'abcdefghijklmnopqrstuvwxyz';
	$lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$num = '1234567890';

	// Variáveis internas
	$retorno = '';
	$caracteres = '';

	// Agrupamos todos os caracteres que poderão ser utilizados
	$caracteres .= $lmin;
	if ($maiusculas) $caracteres .= $lmai;
	if ($numeros) $caracteres .= $num;

	// Calculamos o total de caracteres possíveis
	$len = strlen($caracteres);

	for ($n = 1; $n <= $tamanho; $n++)
	{
		// Criamos um número aleatório de 1 até $len para pegar um dos caracteres
		$rand = mt_rand(1, $len);
		// Concatenamos um dos caracteres na variável $retorno
		$retorno .= $caracteres[$rand-1];
	}

	return $retorno;
}