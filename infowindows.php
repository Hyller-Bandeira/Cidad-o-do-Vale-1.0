<!--
Event:
codCategoriaEvento = event_cod_cat_type		# SAME
codTipoEvento = event_cod_cat_type			# SAME
desTituloAssunto = event_desc_title_subj
dataOcorrencia = event_date_time				# SAME
horaOcorrencia = event_date_time				# SAME
desColaboracao = event_desc_colab
tipoStatus = event_type_status
codColaboracao = event_cod_colab_a & event_cod_colab_b
notaMedia = event_avg_grade
forum = event_forum
qtdVisualizacao = event_amount_vis
qtdAvaliacao = event_amount_grades
datahoraCriacao = event_datetime_creation

Image:
desTituloImagem = image_desc_title
endImagem = image_address
comentarioImagem = image_comment

Video:
desTituloVideo = video_desc_title
desUrlVideo = video_desc_url
comentarioVideo = video_comment

File:
comentarioArquivo = file_comment
tituloArquivo = file_desc_title
endArquivo = file_address
-->

<!-- PHP VALUES AND STUFF -->
<!-- I'm separating all the PHP code in here, storing it in some inputs so I can
	 easily access it from my javascript code, without mixing languages again -->
<?php
	// require 'funcoes.js.php';
	require 'phpsqlinfo_dbinfo.php';
?>

<input type='hidden' name='longitude_inicial' id='longitude_inicial' value='<?php echo $longitude_inicial; ?>'>
<input type='hidden' name='latitude_inicial' id='latitude_inicial' value='<?php echo $latitude_inicial; ?>'>
<input type='hidden' name='zoom_inicial' id='zoom_inicial' value='<?php echo $zoom_inicial; ?>'>
<input type='hidden' name='tipoMapa_inicial' id='tipoMapa_inicial' value='<?php echo $tipoMapa_inicial; ?>'>

<input type='hidden' name='name_user' id='name_user' value='<?php echo $_SESSION['name_user_'.$link_inicial]; ?>'>

<!-- Needed in the initialize() JS function -->
<?php
$ids_filtros = '';
if (isset($_POST["ids_filtros"]))
{?>
	<input type='hidden' name='ids_filtros' id='ids_filtros' value='<?php echo $_POST['ids_filtros']; ?>'>
<?php
}?>
<!-- END PHP VALUES -->

<script type="text/javascript" src="funcoes.js"></script>

