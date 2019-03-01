<?php 
header("Content-Type: text/html; charset=ISO-8859-1",true);
require("../phpsqlinfo_dbinfo.php");

$codColaboracao = '';
if(isset($_GET["id"])) $codColaboracao = $_GET["id"];//C�digo da colabora��o recebida pela fun��o

//Tabela: COLABORACAO: Consulta para pegar todos os dados da colabora��o
$consulta = mysql_query("SELECT * FROM  colaboracao WHERE codColaboracao = '$codColaboracao' ");
	if ( !($linhaDaConsulta = mysql_fetch_assoc($consulta)) ){
		echo "Erro na consulta: N�o foi encontrado a colabora��o com c�digo: ".$codColaboracao;
		exit;
	}
	
	$titulo = $linhaDaConsulta['desTituloAssunto'];
	$dataHoraCriacao = $linhaDaConsulta['datahoraCriacao'];
	$dataOcorrencia = $linhaDaConsulta['dataOcorrencia'];
	$horaOcorrencia = $linhaDaConsulta['horaOcorrencia'];
	$latitude = $linhaDaConsulta['numLatitude'];
	$longitude = $linhaDaConsulta['numLongitude'];
	$norte = $latitude;
	$sul = $latitude;
	$leste = $longitude;
	$oeste = $longitude;
	$resumo = $linhaDaConsulta['desColaboracao'];
	
	if($linhaDaConsulta['tipoStatus'] == 'E')
		$status = "Em Avalia��o";
		else if($linhaDaConsulta['tipoStatus'] == 'A')
			$status = "Aprovada";
			else if($linhaDaConsulta['tipoStatus'] == 'R')
				$status = "Reprovada";
				
	$zoomColaboracao = $linhaDaConsulta['zoom'];
	$codigoUsuario = $linhaDaConsulta['codUsuario'];
	
	
	$codigoCategoria = $linhaDaConsulta['codCategoriaEvento'];
		//Tabela: CATEGORIAEVENTO: Consulta para pegar o nome da colabora��o de c�digo $codigoCategoria
		$consulta2 = mysql_query("SELECT desCategoriaEvento FROM categoriaevento WHERE codCategoriaEvento = '$codigoCategoria' ");
			if ( !($linhaDaConsulta2 = mysql_fetch_assoc($consulta2)) ){
				echo "Erro na consulta 2: N�o foi encontrado a categoria com c�digo: ".$codigoCategoria;
				exit;
			}
			$categoria = $linhaDaConsulta2['desCategoriaEvento'];
	
	$codigoTipo = $linhaDaConsulta['codTipoEvento'];
		//Tabela: TIPOEVENTO: Consulta para pegar o nome do tipo de c�digo $codigoTipo
		$consulta3 = mysql_query("SELECT desTipoEvento FROM tipoevento WHERE codTipoEvento = '$codigoTipo' ");
			if ( !($linhaDaConsulta3 = mysql_fetch_assoc($consulta3)) ){
				echo "Erro na consulta 3: N�o foi encontrado o tipo com c�digo: ".$codigoTipo;
				exit;
			}
			$tipo = $linhaDaConsulta3['desTipoEvento'];
	
	//Tabela ESTATISTICA: Consulta para pegar o numero de visualizacoes de determinada colabora��o
	$consulta4 = mysql_query("SELECT * FROM estatistica WHERE codColaboracao = '$codColaboracao' ");
		if ( !($linhaDaConsulta4 = mysql_fetch_assoc($consulta4)) ){
			echo "Erro na consulta 4: N�o foi encontrada a colabora��o com c�digo: ".$codColaboracao;
			exit;
		}
		$numeroVisualizacao = $linhaDaConsulta4['qtdVisualizacao'];
		$numeroAvaliacao = $linhaDaConsulta4['qtdAvaliacao'];
		$notaFinal = $linhaDaConsulta4['notaMedia'];				
	
	//Tabela HISTORICOCOLABORACOES: Consulta para pegar a data e hora das atualiza��es na tabela de hist�rico
	$consulta5 = mysql_query("SELECT * FROM historicocolaboracoes WHERE codColaboracao = '$codColaboracao' ");
	if(!($linhaDaConsulta5 = mysql_fetch_assoc($consulta5))){
		echo "Erro na consulta 5: N�o foi encontrado altera��es na colabora��o com c�digo: ".$codColaboracao;
		exit;
	}
		$numRevisoes = mysql_num_rows($consulta5) - 1;//Subtrai 1 pois quando a colabora��o � criada ela � gravada nessa tabela, ou seja, ela ainda n�o foi editada mas existe uma linha com seus dados
			
	//Tabela COMENTARIO: Consulta para pegar informa��es de hist�rias de usu�rio
	$consulta8 = mysql_query("SELECT * FROM comentario
	INNER JOIN usuario ON (usuario.codUsuario = comentario.codUsuario)
	INNER JOIN classesdeusuarios ON (usuario.classeUsuario = classesdeusuarios.codClasse)
	WHERE codColaboracao = '$codColaboracao' ");
		/*if(!($linhaDaConsulta8 = mysql_fetch_assoc($consulta8))){
			echo "Erro na consulta 8: N�o foi encontrado historias de usuario na colabora��o com c�digo: ".$codColaboracao;
			exit;
		}*/
		
	$consulta9 = mysql_query("SELECT *, count(historicocolaboracoes.codUsuario) FROM historicocolaboracoes
	INNER JOIN usuario ON (usuario.codUsuario = historicocolaboracoes.codUsuario)
	INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
	WHERE codColaboracao = '$codColaboracao' GROUP BY historicocolaboracoes.codUsuario having count(historicocolaboracoes.codUsuario)> 0");
	if(mysql_num_rows($consulta9)<1){
		echo "Erro na consulta 9: N�o foi encontrado altera��es na colabora��o com c�digo: ".$codColaboracao;
		exit;
	}
		$numRevisores = mysql_num_rows($consulta9) - 1;//Subtrai 1 pois o autor n�o conta como revisor
	
	$consultaImagem = mysql_query("SELECT * FROM multimidia 
	INNER JOIN usuario ON (usuario.codUsuario = multimidia.codUsuario)
	INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
	WHERE codColaboracao = '$codColaboracao'
	");
	if ($linhaDaConsultaImagem = mysql_fetch_assoc($consultaImagem)){
		$desTituloImagem = $linhaDaConsultaImagem["desTituloImagem"];
		$comentarioImagem = $linhaDaConsultaImagem["comentarioImagem"];
		$endImagem = $linhaDaConsultaImagem["endImagem"];
		list($widthImagem, $heightImagem, $typeImagem, $attrImagem) = getimagesize("ImagensEnviadas/$endImagem");
		$infoImagem = pathinfo("ImagensEnviadas/$endImagem");
	}	
	
	$consultaVideo = mysql_query("SELECT * FROM videos
	INNER JOIN usuario ON (usuario.codUsuario = videos.codUsuario)
	INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
	WHERE codColaboracao = '$codColaboracao'
	");
	if ($linhaDaConsultaVideo = mysql_fetch_assoc($consultaVideo)){
		$desTituloVideo = $linhaDaConsultaVideo["desTituloVideo"];
		$comentarioVideo = $linhaDaConsultaVideo["comentarioVideo"];
		$desUrlVideo = $linhaDaConsultaVideo["desUrlVideo"];
	}
	
	$consultaArquivo = mysql_query("SELECT * FROM arquivos
	INNER JOIN usuario ON (usuario.codUsuario = arquivos.codUsuario)
	INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
	WHERE codColaboracao = '$codColaboracao'
	");
	if ($linhaDaConsultaArquivo = mysql_fetch_assoc($consultaArquivo)){
		$desArquivo = $linhaDaConsultaArquivo["desArquivo"];
		$comentarioArquivo = $linhaDaConsultaArquivo["comentarioArquivo"];
		$endArquivo = $linhaDaConsultaArquivo["endArquivo"];
		$infoArquivo = pathinfo("Arquivos/$endArquivo");
	}
	
	
	//Tamanho da linha vertical do layout <hr>
	$tamanhoLinha = "350px";
	
	//Cores das linhas da tabela
	$cor1 = "#d6d6d6";
	$cor2 = "#ffffff";
	$cor3 = "#e0e0e0";
?>
<link rel="stylesheet" href="metadados.css" type="text/css" media="all" />	

<html>
	<body>
		<div class='centro' style="width:430px; height:360px; overflow:auto;" >
			<b>Template usado: DM4VGI - Dynamic Metadata for VGI</b>
			<br>
			<br>
			<div class="cabecalhoMD" ><b>Identifica��o</b></div><br>			
			<table width = '400px'>
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo'>T�tulo</td>
					<td class='tdMDdinamico'><?php  echo $titulo; ?></td>
				</tr>
				<tr bgcolor="<?php  echo $cor2; ?>">
					<td height = '50px' class='tdMDfixo'>Resumo</td>
					<td height = '50px' class='tdMDdinamico'><?php  echo $resumo ?></td>
				</tr>
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo'>Categoria</td>
					<td class='tdMDdinamico'><?php  echo $categoria; ?></td>
				</tr>
				<tr bgcolor="<?php  echo $cor2; ?>">
					<td class='tdMDfixo'>Tipo</td>
					<td class='tdMDdinamico'><?php  echo $tipo; ?></td>
				</tr>
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo'>Software</td>
					<td class='tdMDdinamico'>ClickOnMap</td>
				</tr>
				<tr bgcolor="<?php  echo $cor2; ?>">
					<td class='tdMDfixo'>Website</td>
					<td class='tdMDdinamico'><a href="http://www.ide.ufv.br:8008/cidadaovicosa/" alt="<?php  echo $nome_site; ?> " title="<?php  echo $nome_site; ?> " target="_blank">www.ide.ufv.br/cidadaovicosa</a></td>
				</tr>
			</table>			
			<br>
			<div class="cabecalhoMD" ><b>Registro Temporal</b></div>
			<br>
			<fieldset>
				<legend><b>Data e Hora</b></legend>
				<table width = '380px' align ='center'>
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo'  style='width:50%;'> Contribui��o </td>
						<td class='tdMDdinamico'><?php  echo date('d/m/Y - H:i:s', strtotime($dataHoraCriacao)); ?></td>
					</tr>
					<tr bgcolor="<?php  echo $cor2; ?>">
						<td class='tdMDfixo'> Ocorr�ncia </td>
						<td class='tdMDdinamico'><?php  
							if($dataOcorrencia)
								echo date('d/m/Y', strtotime($dataOcorrencia)) . " - ";
							else
								echo "N�o possui data de ocorr�ncia";
							if($horaOcorrencia)
								echo date('H:i:s', strtotime($horaOcorrencia));
							else
								echo "N�o possui hora de ocorr�ncia";
							?>
						</td>
					</tr>
					<tr bgcolor="<?php  echo $cor1; ?>">
						<?php $aux = mysql_num_rows($consulta5);?> 
						<td class='tdMDfixo' rowspan = '<?php echo ($aux);?>'> Atualiza��es </td>
						<?php  if($aux == 1) echo "<td class='tdMDdinamico'>N�o houve Atualiza��o</td>";?>
					</tr>	
					
					<?php 	$aux = 0;
					while($linhaDaConsulta5 = mysql_fetch_assoc($consulta5)){
						$aux++;
						?>
						<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDdinamico' >
						<?php echo date('d/m/Y - H:i:s', strtotime($linhaDaConsulta5['datahoraModificacao']));?>
						</td>
						</tr>
						<?php 
					}
					
					?>
				</table>
			</fieldset>			
			<br>
			<div class="cabecalhoMD" ><b>Geoposicionamento</b></div>
			<br>
				<fieldset> <legend><b> Ret�ngulo Envolvente </b></legend>
						<table align='center' >
							<tr align='center'>
								<td colspan = '3'   ><b>Norte</b></td>
							</tr>
							<tr align='center'>
								<td colspan = '3'  ><?php  echo $norte; ?></td>
							</tr>
							
							<tr align='center'>
								<td ><b>Oeste</b></td>
								<td style = 'padding-left: 100px;'>  </td>
								<td ><b>Leste</b></td>
							</tr>
							
							<tr align='center'>
								<td  ><?php  echo $oeste; ?></td>
								<td style = 'padding-left: 50px;'> </td>
								<td  ><?php  echo $leste; ?></td>
							</tr>
							
							<tr align='center'>
								<td colspan = '3'  ><b>Sul</b></td>
							</tr>
							<tr align='center'>
								<td colspan = '3'  ><?php  echo $sul; ?></td>
							</tr>
						</table>								
							
				</fieldset>		
			<br>		
			<table width = '400px' >
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo' style='width:50%;' >Tipo de Geometria</td>
					<td class='tdMDdinamico' colspan='2'> Ponto</td>
				</tr>
			</table>
			<br>
			<div class="cabecalhoMD" ><b>Qualidade da VGI</b></div>	
			<br>
			
			<fieldset>
				<legend><b>Hist�rico de Colabora��o</b></legend>	
				<table width = '380px'>					
					<?php 
					$aux = 0;
					$consulta5 = mysql_query("SELECT * FROM historicocolaboracoes WHERE codColaboracao = '$codColaboracao' ");
					while($linhaDaConsulta5 = mysql_fetch_assoc($consulta5)){						
						if($aux == 0) {
							?>
							<tr>
								<td class='tdMDfixo' >T�tulo</td>
								<td class='tdMDfixo' >Descri��o</td>
								<td class='tdMDfixo' >Data e Hora</td>
							<tr>
							<?php 
						}					
						$aux++;
						if (mysql_num_rows($consulta5) == $aux)
							break;
						?>
						<tr bgcolor="<?php  if(($aux%2)==0) echo  $cor2; else echo $cor1; ?>">
							<td class='tdMDdinamico' style = 'text-align:center;' >
								<?php 
								echo $linhaDaConsulta5['desTitulo'];
								?>
							</td>
							<td class='tdMDdinamico' style = 'text-align:center;'>
								<?php 
								echo $linhaDaConsulta5['desColaboracao'];
								?>
							</td>
							<td class='tdMDdinamico' style = 'text-align:center;'>
								<?php 
								echo $linhaDaConsulta5['datahoraModificacao'];
								?>
							</td>
						</tr><?php 
					}
					if($aux == 0) echo "N�o houve revis�es Wiki";
					?>
				</table>
			</fieldset>
			
			<fieldset>
				<legend><b>N�mero de Wiki</b></legend>			
				<table width = '380px'>						
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo' style='width:50%;'>Revis�es </td>
						<td class='tdMDdinamico'><?php  echo $numRevisoes; ?></td>
					</tr>
					<tr bgcolor="<?php  echo $cor2; ?>">
						<td class='tdMDfixo'>Revisores distintos </td>
						<td class='tdMDdinamico'><?php  echo $numRevisores; ?></td>
					</tr>
				</table>
			</fieldset>	
			
			<fieldset >
				<legend><b>Hist�rias de Usu�rios</b></legend>
				<table width = '380px'>
				
				<?php 
				$aux1 = 0;				
				while($linhaDaConsulta8 = mysql_fetch_assoc($consulta8)){
					if($aux1 == 0) {
						?>
						<tr>
							<td class='tdMDfixo' style='width:33.33%; padding-left: 15px;' >Usu�rio</td>
							<td class='tdMDfixo' style='width:33.33%; padding-left: 15px;' >Pontos do Usu�rio</td>
							<td class='tdMDfixo' style='width:33.33%; padding-left: 15px;' >Data e Hora</td>
						<tr>
						<?php 
					}
					$aux1++;
					?><tr bgcolor="<?php  if(($aux1%2)==0) echo  $cor2; else echo $cor1; ?>">
						<td class='tdMDdinamico' style = 'text-align:center; max-width: 200px;'>
							<?php 
							echo $linhaDaConsulta8['nomPessoa'];
							?>
						</td>						
						<td class='tdMDdinamico' style = 'text-align:center;'>
							<?php 
							echo $linhaDaConsulta8['pontos'];
							?>
						</td>
						<td class='tdMDdinamico' style = 'text-align:center; max-width: 50px;'>
							<?php 
							echo $linhaDaConsulta8['datahoraCriacao'];
							?>
						</td>
					</tr><?php 
				}
				if($aux1 == 0) echo "N�o possui hist�rias de usu�rios.";
				?>
				</table>
			</fieldset>
			
			<fieldset>
				<legend><b>Pontua��o</b></legend>			
				<table width = '380px'>	
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo' style='width:50%;'>Nota Final </td>
						<td class='tdMDdinamico'><?php  echo $notaFinal; ?></td>
					</tr>
					<tr bgcolor="<?php  echo $cor2; ?>">
						<td class='tdMDfixo'>Valor M�nimo </td>
						<td class='tdMDdinamico'>0</td>
					</tr>
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo'>Valor M�ximo </td>
						<td class='tdMDdinamico'>5</td>
					</tr>
				</table>
			</fieldset>			
			<br>				
			<table width = '400px'>					
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo' style='width:50%;'>N�mero de Avalia��es</td>
					<td class='tdMDdinamico'><?php  echo $numeroAvaliacao; ?></td>
				</tr>
				<tr bgcolor="<?php  echo $cor2; ?>">
					<td class='tdMDfixo' >N�mero de Visualiza��es</td>
					<td class='tdMDdinamico'><?php  echo $numeroVisualizacao; ?></td>
				</tr>
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo'>Status</td>
					<td class='tdMDdinamico'><?php  echo $status; ?></td>
				</tr>
				<tr bgcolor="<?php  echo $cor2; ?>">
					<td class='tdMDfixo'>M�todo de Avalia��o</td>
					<td class='tdMDdinamico'>M�dia ponderada baseada em hierarquia de usu�rios.</td>
				</tr>
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo'>Zoom Colabora��o</td>
					<td class='tdMDdinamico'>N�vel <?php  echo $zoomColaboracao; ?> de Zoom da Google Maps API</td>
				</tr>
			</table>
			<br>
			
			<div class="cabecalhoMD" ><b>Multim�dia</b></div>
				<br>
				<fieldset>
					<legend><b>Imagem</b></legend>
					<?php if (mysql_num_rows($consultaImagem)>0) {?>
						<table width = '380px'>					
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>T�tulo</td>
								<td class='tdMDdinamico'><?php  echo $desTituloImagem; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo' >Descri��o</td>
								<td class='tdMDdinamico'><?php  echo $comentarioImagem; ?></td>
							</tr>													
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Nome do arquivo</td>
								<td class='tdMDdinamico'><?php  echo $infoImagem['filename']; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Tamanho</td>
								<td class='tdMDdinamico'><?php  echo filesize("Arquivos/$endArquivo") . ' bytes'; ?></td>
							</tr>							
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Formato</td>
								<td class='tdMDdinamico'><?php  echo image_type_to_mime_type($typeImagem); ?></td>
							</tr>							
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Resolu��o</td>
								<td class='tdMDdinamico'><?php  echo $attrImagem; ?></td>
							</tr>
						</table>
					<?php }else echo "<table width = '380px'><tr><td align = 'center'>Colabora��o sem imagem ou foto</td></tr></table>";?>
					
				</fieldset>
				<fieldset>
					<legend><b>Video</b></legend>
					<?php if (mysql_num_rows($consultaVideo)>0) {?>
						<table width = '380px'>					
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>T�tulo</td>
								<td class='tdMDdinamico'><?php  echo $desTituloVideo; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo' >Descri��o</td>
								<td class='tdMDdinamico'><?php  echo $comentarioVideo; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Link de acesso</td>
								<td class='tdMDdinamico'><?php  echo "<a href=http://www.youtube.com/watch?v=$desUrlVideo> http://www.youtube.com/watch?v=$desUrlVideo </a>"; ?></td>
							</tr>
						</table>
					<?php }else echo "<table width = '380px'><tr><td align = 'center'>Colabora��o sem URL de Video</td></tr></table>";?>
				</fieldset>
				<fieldset>
					<legend><b>Arquivo</b></legend>
					<?php if (mysql_num_rows($consultaArquivo)>0) {?>
						<table width = '380px'>					
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>T�tulo</td>
								<td class='tdMDdinamico'><?php  echo $desArquivo; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo' >Descri��o</td>
								<td class='tdMDdinamico'><?php  echo $comentarioArquivo; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Nome do arquivo</td>
								<td class='tdMDdinamico'><?php  echo $infoArquivo['filename']; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Tamanho</td>
								<td class='tdMDdinamico'><?php  echo filesize("ImagensEnviadas/$endImagem") . ' bytes'; ?></td>
							</tr>					
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Formato</td>
								<td class='tdMDdinamico'><?php  echo $infoArquivo['extension']; ?></td>
							</tr>
						</table>
					<?php }else echo "<table width = '380px'><tr><td align = 'center'>Colabora��o sem Arquivos Extras</td></tr></table>";?>
				</fieldset>
			
			<br>
			<div class="cabecalhoMD" ><b>Autoria e Distribui��o</b></div>
			<br>
			<fieldset>
				<legend><b>Autores VGI</b></legend>			
				
				<?php while($linhaDaConsulta9 = mysql_fetch_assoc($consulta9)){?>
				
				<fieldset>
					<legend><b>Autor VGI - Aba principal</b></legend>
					<table width = '350px'>	
						<tr bgcolor="<?php  echo $cor1; ?>">
							<td class='tdMDfixo' style='width:50%;'>Nome </td>
							<td class='tdMDdinamico'><?php // echo $nomeAutor; ?>Informa��o vis�vel apenas para administradores.</td>
						</tr>
						<tr bgcolor="<?php  echo $cor2; ?>">
							<td class='tdMDfixo'>Faixa Et�ria </td>
							<td class='tdMDdinamico'><?php  echo $linhaDaConsulta9['faixaEtaria']; ?></td>
						</tr>
						<tr bgcolor="<?php  echo $cor1; ?>">
							<td class='tdMDfixo'>Email </td>
							<td class='tdMDdinamico'><?php // echo $emailAutor; ?>Informa��o vis�vel apenas para administradores.</td>
						</tr>
						<tr bgcolor="<?php  echo $cor2; ?>">
							<td class='tdMDfixo'>Ranking </td>
							<td class='tdMDdinamico'>Ranking <?php  echo $nome_site; ?> </td>
						</tr>
						<?php 
						$num = mysql_query("SELECT *, @i := @i + 1 as result FROM usuario, (select @i := 0 ) temp ORDER BY pontos DESC" );
						if (!$num) {
							die('Invalid query num: ' . mysql_error());
						}							
						
						While ($num2 = mysql_fetch_array($num)){								
							if ($linhaDaConsulta9['codUsuario'] == $num2["codUsuario"])
								break ;								
						}
						$i  = $num2['result'];
						?>
						<tr bgcolor="<?php  echo $cor1; ?>">
							<td class='tdMDfixo'>Posi��o no Ranking </td>
							<td class='tdMDdinamico'><?php  echo $i; ?></td>
						</tr>							
						<tr bgcolor="<?php  echo $cor2; ?>">
							<td class='tdMDfixo'>Escala do Ranking </td>
							<td class='tdMDdinamico'><?php  echo $linhaDaConsulta9['nomeClasse'] ?></td>
						</tr>
						<tr bgcolor="<?php  echo $cor1; ?>">
							<td class='tdMDfixo'>IP </td>
							<td class='tdMDdinamico'>Informa��o vis�vel apenas para administradores.</td>
						</tr>
					</table>
				</fieldset>
				<?php }?>
				<?php  if (mysql_num_rows($consultaImagem)>0) {?>
					<fieldset>
						<legend><b>Autor VGI - Imagem</b></legend>
						<table width = '350px'>	
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>Nome </td>
								<td class='tdMDdinamico'><?php // echo $nomeAutor; ?>Informa��o vis�vel apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Faixa Et�ria </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaImagem["faixaEtaria"]; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Email </td>
								<td class='tdMDdinamico'><?php // echo $emailAutor; ?>Informa��o vis�vel apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Ranking </td>
								<td class='tdMDdinamico'>Ranking <?php  echo $nome_site; ?> </td>
							</tr>
							<?php 
							$num = mysql_query("SELECT *, @i := @i + 1 as result FROM usuario, (select @i := 0 ) temp ORDER BY pontos DESC" );
							if (!$num) {
								die('Invalid query num: ' . mysql_error());
							}							
							
							While ($num2 = mysql_fetch_array($num)){								
								if ($linhaDaConsultaImagem['codUsuario'] == $num2["codUsuario"])
									break ;								
							}
							$i  = $num2['result'];
							?>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Posi��o no Ranking </td>
								<td class='tdMDdinamico'><?php  echo $i; ?></td>
							</tr>							
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Escala do Ranking </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaImagem['nomeClasse'] ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>IP </td>
								<td class='tdMDdinamico'>Informa��o vis�vel apenas para administradores.</td>
							</tr>
						</table>
					</fieldset>
				<?php }?>
				<?php  if (mysql_num_rows($consultaVideo)>0) {?>
					<fieldset>
						<legend><b>Autor VGI - Video</b></legend>
						<table width = '350px'>	
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>Nome </td>
								<td class='tdMDdinamico'><?php // echo $nomeAutor; ?>Informa��o vis�vel apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Faixa Et�ria </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaVideo['faixaEtaria']; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Email </td>
								<td class='tdMDdinamico'><?php // echo $emailAutor; ?>Informa��o vis�vel apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Ranking </td>
								<td class='tdMDdinamico'>Ranking <?php  echo $nome_site; ?> </td>
							</tr>
							<?php 
							$num = mysql_query("SELECT *, @i := @i + 1 as result FROM usuario, (select @i := 0 ) temp ORDER BY pontos DESC" );
							if (!$num) {
								die('Invalid query num: ' . mysql_error());
							}							
							
							While ($num2 = mysql_fetch_array($num)){								
								if ($linhaDaConsultaVideo['codUsuario'] == $num2["codUsuario"])
									break ;								
							}
							$i  = $num2['result'];
							?>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Posi��o no Ranking </td>
								<td class='tdMDdinamico'><?php  echo $i; ?></td>
							</tr>							
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Escala do Ranking </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaVideo['nomeClasse'] ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>IP </td>
								<td class='tdMDdinamico'>Informa��o vis�vel apenas para administradores.</td>
							</tr>
						</table>
					</fieldset>
				<?php }?>
				<?php  if (mysql_num_rows($consultaArquivo)>0) {?>
					<fieldset>
						<legend><b>Autor VGI - Arquivo</b></legend>
						<table width = '350px'>	
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>Nome </td>
								<td class='tdMDdinamico'><?php // echo $nomeAutor; ?>Informa��o vis�vel apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Faixa Et�ria </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaArquivo['faixaEtaria']; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Email </td>
								<td class='tdMDdinamico'><?php // echo $emailAutor; ?>Informa��o vis�vel apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Ranking </td>
								<td class='tdMDdinamico'>Ranking <?php  echo $nome_site; ?> </td>
							</tr>
							<?php 
							$num = mysql_query("SELECT *, @i := @i + 1 as result FROM usuario, (select @i := 0 ) temp ORDER BY pontos DESC" );
							if (!$num) {
								die('Invalid query num: ' . mysql_error());
							}							
							
							While ($num2 = mysql_fetch_array($num)){								
								if ($linhaDaConsultaArquivo['codUsuario'] == $num2["codUsuario"])
									break ;								
							}
							$i  = $num2['result'];
							?>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Posi��o no Ranking </td>
								<td class='tdMDdinamico'><?php  echo $i; ?></td>
							</tr>							
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Escala do Ranking </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaArquivo['nomeClasse'] ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>IP </td>
								<td class='tdMDdinamico'>Informa��o vis�vel apenas para administradores.</td>
							</tr>
						</table>
					</fieldset>
				<?php }?>
			</fieldset>
			<fieldset>
				<legend><b>Distribuidor VGI</b></legend>
				<table width = '380px'>	
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo'  style='width:50%;'>Nome </td>
						<td class='tdMDdinamico'><?php  echo $nome_site ?></td>
					</tr>
					<tr bgcolor="<?php  echo $cor2; ?>">
						<td class='tdMDfixo'>Email </td>
						<td class='tdMDdinamico'><a href="mailto:<?php  echo $email_site; ?>"><?php  echo $email_site; ?></a></td>
					</tr>
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo'>Site </td>
						<td class='tdMDdinamico'><a href="<?php  echo $link_inicial; ?>" alt="<?php  echo $nome_site; ?> " title="<?php  echo $nome_site; ?> " target="_blank">www.ide.ufv.br/cidadaovicosa</a></td>
					</tr>
					<tr bgcolor="<?php  echo $cor2; ?>">
						<td class='tdMDfixo'>IP </td>
						<td class='tdMDdinamico'>200.235.131.170</td>
					</tr>
				</table>
			</fieldset>
			<br>
			<table width = '400px'>
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo' style='width:50%;'>Link de Download ou Acesso </td>
					<td class='tdMDdinamico'><a href="http://www.ide.ufv.br:8008/cidadaovicosa/" alt="<?php  echo $nome_site; ?> " title="<?php  echo $nome_site; ?> " target="_blank">www.ide.ufv.br/cidadaovicosa</a></td>
				</tr>			
			</table>
			<br>
		</div>
	</body>
</html>

<?php 
	
?>