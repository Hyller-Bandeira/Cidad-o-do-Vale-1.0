<?php 

	require("../phpsqlinfo_dbinfo.php");
	
	$novoStatus = '';
	$justificativa = '';
	$enviaEmail = '';
	$id = '';
	$cga = '';
	$tpa = '';
	$sta = '';
	$email = '';
	$nome = '';
	
	if(isset($_GET['novoStatus'])) $novoStatus = $_GET['novoStatus'];
	if(isset($_GET['justificativa'])) $justificativa = $_GET['justificativa'];
	if(isset($_GET['enviaEmail'])) $enviaEmail = $_GET['enviaEmail'];
	if(isset($_GET['id'])) $id = $_GET['id'];
	if(isset($_GET['cga'])) $cga = $_GET['cga'];
	if(isset($_GET['tpa'])) $tpa = $_GET['tpa'];
	if(isset($_GET['sta'])) $sta = $_GET['sta'];
	if(isset($_GET['email'])) $email = $_GET['email'];
	if(isset($_GET['nome'])) $nome = $_GET['nome'];
	
	$query1 = "UPDATE colaboracao SET tipoStatus = '$novoStatus',
	desJustificativa = '$justificativa'
	WHERE codColaboracao = '$id'
	";
	// Executa a query
	$atualiza = mysql_query($query1);
	
	$query2 = "SELECT * FROM configuracoes"; 
	$result2 = mysql_query($query2); 
	if (!$result2) 
		 die('Invalid query: ' . mysql_error());
	$escrever2 = mysql_fetch_array($result2);
	
	if($enviaEmail == 'true'){
		//error_reporting(E_ALL);
		error_reporting(E_STRICT);

		date_default_timezone_set('America/Sao_Paulo');
		require_once('../PHPMailer_v5.1/class.phpmailer.php');
		
		$mail = new PHPMailer();
		
		$query = "SELECT * FROM colaboracao WHERE codColaboracao = '$id'"; 
		$result = mysql_query($query); 
		if (!$result) { 
		  die('Invalid query: ' . mysql_error()); 
		}

		$body = "<html><body><div align = 'center'><b>Retorno de sua colaboração no ".$escrever2['nomeSite']."</b><br><br>";
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
		$body .= "<br><br><b>Justificativa</b><br><br>" . $justificativa . "</div>";
		$body .= "</body></html>";

		$mail->IsSMTP(); // telling the class to use SMTP
		$mail->Host       = $escrever2['emailContato']; // SMTP server
		$mail->SMTPDebug  = 2;                     // enables SMTP debug information (for testing)
												   // 1 = errors and messages
												   // 2 = messages only
		$mail->SMTPAuth   = true;                  // enable SMTP authentication
		$mail->SMTPSecure = "ssl";                 // sets the prefix to the servier
		$mail->Host       = "smtp.gmail.com";      // sets GMAIL as the SMTP server
		$mail->Port       = 465;                   // set the SMTP port for the GMAIL server
		$mail->Username   = $escrever2['emailContato'];  // GMAIL username
		$mail->Password   = $escrever2['senhaContato'];            // GMAIL password

		$mail->SetFrom($escrever2['emailContato'], $escrever2['nomeSite']);

		$mail->AddReplyTo($escrever2['emailContato'],$escrever2['nomeSite']);

		$mail->Subject    = "Retorno da Colaboração";

		$mail->AltBody    = "Retorno da Colaboração"; // optional, comment out and test

		$mail->MsgHTML($body);

		$address = $email;
		$mail->AddAddress($address, $nome);
		$mail->Send();
	
	}
	header('Location: listar_colaboracoes.php?cga='.$cga.'&tpa='.$tpa.'&sta='.$sta);
?>