<div class='balao' style='width: 550px; height: 500px;'>
	<div id='tabs'>
		<ul>
			<li><a href='#tab-1'><span>Dados</span></a></li>
			<li><a href='#tab-2'><span>Imagem</span></a></li>
			<li><a href='#tab-3'><span>Video</span></a></li>
			<li><a href='#tab-4'><span>Arquivo</span></a></li>
			<li><a href='#tab-5'><span>Forum</span></a></li>
			<li><a href='#tab-6'><span>Metadados</span></a></li>
		</ul>

		<div id='tab-1' class='balao'>
			<div class='centro'>
				<textarea id='event_desc_title_subj' rows='2' cols='55' maxlength='90' value='' name='new_title' id='new_title' readonly class='areatexto' style='text-align:center; font-weight:bold;'></textarea>
				<b id='event_cod_cat_type'></b>
				<br /><br />
				<center>
					<table>
						<tr>
							<td rowspan='2' style='padding-right: 20px;'> Data e Hora </td>
							<td>Ocorrência: </td>
							<td id='event_date_time'></td>
						</tr>
						<tr>
							<td style='padding-right: 20px'>Colaboração: </td>
							<td id='event_datetime_creation'></td>
						</tr>
					</table>
				</center>
				<br />

				<span id='save_button' style='display: none; cursor: pointer;'>
					<img src='imagens/check.png'><b>Salvar</b>
				</span>
				<span id='edit_button' style='display: block; cursor: pointer;' onclick='Edicao()'>
					<img src='imagens/add.png'><b>Editar</b>
				</span>

				<center>
					<ul id='mycarousel' class='jcarousel-skin-tango'>
						<li>
							<div name='colab_text' id='colab_text' style ='height: 75px; width: 330px; overflow: auto;'><span id='all_desc_a'></span></div>
							<textarea rows='5' cols='43' name='new_description' id='new_description' value='' style='resize: none; display: none;'><span id='all_desc_b'></span></textarea>
						</li>
					</ul>
					<br />
					<span id="event_type_status"></span>
				</center>
				<hr width='380px'>

					<!-- This form is hidden by default -->
					<form class='font1' style='display: none;' name='formularioNota' id='formularioNota' method='post' action=''>
						<label class='font2'><b>Avalie a Colaboração fornecendo uma nota de 0 a 5</b></label>
						<br /><br />
						<label>Nota:</label>
						<select name='nota' id='nota'>
							<option value=''>
							<option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
							<option value='5'>5</option>
						</select>
						<input type='button' class='SaveButton' id='botaoNota' value='Votar'/>
					</form>

					<!-- This div is hidden by default -->
					<div id='notaMedia' style='display: none;'>
						<center>
							<fieldset>
								<legend><b class='font2'>Estatísticas da colaboração</b></legend>
								<table>
									<tr>
										<td>Nota final: </td>
										<td id='event_avg_grade'></td>
									</tr>
									<tr>
										<td>Avaliações: </td>
										<td id='event_amount_grades'></td>
									</tr>
									<tr>
										<td>Visualizações: </td>
										<td id='event_amount_vis'></td>
									</tr>
								</table>
							</fieldset>
						</center>
					</div>

				</div>
			</div>
			<form name='frmFoto' id='frmFoto' action='phpsqlinfo_addrow_update.php' method='post' enctype='multipart/form-data' target='upload_target'>
				<input type='hidden' name='usuario_id_a' id='usuario_id_a' />
				<input type='hidden' name='codColaboracao_a' id='event_cod_colab_a' />
				<div id='tab-2' class='balao'>
					<p>
						<div align='center'>

							<!-- This div is hidden by default -->
							<div style='display: none;' id='tab-2-hidd' class='balao'>
								<div align='center' width='200px'>
									<div class= 'quebraLinha'><b><hr id='image_desc_title'><hr></b></div>
									<img id='image_address' aling='center' width='300' height='200' border='1'>

									<!-- This span is hidden by default -->
									<span type='hidden' id='hascomment'>
										<br /><br />
										<textarea id='image_comment' rows='4' cols='40' readonly></textarea>
									<span>
								</div>
							</div>

							<!-- This table is hidden by default -->
							<table id='noimg' style='display: none;'>
								<tr>
									<td>Enviar Imagem</td>
									<td><input type='file' name='Imagem' id='Imagem' /></td>
								</tr>
								<tr>
									<td>Título da Imagem</td>
									<td><input class='form5' type='text' name='desTituloImagem' id='desTituloImagem'/></td>
								</tr>
							</table>

							<br />
							<table>
								<tr><td class='font1'>Comentário da Imagem (Opcional)</td></tr>
								<tr><td><textarea rows='4' cols='25' class='form4' name='comentImagem' id='comentImagem'/></textarea></td></tr>
								<tr><td></td></tr>
								<tr><td class='centro'><input type='submit' class='SaveButton' value='Enviar Imagem' class='sbtn' name='Enviar'></td></tr>
							</table>
						</div>
					</p>
				</div>
				<div id='tab-3' class='balao'>
					<p>
						<div align='center'>

							<!-- This div is hidden by default -->
							<div type='hidden' id='tab-3-hidd' class='balao'>
							<!-- <div id='tab-3' class='balao'> -->
								<div align='center'>
									<div class='quebraLinha'><b><hr id='video_desc_title'><hr></b></div>
									<embed id='video_desc_url' width='350' height='200' type='application/x-shockwave-flash'></embed>

									<!-- This span is hidden by default -->
									<span style='display: none;' id='hascommentvid'>
										<br /><br />
										<textarea id='video_comment' rows='4' cols='42' readonly></textarea>
									</span>

									<br /><br />
									Em caso de falhas na exibição <a id='video_fail' target='_blank'>clique aqui</a> para assistir
								</div>
							</div>

							<!-- This span is hidden by default -->
							<span id='novideo' style='display: none;'>
								<table>
									<tr><td>Título do Video</td> <td><input class='form' type='text' name='desTituloVideo' id='desTituloVideo'/> </td> </tr>
									<tr><td>URL do Video</td> <td><input class='form' type='text' name='desUrlVideo' id='desUrlVideo'/> </td> </tr>
									<tr></tr><tr></tr><tr></tr><tr></tr>
								</table>
								<br />
								<table>
									<tr><td class='font1'>Comentário do Vídeo (Opcional)</td></tr>
									<tr><td><textarea rows='4' cols='25' class='form4' name='comentVideo' id='comentVideo' ></textarea></td></tr>
									<tr><td></td></tr>
									<tr><td class='centro'><input type='submit' class='SaveButton' value='Enviar Video' class='sbtn' name='Enviar'></td></tr>
								</table>
							</span>

						</div>
					</p>
				</div>
				<div id='tab-4' class='balao'>
					<p>
						<div align='center'>

							<!-- This div is hidden by default -->
							<div type='hidden' id='tab-4-hidd' class='balao'>
								<div align='center'>
									<div class= 'quebraLinha'><b><hr id='file_desc_title'><hr></b></div>

										<!-- This textarea is hidden by default -->
										<textarea type='hidden' id='file_comment' rows='7' cols='42' readonly></textarea>

										<br /><br />
										<hr><b>Para baixar o arquivo clique no ícone abaixo</b>
										<br />
										<a id='file_address' target='_blank'><img src='imagens/baixar.png'/></a>
										<br /><br />
								</div>
							</div>

							<!-- This table is hidden by default -->
							<table type='hidden' id='nofile'>
								<tr><td>Enviar Arquivo</td> <td><input type='file' name='arquivo' id='arquivo' /></td></tr>
								<tr><td>Título do Arquivo</td> <td><input class='form5' type='text' name='desArquivo' id='desArquivo'/> </td> </tr>
							</table>
							<br />
							<table>
								<tr><td class='font1'>Comentário do Arquivo (Opcional)</td></tr>
								<tr><td><textarea rows='4' cols='25' class='form4' name='comentArq' id='comentArq'/></textarea></td></tr>
								<tr></tr><tr></tr><tr></tr><tr></tr>
								<tr><td class='centro'><input type='submit' class='SaveButton' value='Enviar Arquivo' class='sbtn'  name='Enviar'></td></tr></table>
							</table>

						</div>
					</p>
				</div>
			</form>
		<div id='tab-5' class='balao'>
			<center>
				<h4 align='center'>Comentários Adicionados</h4>
				<hr><div id='event_forum' class='comentario'></div><hr>
			</center>
			<form name='Comentario' id='Comentario'>
				<table align='center'>
					<tr><td class='font1'>Adicionar Comentário</tr></td>
					<tr><td><input type='hidden' name='usuario_id_b' id='usuario_id_b' /></tr></td>
					<tr><td><input type='hidden' name='codColaboracao' id='event_cod_colab_b' /></tr></td>
					<tr><td><textarea class='form4' rows='4' cols='45' value='' name = 'desComentario' id = 'desComentario' > </textarea></tr></td>
					<tr><td class='centro'><input type = 'button' class='SaveButton' class='sbtn' value='Enviar Comentário' name = 'Enviar' onclick='loadXMLDoc2();' /></tr></td>
				</table>
			</form>
		</div>
		<div id='tab-6' class='balao'><span id='metadados' name='metadados'></span></div>
	</div>
</div>