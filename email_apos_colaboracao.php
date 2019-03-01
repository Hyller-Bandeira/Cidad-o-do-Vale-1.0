<?php
header('content-type: text/html; charset=utf-8');
require 'PHPMailer_v5.1/class.phpmailer.php';
require 'phpsqlinfo_dbinfo.php';

// Inicia a classe PHPMailer
$mail = new PHPMailer();

// Define os dados do servidor e tipo de conexão
$mail->IsSMTP();						// Define que a mensagem será SMTP
$mail->Host = "smtp.gmail.com";			// Endereço do servidor SMTP
$mail->Port = 587;
$mail->SMTPAuth = true;					// Usa autenticação SMTP? (opcional)
$mail->SMTPSecure = "tls";
$mail->Username = $email_site;			// Usuário do servidor SMTP
$mail->Password = $senha_email_site;	// Senha do servidor SMTP

// Define o remetente
$mail->From = $email_site;		// Seu e-mail
$mail->FromName = $nome_site;	// Seu nome

// Define os destinatário(s)
$mail->AddAddress($email_site);

// Define os dados técnicos da Mensagem
$mail->IsHTML(true); // Define que o e-mail será enviado como HTML

// Define a mensagem (Texto e Assunto)
$mail->Subject = utf8_decode("Nova Colaboração"); // Assunto da mensagem
$mail->Body = "Foi realizada uma nova colaboração no <a href='".$link_inicial."' target='_blank'>".$nome_site."</a>. <br>";


// Envia o e-mail
$enviado = $mail->Send();

// Limpa os destinatários e os anexos
$mail->ClearAllRecipients();
$mail->ClearAttachments();