<?php
	header('content-type: text/html; charset=utf-8');
	require 'phpsqlinfo_dbinfo.php';

	$codColaboracao = '';
	if(isset($_GET['id'])) $codColaboracao = $_GET['id'];	//Codigo da colaboração recebida pela função

	//Tabela: COLABORACAO: Consulta para pegar todos os dados da colaboração
	$consulta = $connection->query("SELECT * FROM  colaboracao WHERE codColaboracao = '$codColaboracao' ");
	if (!($linhaDaConsulta = $consulta->fetch_assoc()))
	{
		echo 'Erro na consulta: Não foi encontrado a colaboração com código: ' . $codColaboracao;
		exit;
	}

	$titulo = $linhaDaConsulta['desTituloAssunto'];
	$dataHoraCriacao = $linhaDaConsulta['datahoraCriacao'];
	$dataHoraOcorrencia = $linhaDaConsulta['dataHoraOcorrencia'];
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
	if (!($linhaDaConsulta2 = $consulta2->fetch_assoc()))
	{
		echo "Erro na consulta 2: Não foi encontrado a categoria com código: ".$codigoCategoria;
		exit;
	}
	$categoria = $linhaDaConsulta2['desCategoriaEvento'];
    $tipo = '';
	$codigoTipo = $linhaDaConsulta['codTipoEvento'];
    if (!empty($codigoTipo)) {
        //Tabela: TIPOEVENTO: Consulta para pegar o nome do tipo de código $codigoTipo
        $consulta3 = $connection->query("SELECT desTipoEvento FROM tipoevento WHERE codTipoEvento = '$codigoTipo' ");
        if (!($linhaDaConsulta3 = $consulta3->fetch_assoc()))
        {
            echo 'Erro na consulta 3: Não foi encontrado o tipo com código: '.$codigoTipo;
            exit;
        }
        $tipo = $linhaDaConsulta3['desTipoEvento'];
    }

	//Tabela ESTATISTICA: Consulta para pegar o numero de visualizacoes de determinada colaboração
	$consulta4 = $connection->query("SELECT * FROM estatistica WHERE codColaboracao = '$codColaboracao' ");
	if (!($linhaDaConsulta4 = $consulta4->fetch_assoc()))
	{
		echo "Erro na consulta 4: Não foi encontrada a colaboração com código: ".$codColaboracao;
		exit;
	}
	$numeroVisualizacao = $linhaDaConsulta4['qtdVisualizacao'];
	$numeroAvaliacao = $linhaDaConsulta4['qtdAvaliacao'];
	$notaFinal = $linhaDaConsulta4['notaMedia'];

	//Tabela HISTORICOCOLABORACOES: Consulta para pegar a data e hora das atualizações na tabela de histórico
	$consulta5 = $connection->query("SELECT * FROM historicocolaboracoes WHERE codColaboracao = '$codColaboracao' ");
	if(!($linhaDaConsulta5 = $consulta5->fetch_assoc()))
	{
		echo "Erro na consulta 5: Não foi encontrado alterações na colaboração com código: " . $codColaboracao;
		exit;
	}
	$numRevisoes = $consulta5->num_rows - 1;	//Subtrai 1 pois quando a colaboração é criada ela é gravada nessa tabela, ou seja, ela ainda não foi editada mas existe uma linha com seus dados

	//Tabela COMENTARIO: Consulta para pegar informações de histórias de usuário
	$consulta8 = $connection->query("SELECT * FROM comentario
							  INNER JOIN usuario ON (usuario.codUsuario = comentario.codUsuario)
							  INNER JOIN classesdeusuarios ON (usuario.classeUsuario = classesdeusuarios.codClasse)
							  WHERE codColaboracao = '$codColaboracao' ");

	$consulta9 = $connection->query("SELECT *, count(historicocolaboracoes.codUsuario) FROM historicocolaboracoes
							  INNER JOIN usuario ON (usuario.codUsuario = historicocolaboracoes.codUsuario)
							  INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
							  WHERE codColaboracao = '$codColaboracao' GROUP BY historicocolaboracoes.codUsuario having count(historicocolaboracoes.codUsuario)> 0");
	if($consulta9->num_rows < 1)
	{
		echo "Erro na consulta 9: Não foi encontrado alterações na colaboração com código: ".$codColaboracao;
		exit;
	}
	$numRevisores = $consulta9->num_rows - 1;//Subtrai 1 pois o autor não conta como revisor

	$consultaImagem = $connection->query("SELECT * FROM multimidia
								   INNER JOIN usuario ON (usuario.codUsuario = multimidia.codUsuario)
								   INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
								   WHERE codColaboracao = '$codColaboracao'");
	if ($linhaDaConsultaImagem = $consultaImagem->fetch_assoc())
	{
		$desTituloImagem = $linhaDaConsultaImagem["desTituloImagem"];
		$comentarioImagem = $linhaDaConsultaImagem["comentarioImagem"];
		$endImagem = $linhaDaConsultaImagem["endImagem"];
		list($widthImagem, $heightImagem, $typeImagem, $attrImagem) = getimagesize("imagensenviadas/$endImagem");
		$infoImagem = pathinfo("imagensenviadas/$endImagem");
	}

	$consultaVideo = $connection->query("SELECT * FROM videos
								  INNER JOIN usuario ON (usuario.codUsuario = videos.codUsuario)
								  INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
								  WHERE codColaboracao = '$codColaboracao'");
	if ($linhaDaConsultaVideo = $consultaVideo->fetch_assoc())
	{
		$desTituloVideo = $linhaDaConsultaVideo["desTituloVideo"];
		$comentarioVideo = $linhaDaConsultaVideo["comentarioVideo"];
		$desUrlVideo = $linhaDaConsultaVideo["desUrlVideo"];
	}

	$consultaArquivo = $connection->query("SELECT * FROM arquivos
									INNER JOIN usuario ON (usuario.codUsuario = arquivos.codUsuario)
									INNER JOIN classesdeusuarios ON (classesdeusuarios.codClasse = usuario.classeUsuario)
									WHERE codColaboracao = '$codColaboracao'");
	if ($linhaDaConsultaArquivo = $consultaArquivo->fetch_assoc())
	{
		$desArquivo = $linhaDaConsultaArquivo["desArquivo"];
		$comentarioArquivo = $linhaDaConsultaArquivo["comentarioArquivo"];
		$endArquivo = $linhaDaConsultaArquivo["endArquivo"];
		$infoArquivo = pathinfo("arquivos/$endArquivo");
	}


	//Tamanho da linha vertical do layout <hr>
	$tamanhoLinha = "350px";

	//Cores das linhas da tabela
	$cor2 = "#e3e3e3";
	$cor1 = "#ffffff";
	$cor3 = "#e0e0e0";
?>
<link rel="stylesheet" href="style/metadados.css" type="text/css" media="all" />

<!DOCTYPE html>
<html>
	<body>
		<div class='centro' style="width:500px; height:400px; overflow:auto;">
			<strong>Template usado: DM4VGI - Dynamic Metadata for VGI</strong>
			<br />
			<br />
			<div class="cabecalhoMD" ><strong>Identificação</strong></div>
			<br />
			<table width = '440px' style="margin: 0px auto;">
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo'  style='width:35%;'>Título</td>
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
                <?php if (!empty($tipo)) : ?>
                    <tr bgcolor="<?php  echo $cor2; ?>">
                        <td class='tdMDfixo'>Tipo</td>
                        <td class='tdMDdinamico'><?php  echo $tipo; ?></td>
                    </tr>
                <?php endif; ?>
				<tr bgcolor="<?php  echo $cor2; ?>">
					<td class='tdMDfixo'>Software</td>
					<td class='tdMDdinamico'><?php  echo $nome_site; ?> </td>
				</tr>
				<tr bgcolor="<?php  echo $cor1; ?>">
					<td class='tdMDfixo'>Website</td>
					<td class='tdMDdinamico'><a href="<?php  echo $link_inicial; ?>" alt="<?php  echo $nome_site; ?> " title="<?php  echo $nome_site; ?> " target="_blank"><?php  echo $link_inicial; ?></a></td>
				</tr>
			</table>
			<br />
			<div class="cabecalhoMD" ><strong>Registro Temporal</strong></div>
			<br />
			<fieldset style="margin: 0px auto;">
				<span><strong>Data e Hora</strong></span>
				<table width = '440px' align ='center' style="margin: 0px auto;">
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo'  style='width:35%;'> Contribuição </td>
						<td class='tdMDdinamico'><?php  echo date('d/m/Y - H:i:s', strtotime($dataHoraCriacao)); ?></td>
					</tr>
					<tr bgcolor="<?php  echo $cor2; ?>">
						<td class='tdMDfixo'> Ocorrência </td>
						<td class='tdMDdinamico'>
						<?php
							if(!empty($dataHoraOcorrencia)) {
                                echo date('d/m/Y - H:i:s', strtotime($dataHoraOcorrencia));
                            }
							else {
                                echo "Não possui data e hora de ocorrência";
                            }
						?>
						</td>
					</tr>
					<tr bgcolor="<?php echo $cor1; ?>">
						<?php $aux = $consulta5->num_rows; ?>
						<td class='tdMDfixo' rowspan = '<?php echo ($aux);?>'> Atualizações </td>
						<?php if($aux == 1) echo "<td class='tdMDdinamico'>Não houve Atualização</td>";?>
					</tr>

					<?php
						$aux = 0;
						while($linhaDaConsulta5 = $consulta5->fetch_assoc())
						{
							$aux++;
					?>
							<tr bgcolor="<?php echo $cor1; ?>">
							<td class='tdMDdinamico' >
							<?php echo date('d/m/Y - H:i:s', strtotime($linhaDaConsulta5['datahoraModificacao'])); ?>
							</td>
							</tr>
					<?php
						}
					?>
				</table>
			</fieldset>
			<br />
			<div class="cabecalhoMD" ><strong>Geoposicionamento</strong></div>
			<br />
			<fieldset style="margin: 0px auto;"><span><strong> Retângulo Envolvente </strong></span>
				<table align='center' style="margin: 0px auto;" >
					<tr align='center'>
						<td colspan = '3'   ><strong>Norte</strong></td>
					</tr>
					<tr align='center'>
						<td colspan = '3'  ><?php  echo $norte; ?></td>
					</tr>

					<tr align='center'>
						<td ><strong>Oeste</strong></td>
						<td style='padding-left: 100px;'></td>
						<td ><strong>Leste</strong></td>
					</tr>

					<tr align='center'>
						<td  ><?php  echo $oeste; ?></td>
						<td style='padding-left: 50px;'></td>
						<td  ><?php  echo $leste; ?></td>
					</tr>

					<tr align='center'>
						<td colspan = '3'><strong>Sul</strong></td>
					</tr>
					<tr align='center'>
						<td colspan = '3'><?php echo $sul; ?></td>
					</tr>
				</table>

			</fieldset>
			<br />
			<table width='440px' style="margin: 0px auto;">
				<tr bgcolor="<?php echo $cor1; ?>">
					<td class='tdMDfixo' style='width:50%;' >Tipo de Geometria</td>
					<td class='tdMDdinamico' colspan='2'> Ponto</td>
				</tr>
			</table>
			<br />
			<div class="cabecalhoMD" ><strong>Qualidade da VGI</strong></div>
			<br />

			<fieldset style="margin: 0px auto;">
				<span><strong>Histórico de Colaboração</strong></span>
				<table width = '440px' style="margin: 0px auto;">
					<?php
						$aux = 0;
						$consulta5 = $connection->query("SELECT * FROM historicocolaboracoes WHERE codColaboracao = '$codColaboracao' ");
						while($linhaDaConsulta5 = $consulta5->fetch_assoc())
						{
							if($aux == 0)
							{?>
								<tr>
									<td class='tdMDfixo' >Título</td>
									<td class='tdMDfixo' >Descrição</td>
									<td class='tdMDfixo' >Data e Hora</td>
								<tr>
							<?php
							}
							$aux++;
							if ($consulta5->num_rows == $aux) break;
							?>
							<tr bgcolor="<?php  if(($aux%2)==0) echo  $cor2; else echo $cor1; ?>">
								<td class='tdMDdinamico' style = 'text-align:center;'>
									<?php echo $linhaDaConsulta5['desTitulo']; ?>
								</td>
								<td class='tdMDdinamico' style = 'text-align:center;'>
									<?php echo $linhaDaConsulta5['desColaboracao']; ?>
								</td>
								<td class='tdMDdinamico' style = 'text-align:center;'>
									<?php echo $linhaDaConsulta5['datahoraModificacao']; ?>
								</td>
							</tr>
						<?php
						}
						if($aux == 0) echo "Não houve revisões Wiki";
						?>
				</table>
			</fieldset>
            <br>
			<fieldset style="margin: 0px auto;">
				<span><strong>Número de Wiki</strong></span>
				<table width = '440px' style="margin: 0px auto;">
					<tr bgcolor="<?php  echo $cor1; ?>">
						<td class='tdMDfixo' style='width:50%;'>Revisões </td>
						<td class='tdMDdinamico'><?php echo $numRevisoes; ?></td>
					</tr>
					<tr bgcolor="<?php  echo $cor2; ?>">
						<td class='tdMDfixo'>Revisores distintos </td>
						<td class='tdMDdinamico'><?php echo $numRevisores; ?></td>
					</tr>
				</table>
			</fieldset>
            <br>
			<fieldset style="margin: 0px auto;">
				<span><strong>Histórias de Usuários</strong></span>
				<table width = '440px' style="margin: 0px auto;">

				<?php
					$aux1 = 0;
					while($linhaDaConsulta8 = $consulta8->fetch_assoc())
					{
						if($aux1 == 0)
						{?>
							<tr>
								<td class='tdMDfixo' style='width:33.33%; padding-left: 15px;' >Usuário</td>
								<td class='tdMDfixo' style='width:33.33%; padding-left: 15px;' >Pontos do Usuário</td>
								<td class='tdMDfixo' style='width:33.33%; padding-left: 15px;' >Data e Hora</td>
							<tr>
						<?php
						}
						$aux1++;
						?>
						<tr bgcolor="<?php  if(($aux1%2)==0) echo  $cor2; else echo $cor1; ?>">
							<td class='tdMDdinamico' style = 'text-align:center; max-width: 200px;'>
								<?php
								echo $linhaDaConsulta8['apelidoUsuario'];
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
						</tr>
				<?php
					}
					if($aux1 == 0) echo "Não possui histórias de usuários.";
				?>
				</table>
			</fieldset>
            <br>
			<fieldset style="margin: 0px auto;">
				<span><strong>Pontuação</strong></span>
				<table width='440px' style="margin: 0px auto;">
					<tr bgcolor="<?php echo $cor1; ?>">
						<td class='tdMDfixo' style='width:35%;'>Nota Final </td>
						<td class='tdMDdinamico'><?php  echo $notaFinal; ?></td>
					</tr>
					<tr bgcolor="<?php echo $cor2; ?>">
						<td class='tdMDfixo'>Valor Mínimo </td>
						<td class='tdMDdinamico'>0</td>
					</tr>
					<tr bgcolor="<?php echo $cor1; ?>">
						<td class='tdMDfixo'>Valor Máximo </td>
						<td class='tdMDdinamico'>5</td>
					</tr>
				</table>
			</fieldset>
			<br />
			<table width='440px' style="margin: 0px auto;">
				<tr bgcolor="<?php echo $cor1; ?>">
					<td class='tdMDfixo' style='width:35%;'>Número de Avaliações</td>
					<td class='tdMDdinamico'><?php echo $numeroAvaliacao; ?></td>
				</tr>
				<tr bgcolor="<?php echo $cor2; ?>">
					<td class='tdMDfixo' >Número de Visualizações</td>
					<td class='tdMDdinamico'><?php echo $numeroVisualizacao; ?></td>
				</tr>
				<tr bgcolor="<?php echo $cor1; ?>">
					<td class='tdMDfixo'>Status</td>
					<td class='tdMDdinamico'><?php echo $status; ?></td>
				</tr>
				<tr bgcolor="<?php echo $cor2; ?>">
					<td class='tdMDfixo'>Método de Avaliação</td>
					<td class='tdMDdinamico'>Média ponderada baseada em hierarquia de usuários.</td>
				</tr>
				<tr bgcolor="<?php echo $cor1; ?>">
					<td class='tdMDfixo'>Zoom Colaboração</td>
					<td class='tdMDdinamico'>Nível <?php echo $zoomColaboracao; ?> de Zoom da Google Maps API</td>
				</tr>
			</table>
			<br />

			<div class="cabecalhoMD" ><strong>Multimídia</strong></div>
				<br />
				<fieldset style="margin: 0px auto;">
					<span><strong>Imagem</strong></span>
					<?php
						if ($consultaImagem->num_rows > 0)
						{?>
							<table width = '440px' style="margin: 0px auto;">
								<tr bgcolor="<?php echo $cor1; ?>">
									<td class='tdMDfixo' style='width:35%;'>Título</td>
									<td class='tdMDdinamico'><?php echo $desTituloImagem; ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor2; ?>">
									<td class='tdMDfixo' >Descrição</td>
									<td class='tdMDdinamico'><?php echo $comentarioImagem; ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor1; ?>">
									<td class='tdMDfixo'>Nome do arquivo</td>
									<td class='tdMDdinamico'><?php echo $infoImagem['filename']; ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor2; ?>">
									<td class='tdMDfixo'>Tamanho</td>
									<td class='tdMDdinamico'><?php echo filesize("arquivos/$endArquivo") . ' bytes'; ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor1; ?>">
									<td class='tdMDfixo'>Formato</td>
									<td class='tdMDdinamico'><?php echo image_type_to_mime_type($typeImagem); ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor2; ?>">
									<td class='tdMDfixo'>Resolução</td>
									<td class='tdMDdinamico'><?php echo $attrImagem; ?></td>
								</tr>
							</table>
						<?php
						}
						else echo "<table width = '440px' style='margin: 0px auto;'><tr><td align = 'center'>Colaboração sem imagem ou foto</td></tr></table>";
					?>

				</fieldset>
                <br>
				<fieldset style="margin: 0px auto;">
					<span><strong>Video</strong></span>
					<?php
						if ($consultaVideo->num_rows > 0)
						{?>
							<table width = '440px' style="margin: 0px auto;">
								<tr bgcolor="<?php echo $cor1; ?>">
									<td class='tdMDfixo' style='width:35%;'>Título</td>
									<td class='tdMDdinamico'><?php echo $desTituloVideo; ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor2; ?>">
									<td class='tdMDfixo' >Descrição</td>
									<td class='tdMDdinamico'><?php echo $comentarioVideo; ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor1; ?>">
									<td class='tdMDfixo'>Link de acesso</td>
									<td class='tdMDdinamico'><?php echo "<a href=http://www.youtube.com/watch?v=$desUrlVideo> http://www.youtube.com/watch?v=$desUrlVideo </a>"; ?></td>
								</tr>
							</table>
						<?php
						}
						else echo "<table width = '380px' style='margin: 0px auto;'><tr><td align = 'center'>Colaboração sem URL de Video</td></tr></table>";
					?>
				</fieldset>
                <br>
				<fieldset style="margin: 0px auto;">
					<span><strong>Arquivo</strong></span>
					<?php
						if ($consultaArquivo->num_rows > 0)
						{?>
							<table width = '440px' style="margin: 0px auto;">
								<tr bgcolor="<?php echo $cor1; ?>">
									<td class='tdMDfixo' style='width:35%;'>Título</td>
									<td class='tdMDdinamico'><?php echo $desArquivo; ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor2; ?>">
									<td class='tdMDfixo' >Descrição</td>
									<td class='tdMDdinamico'><?php echo $comentarioArquivo; ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor1; ?>">
									<td class='tdMDfixo'>Nome do arquivo</td>
									<td class='tdMDdinamico'><?php echo $infoArquivo['filename']; ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor2; ?>">
									<td class='tdMDfixo'>Tamanho</td>
									<td class='tdMDdinamico'><?php echo filesize("imagensenviadas/$endImagem") . ' bytes'; ?></td>
								</tr>
								<tr bgcolor="<?php echo $cor1; ?>">
									<td class='tdMDfixo'>Formato</td>
									<td class='tdMDdinamico'><?php echo $infoArquivo['extension']; ?></td>
								</tr>
							</table>
						<?php
						}
						else echo "<table width = '440px' style='margin: 0px auto;'><tr><td align = 'center'>Colaboração sem arquivos Extras</td></tr></table>";
					?>
				</fieldset>

			<br />
			<div class="cabecalhoMD" ><strong>Autoria e Distribuição</strong></div>
			<br />
			<fieldset style="margin: 0px auto;">
				<span><strong>Autores VGI</strong></span><br>
				<?php
					while($linhaDaConsulta9 = $consulta9->fetch_assoc())
					{?>

					<fieldset style="margin: 0px auto;">
						<span><strong>Autor VGI - Aba principal</strong></span>
						<table width = '440px' style="margin: 0px auto;">
							<tr bgcolor="<?php echo $cor1; ?>">
								<td class='tdMDfixo' style='width:35%;'>Nome </td>
								<td class='tdMDdinamico'>Informação visível apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php echo $cor2; ?>">
								<td class='tdMDfixo'>Faixa Etária </td>
								<td class='tdMDdinamico'><?php echo $linhaDaConsulta9['faixaEtaria']; ?></td>
							</tr>
							<tr bgcolor="<?php echo $cor1; ?>">
								<td class='tdMDfixo'>Email </td>
								<td class='tdMDdinamico'>Informação visível apenas para administradores.</td>
							</tr>
							<tr bgcolor="<?php echo $cor2; ?>">
								<td class='tdMDfixo'>Ranking </td>
								<td class='tdMDdinamico'>Ranking <?php echo $nome_site; ?> </td>
							</tr>
							<?php
								$num = $connection->query("SELECT *, @i := @i + 1 as result FROM usuario, (select @i := 0 ) temp ORDER BY pontos DESC" );
								if (!$num)
								{
									die('Invalid query num: ' . $connection->error);
								}

								While ($num2 = $num->fetch_array())
								{
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
					<?php
					}
					if ($consultaImagem->num_rows > 0)
					{?>
                        <br>
                        <fieldset style="margin: 0px auto;">
							<span><strong>Autor VGI - Imagem</strong></span>
							<table width = '440px ' style="margin: 0px auto;">
								<tr bgcolor="<?php  echo $cor1; ?>">
									<td class='tdMDfixo' style='width:35%;'>Nome </td>
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
									if (!$num)
									{
										die('Invalid query num: ' . $connection->error);
									}

									While ($num2 = $num->fetch_array())
									{
										if ($linhaDaConsultaImagem['codUsuario'] == $num2["codUsuario"])
											break ;
									}
									$i = $num2['result'];
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
					<?php
					}
					if ($consultaVideo->num_rows > 0)
					{?>
                        <br>
                        <fieldset style="margin: 0px auto;">
							<span><strong>Autor VGI - Video</strong></span>
							<table width = '440px' style="margin: 0px auto;">
								<tr bgcolor="<?php  echo $cor1; ?>">
									<td class='tdMDfixo' style='width:35%;'>Nome </td>
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
									if (!$num)
									{
										die('Invalid query num: ' . $connection->error);
									}

									While ($num2 = $num->fetch_array())
									{
										if ($linhaDaConsultaVideo['codUsuario'] == $num2["codUsuario"])
											break ;
									}
									$i = $num2['result'];
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
					<?php
					}
					if ($consultaArquivo->num_rows > 0)
					{?>
                        <br>
                        <fieldset style="margin: 0px auto;">
							<span><strong>Autor VGI - Arquivo</strong></span>
							<table width = '440px' style="margin: 0px auto;">
								<tr bgcolor="<?php  echo $cor1; ?>">
									<td class='tdMDfixo' style='width:35%;'>Nome </td>
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
									if (!$num)
									{
										die('Invalid query num: ' . $connection->error);
									}

									While ($num2 = $num->fetch_array())
									{
										if ($linhaDaConsultaArquivo['codUsuario'] == $num2["codUsuario"])
											break ;
									}
									$i = $num2['result'];
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
					<?php
					}
				?>
			</fieldset>
            <br>
			<fieldset style="margin: 0px auto;">
				<span><strong>Distribuidor VGI</strong></span>
				<table width = '440px' style="margin: 0px auto;">
					<tr bgcolor="<?php echo $cor1; ?>">
						<td class='tdMDfixo' style='width:35%;'>Nome </td>
						<td class='tdMDdinamico'><?php echo $nome_site ?></td>
					</tr>
					<tr bgcolor="<?php echo $cor2; ?>">
						<td class='tdMDfixo'>Email </td>
						<td class='tdMDdinamico'><a href="mailto:<?php echo $email_site; ?>"><?php echo $email_site; ?></a></td>
					</tr>
					<tr bgcolor="<?php echo $cor1; ?>">
						<td class='tdMDfixo'>Site </td>
						<td class='tdMDdinamico'><a href="<?php echo $link_inicial; ?>" alt="<?php echo $nome_site; ?> " title="<?php echo $nome_site; ?> " target="_blank"><?php echo $link_inicial; ?></a></td>
					</tr>
					<tr bgcolor="<?php echo $cor2; ?>">
						<td class='tdMDfixo'>IP </td>
						<td class='tdMDdinamico'>200.235.131.170</td>
					</tr>
				</table>
			</fieldset>
			<br />
			<table width = '440px' style="margin: 0px auto;">
				<tr bgcolor="<?php echo $cor1; ?>">
					<td class='tdMDfixo' style='width:35%;'>Link de Download ou Acesso </td>
					<td class='tdMDdinamico'><a href="<?php echo $link_inicial; ?>/" alt="<?php echo $nome_site; ?>" title="<?php echo $nome_site; ?>" target="_blank"><?php echo $link_inicial; ?></a></td>
				</tr>
			</table>
			<br />
		</div>
	</body>
</html>