<?php 
header("Content-Type: text/html; charset=ISO-8859-1",true);
require("../phpsqlinfo_dbinfo.php");

$codColaboracao = '';
if(isset($_GET["id"])) $codColaboracao = $_GET["id"];//Código da colaboração recebida pela função

//Tabela: COLABORACAO: Consulta para pegar todos os dados da colaboração
$consulta = $connection->query("SELECT * FROM  colaboracao WHERE codColaboracao = '$codColaboracao' ");
	if ( !($linhaDaConsulta = $consulta->fetch_assoc()) ){
		echo "Erro na consulta: Não foi encontrado a colaboração com código: ".$codColaboracao;
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
		$status = "Em Avaliação";
		else if($linhaDaConsulta['tipoStatus'] == 'A')
			$status = "Aprovada";
			else if($linhaDaConsulta['tipoStatus'] == 'R')
				$status = "Reprovada";
				
	$zoomColaboracao = $linhaDaConsulta['zoom'];
	$codigoUsuario = $linhaDaConsulta['codUsuario'];
	
	
	$codigoCategoria = $linhaDaConsulta['codCategoriaEvento'];
		//Tabela: CATEGORIAEVENTO: Consulta para pegar o nome da colaboração de código $codigoCategoria
		$consulta2 = $connection->query("SELECT desCategoriaEvento FROM categoriaevento WHERE codCategoriaEvento = '$codigoCategoria' ");
			if ( !($linhaDaConsulta2 = $consulta2->fetch_assoc()) ){
				echo "Erro na consulta 2: Não foi encontrado a categoria com código: ".$codigoCategoria;
				exit;
			}
			$categoria = $linhaDaConsulta2['desCategoriaEvento'];
	
	$codigoTipo = $linhaDaConsulta['codTipoEvento'];
		//Tabela: TIPOEVENTO: Consulta para pegar o nome do tipo de código $codigoTipo
		$consulta3 = $connection->query("SELECT desTipoEvento FROM tipoevento WHERE codTipoEvento = '$codigoTipo' ");
			if ( !($linhaDaConsulta3 = $consulta3->fetch_assoc()) ){
				echo "Erro na consulta 3: Não foi encontrado o tipo com código: ".$codigoTipo;
				exit;
			}
			$tipo = $linhaDaConsulta3['desTipoEvento'];
	
	//Tabela ESTATISTICA: Consulta para pegar o numero de visualizacoes de determinada colaboração
	$consulta4 = $connection->query("SELECT * FROM estatistica WHERE codColaboracao = '$codColaboracao' ");
		if ( !($linhaDaConsulta4 = $consulta4->fetch_assoc()) ){
			echo "Erro na consulta 4: Não foi encontrada a colaboração com código: ".$codColaboracao;
			exit;
		}
		$numeroVisualizacao = $linhaDaConsulta4['qtdVisualizacao'];
		$numeroAvaliacao = $linhaDaConsulta4['qtdAvaliacao'];
		$notaFinal = $linhaDaConsulta4['notaMedia'];				
	
	//Tabela HISTORICOCOLABORACOES: Consulta para pegar a data e hora das atualizações na tabela de histórico
	$consulta5 = $connection->query("SELECT * FROM historicocolaboracoes WHERE codColaboracao = '$codColaboracao' ");
	if(!($linhaDaConsulta5 = $consulta5->fetch_assoc())){
		echo "Erro na consulta 5: Não foi encontrado alterações na colaboração com código: ".$codColaboracao;
		exit;
	}
		$numRevisoes = $consulta5->num_rows - 1;//Subtrai 1 pois quando a colaboração é criada ela é gravada nessa tabela, ou seja, ela ainda não foi editada mas existe uma linha com seus dados
			
	//Tabela COMENTARIO: Consulta para pegar informações de histórias de usuário
	$consulta8 = $connection->query("SELECT * FROM comentario
	INNER JOIN usuario ON (usuario.codUsuario = comentario.codUsuario)
	INNER JOIN classesdeusuarios ON (usuario.classeUsuario = classesdeusuarios.codClasse)
	WHERE codColaboracao = '$codColaboracao' ");
		/*if(!($linhaDaConsulta8 = $consulta8->fetch_assoc())){
			echo "Erro na consulta 8: Não foi encontrado historias de usuario na colaboração com código: ".$codColaboracao;
			exit;
		}*/
		
	$consulta9 = $connection->query("SELECT *, count(historicocolaboracoes.codUsuario) FROM historicocolaboracoes
	INNER JOIN usuario ON (usuario.codUsuario = historicocolaboracoes.codUsuario)
	INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
	WHERE codColaboracao = '$codColaboracao' GROUP BY historicocolaboracoes.codUsuario having count(historicocolaboracoes.codUsuario)> 0");
	if($consulta9->num_rows<1){
		echo "Erro na consulta 9: Não foi encontrado alterações na colaboração com código: ".$codColaboracao;
		exit;
	}
		$numRevisores = $consulta9->num_rows - 1;//Subtrai 1 pois o autor não conta como revisor
	
	$consultaImagem = $connection->query("SELECT * FROM multimidia
	INNER JOIN usuario ON (usuario.codUsuario = multimidia.codUsuario)
	INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
	WHERE codColaboracao = '$codColaboracao'
	");
	if ($linhaDaConsultaImagem = $consultaImagem->fetch_assoc()){
		$desTituloImagem = $linhaDaConsultaImagem["desTituloImagem"];
		$comentarioImagem = $linhaDaConsultaImagem["comentarioImagem"];
		$endImagem = $linhaDaConsultaImagem["endImagem"];
		list($widthImagem, $heightImagem, $typeImagem, $attrImagem) = getimagesize("imagensenviadas/$endImagem");
		$infoImagem = pathinfo("imagensenviadas/$endImagem");
	}	
	
	$consultaVideo = $connection->query("SELECT * FROM videos
	INNER JOIN usuario ON (usuario.codUsuario = videos.codUsuario)
	INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
	WHERE codColaboracao = '$codColaboracao'
	");
	if ($linhaDaConsultaVideo = $consultaVideo->fetch_assoc()){
		$desTituloVideo = $linhaDaConsultaVideo["desTituloVideo"];
		$comentarioVideo = $linhaDaConsultaVideo["comentarioVideo"];
		$desUrlVideo = $linhaDaConsultaVideo["desUrlVideo"];
	}
	
	$consultaArquivo = $connection->query("SELECT * FROM arquivos
	INNER JOIN usuario ON (usuario.codUsuario = arquivos.codUsuario)
	INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
	WHERE codColaboracao = '$codColaboracao'
	");
	if ($linhaDaConsultaArquivo = $consultaArquivo->fetch_assoc()){
		$desArquivo = $linhaDaConsultaArquivo["desArquivo"];
		$comentarioArquivo = $linhaDaConsultaArquivo["comentarioArquivo"];
		$endArquivo = $linhaDaConsultaArquivo["endArquivo"];
		$infoArquivo = pathinfo("arquivos/$endArquivo");
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
			<div class="cabecalhoMD" ><b>Identificação</b></div><br>			
			<table width = '400px'>
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo'>Título</td>
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
						<td class='tdMDfixo'  style='width:50%;'> Contribuição </td>
						<td class='tdMDdinamico'><?php  echo date('d/m/Y - H:i:s', strtotime($dataHoraCriacao)); ?></td>
					</tr>
					<tr bgcolor="<?php  echo $cor2; ?>">
						<td class='tdMDfixo'> Ocorrência </td>
						<td class='tdMDdinamico'><?php  
							if($dataOcorrencia)
								echo date('d/m/Y', strtotime($dataOcorrencia)) . " - ";
							else
								echo "Não possui data de ocorrência";
							if($horaOcorrencia)
								echo date('H:i:s', strtotime($horaOcorrencia));
							else
								echo "Não possui hora de ocorrência";
							?>
						</td>
					</tr>
					<tr bgcolor="<?php  echo $cor1; ?>">
						<?php $aux = $consulta5->num_rows;?>
						<td class='tdMDfixo' rowspan = '<?php echo ($aux);?>'> Atualizações </td>
						<?php  if($aux == 1) echo "<td class='tdMDdinamico'>Não houve Atualização</td>";?>
					</tr>	
					
					<?php 	$aux = 0;
					while($linhaDaConsulta5 = $consulta5->fetch_assoc()){
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
				<fieldset> <legend><b> Retângulo Envolvente </b></legend>
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
				<legend><b>Histórico de Colaboração</b></legend>	
				<table width = '380px'>					
					<?php 
					$aux = 0;
					$consulta5 = $connection->query("SELECT * FROM historicocolaboracoes WHERE codColaboracao = '$codColaboracao' ");
					while($linhaDaConsulta5 = $consulta5->fetch_assoc()){
						if($aux == 0) {
							?>
							<tr>
								<td class='tdMDfixo' >Título</td>
								<td class='tdMDfixo' >Descrição</td>
								<td class='tdMDfixo' >Data e Hora</td>
							<tr>
							<?php 
						}					
						$aux++;
						if ($consulta5->num_rows == $aux)
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
					if($aux == 0) echo "Não houve revisões Wiki";
					?>
				</table>
			</fieldset>
			
			<fieldset>
				<legend><b>Número de Wiki</b></legend>			
				<table width = '380px'>						
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo' style='width:50%;'>Revisões </td>
						<td class='tdMDdinamico'><?php  echo $numRevisoes; ?></td>
					</tr>
					<tr bgcolor="<?php  echo $cor2; ?>">
						<td class='tdMDfixo'>Revisores distintos </td>
						<td class='tdMDdinamico'><?php  echo $numRevisores; ?></td>
					</tr>
				</table>
			</fieldset>	
			
			<fieldset >
				<legend><b>Histórias de Usuários</b></legend>
				<table width = '380px'>
				
				<?php 
				$aux1 = 0;				
				while($linhaDaConsulta8 = $consulta8->fetch_assoc()){
					if($aux1 == 0) {
						?>
						<tr>
							<td class='tdMDfixo' style='width:33.33%; padding-left: 15px;' >Usuário</td>
							<td class='tdMDfixo' style='width:33.33%; padding-left: 15px;' >Pontos do Usuário</td>
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
				if($aux1 == 0) echo "Não possui histórias de usuários.";
				?>
				</table>
			</fieldset>
			
			<fieldset>
				<legend><b>Pontuação</b></legend>			
				<table width = '380px'>	
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo' style='width:50%;'>Nota Final </td>
						<td class='tdMDdinamico'><?php  echo $notaFinal; ?></td>
					</tr>
					<tr bgcolor="<?php  echo $cor2; ?>">
						<td class='tdMDfixo'>Valor Mínimo </td>
						<td class='tdMDdinamico'>0</td>
					</tr>
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo'>Valor Máximo </td>
						<td class='tdMDdinamico'>5</td>
					</tr>
				</table>
			</fieldset>			
			<br>				
			<table width = '400px'>					
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo' style='width:50%;'>Número de Avaliações</td>
					<td class='tdMDdinamico'><?php  echo $numeroAvaliacao; ?></td>
				</tr>
				<tr bgcolor="<?php  echo $cor2; ?>">
					<td class='tdMDfixo' >Número de Visualizações</td>
					<td class='tdMDdinamico'><?php  echo $numeroVisualizacao; ?></td>
				</tr>
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo'>Status</td>
					<td class='tdMDdinamico'><?php  echo $status; ?></td>
				</tr>
				<tr bgcolor="<?php  echo $cor2; ?>">
					<td class='tdMDfixo'>Método de Avaliação</td>
					<td class='tdMDdinamico'>Média ponderada baseada em hierarquia de usuários.</td>
				</tr>
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo'>Zoom Colaboração</td>
					<td class='tdMDdinamico'>Nível <?php  echo $zoomColaboracao; ?> de Zoom da Google Maps API</td>
				</tr>
			</table>
			<br>
			
			<div class="cabecalhoMD" ><b>Multimídia</b></div>
				<br>
				<fieldset>
					<legend><b>Imagem</b></legend>
					<?php if ($consultaImagem->num_rows>0) {?>
						<table width = '380px'>					
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>Título</td>
								<td class='tdMDdinamico'><?php  echo $desTituloImagem; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo' >Descrição</td>
								<td class='tdMDdinamico'><?php  echo $comentarioImagem; ?></td>
							</tr>													
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Nome do arquivo</td>
								<td class='tdMDdinamico'><?php  echo $infoImagem['filename']; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Tamanho</td>
								<td class='tdMDdinamico'><?php  echo filesize("arquivos/$endArquivo") . ' bytes'; ?></td>
							</tr>							
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Formato</td>
								<td class='tdMDdinamico'><?php  echo image_type_to_mime_type($typeImagem); ?></td>
							</tr>							
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Resolução</td>
								<td class='tdMDdinamico'><?php  echo $attrImagem; ?></td>
							</tr>
						</table>
					<?php }else echo "<table width = '380px'><tr><td align = 'center'>Colaboração sem imagem ou foto</td></tr></table>";?>
					
				</fieldset>
				<fieldset>
					<legend><b>Video</b></legend>
					<?php if ($consultaVideo->num_rows>0) {?>
						<table width = '380px'>					
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>Título</td>
								<td class='tdMDdinamico'><?php  echo $desTituloVideo; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo' >Descrição</td>
								<td class='tdMDdinamico'><?php  echo $comentarioVideo; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Link de acesso</td>
								<td class='tdMDdinamico'><?php  echo "<a href=http://www.youtube.com/watch?v=$desUrlVideo> http://www.youtube.com/watch?v=$desUrlVideo </a>"; ?></td>
							</tr>
						</table>
					<?php }else echo "<table width = '380px'><tr><td align = 'center'>Colaboração sem URL de Video</td></tr></table>";?>
				</fieldset>
				<fieldset>
					<legend><b>Arquivo</b></legend>
					<?php if ($consultaArquivo->num_rows>0) {?>
						<table width = '380px'>					
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>Título</td>
								<td class='tdMDdinamico'><?php  echo $desArquivo; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo' >Descrição</td>
								<td class='tdMDdinamico'><?php  echo $comentarioArquivo; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Nome do arquivo</td>
								<td class='tdMDdinamico'><?php  echo $infoArquivo['filename']; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Tamanho</td>
								<td class='tdMDdinamico'><?php  echo filesize("imagensenviadas/$endImagem") . ' bytes'; ?></td>
							</tr>					
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Formato</td>
								<td class='tdMDdinamico'><?php  echo $infoArquivo['extension']; ?></td>
							</tr>
						</table>
					<?php }else echo "<table width = '380px'><tr><td align = 'center'>Colaboração sem arquivos Extras</td></tr></table>";?>
				</fieldset>
			
			<br>
			<div class="cabecalhoMD" ><b>Autoria e Distribuição</b></div>
			<br>
			<fieldset>
				<legend><b>Autores VGI</b></legend>			
				
				<?php while($linhaDaConsulta9 = $consulta9->fetch_assoc()){?>
				
				<fieldset>
					<legend><b>Autor VGI - Aba principal</b></legend>
					<table width = '350px'>	
						<tr bgcolor="<?php  echo $cor1; ?>">
							<td class='tdMDfixo' style='width:50%;'>Nome </td>
							<td class='tdMDdinamico'><?php // echo $nomeAutor; ?>Informação visível apenas para administradores.</td>
						</tr>
						<tr bgcolor="<?php  echo $cor2; ?>">
							<td class='tdMDfixo'>Faixa Etária </td>
							<td class='tdMDdinamico'><?php  echo $linhaDaConsulta9['faixaEtaria']; ?></td>
						</tr>
						<tr bgcolor="<?php  echo $cor1; ?>">
							<td class='tdMDfixo'>Email </td>
							<td class='tdMDdinamico'><?php // echo $emailAutor; ?>Informação visível apenas para administradores.</td>
						</tr>
						<tr bgcolor="<?php  echo $cor2; ?>">
							<td class='tdMDfixo'>Ranking </td>
							<td class='tdMDdinamico'>Ranking <?php  echo $nome_site; ?> </td>
						</tr>
						<?php 
						$num = $connection->query("SELECT *, @i := @i + 1 as result FROM usuario, (select @i := 0 ) temp ORDER BY pontos DESC" );
						if (!$num) {
							die('Invalid query num: ' . $connection->error);
						}							
						
						While ($num2 = $num->fetch_array()){
							if ($linhaDaConsulta9['codUsuario'] == $num2["codUsuario"])
								break ;								
						}
						$i  = $num2['result'];
						?>
						<tr bgcolor="<?php  echo $cor1; ?>">
							<td class='tdMDfixo'>Posição no Ranking </td>
							<td class='tdMDdinamico'><?php  echo $i; ?></td>
						</tr>							
						<tr bgcolor="<?php  echo $cor2; ?>">
							<td class='tdMDfixo'>Escala do Ranking </td>
							<td class='tdMDdinamico'><?php  echo $linhaDaConsulta9['nomeClasse'] ?></td>
						</tr>
						<tr bgcolor="<?php  echo $cor1; ?>">
							<td class='tdMDfixo'>IP </td>
							<td class='tdMDdinamico'>Informação visível apenas para administradores.</td>
						</tr>
					</table>
				</fieldset>
				<?php }?>
				<?php  if ($consultaImagem->num_rows>0) {?>
					<fieldset>
						<legend><b>Autor VGI - Imagem</b></legend>
						<table width = '350px'>	
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>Nome </td>
								<td class='tdMDdinamico'><?php // echo $nomeAutor; ?>Informação visível apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Faixa Etária </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaImagem["faixaEtaria"]; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Email </td>
								<td class='tdMDdinamico'><?php // echo $emailAutor; ?>Informação visível apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Ranking </td>
								<td class='tdMDdinamico'>Ranking <?php  echo $nome_site; ?> </td>
							</tr>
							<?php 
							$num = $connection->query("SELECT *, @i := @i + 1 as result FROM usuario, (select @i := 0 ) temp ORDER BY pontos DESC" );
							if (!$num) {
								die('Invalid query num: ' . $connection->error);
							}							
							
							While ($num2 = $num->fetch_array()){
								if ($linhaDaConsultaImagem['codUsuario'] == $num2["codUsuario"])
									break ;								
							}
							$i  = $num2['result'];
							?>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Posição no Ranking </td>
								<td class='tdMDdinamico'><?php  echo $i; ?></td>
							</tr>							
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Escala do Ranking </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaImagem['nomeClasse'] ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>IP </td>
								<td class='tdMDdinamico'>Informação visível apenas para administradores.</td>
							</tr>
						</table>
					</fieldset>
				<?php }?>
				<?php  if ($consultaVideo->num_rows>0) {?>
					<fieldset>
						<legend><b>Autor VGI - Video</b></legend>
						<table width = '350px'>	
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>Nome </td>
								<td class='tdMDdinamico'><?php // echo $nomeAutor; ?>Informação visível apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Faixa Etária </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaVideo['faixaEtaria']; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Email </td>
								<td class='tdMDdinamico'><?php // echo $emailAutor; ?>Informação visível apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Ranking </td>
								<td class='tdMDdinamico'>Ranking <?php  echo $nome_site; ?> </td>
							</tr>
							<?php 
							$num = $connection->query("SELECT *, @i := @i + 1 as result FROM usuario, (select @i := 0 ) temp ORDER BY pontos DESC" );
							if (!$num) {
								die('Invalid query num: ' . $connection->error);
							}							
							
							While ($num2 = $num->fetch_array(y)){
								if ($linhaDaConsultaVideo['codUsuario'] == $num2["codUsuario"])
									break ;								
							}
							$i  = $num2['result'];
							?>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Posição no Ranking </td>
								<td class='tdMDdinamico'><?php  echo $i; ?></td>
							</tr>							
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Escala do Ranking </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaVideo['nomeClasse'] ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>IP </td>
								<td class='tdMDdinamico'>Informação visível apenas para administradores.</td>
							</tr>
						</table>
					</fieldset>
				<?php }?>
				<?php  if ($consultaArquivo->num_rows>0) {?>
					<fieldset>
						<legend><b>Autor VGI - Arquivo</b></legend>
						<table width = '350px'>	
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo' style='width:50%;'>Nome </td>
								<td class='tdMDdinamico'><?php // echo $nomeAutor; ?>Informação visível apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Faixa Etária </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaArquivo['faixaEtaria']; ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Email </td>
								<td class='tdMDdinamico'><?php // echo $emailAutor; ?>Informação visível apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Ranking </td>
								<td class='tdMDdinamico'>Ranking <?php  echo $nome_site; ?> </td>
							</tr>
							<?php 
							$num = $connection->query("SELECT *, @i := @i + 1 as result FROM usuario, (select @i := 0 ) temp ORDER BY pontos DESC" );
							if (!$num) {
								die('Invalid query num: ' . $connection->error);
							}							
							
							While ($num2 = $num->fetch_array()){
								if ($linhaDaConsultaArquivo['codUsuario'] == $num2["codUsuario"])
									break ;								
							}
							$i  = $num2['result'];
							?>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>Posição no Ranking </td>
								<td class='tdMDdinamico'><?php  echo $i; ?></td>
							</tr>							
							<tr bgcolor="<?php  echo $cor2; ?>">
								<td class='tdMDfixo'>Escala do Ranking </td>
								<td class='tdMDdinamico'><?php  echo $linhaDaConsultaArquivo['nomeClasse'] ?></td>
							</tr>
							<tr bgcolor="<?php  echo $cor1; ?>">
								<td class='tdMDfixo'>IP </td>
								<td class='tdMDdinamico'>Informação visível apenas para administradores.</td>
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