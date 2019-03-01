<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places,visualization"></script>
	<script type="text/javascript" src="../src/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
	<script type="text/javascript" src="../src/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
			
	
	<script type="text/javascript" src="../src/jquery.blockUI.js"></script>		
	<script type="text/javascript" src="../links.js"></script>
	<script SRC="../src/util.js"></script>

		<script  type="text/javascript">
			function abrir(URL) {  
				var width = 150;  
				var height = 250;  
				var left = 99;  
				var top = 99;  
				window.open(URL,'janela', 'width='+width+', height='+height+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no'); 
			}
				
				function mostrarColaboracao(id){
					enviar(id);
				}

			
		function salvar(){
			var novoStatus  = document.getElementById('jform_status').value;
			var justificativa  = document.getElementById('jform_justificativa').value;
			var enviaEmail = document.getElementById('jform_envia_email0').checked;
			var id  = document.getElementById('id').value;
			var cga  = document.getElementById('cga').value;
			var tpa  = document.getElementById('tpa').value;
			var sta  = document.getElementById('sta').value;
			var email  = document.getElementById('jform_email').value;
			var nome  = document.getElementById('jform_nomeusuario').value;
			
			
			if(novoStatus == 'padrao')
				alert("Informe status para a colaboração");
			else{
				window.location.href = "avalia_colaboracao.php?novoStatus=" + novoStatus
				+ "&justificativa=" + justificativa
				+ "&enviaEmail=" + enviaEmail
				+ "&id=" + id
				+ "&cga=" + cga
				+ "&sta=" + sta
				+ "&tpa=" + tpa
				+ "&email=" + email
				+ "&nome=" + nome;
			}
		}
		</script>
		<?php 
		
		$id = '';
		$cga = '';
		$tpa = '';
		$sta = '';
		
		if(isset($_GET['id'])) $id = $_GET['id'];
		if(isset($_GET['cga'])) $cga = $_GET['cga'];
		if(isset($_GET['tpa'])) $tpa = $_GET['tpa'];
		if(isset($_GET['sta'])) $sta = $_GET['sta'];
		
		//Consultas SQL
		$consulta = mysql_query("SELECT * FROM colaboracao WHERE codColaboracao = '$id'");
		if(!($linhaDaConsulta = mysql_fetch_assoc($consulta))){
			echo "Erro na consulta : Não foi encontrado dados na tabela colaboracao";
			exit;
		}
		
		$codUsuario = $linhaDaConsulta['codUsuario'];
		$consulta3 = mysql_query("SELECT * FROM usuario WHERE codUsuario = '$codUsuario'");
		if(!($linhaDaConsulta3 = mysql_fetch_assoc($consulta3))){
			echo "Erro na consulta : Não foi encontrado dados na tabela usuario";
			exit;
		}
		$codigoClasse = $linhaDaConsulta3['classeUsuario'];
		
		$consulta4 = mysql_query("SELECT * FROM classesdeusuarios WHERE codClasse = '$codigoClasse'");
		if(!($linhaDaConsulta4 = mysql_fetch_assoc($consulta4))){
			echo "Erro na consulta : Não foi encontrado dados na tabela classesdeusuarios";
			exit;
		}
		
		$consulta5 = mysql_query("SELECT * FROM multimidia WHERE codColaboracao = '$id'");
		$numImagem = mysql_num_rows($consulta5);
		
		$consulta8 = mysql_query("SELECT * FROM videos WHERE codColaboracao = '$id'");
		$numVideo = mysql_num_rows($consulta8);
		
		$consulta11 = mysql_query("SELECT * FROM arquivos WHERE codColaboracao = '$id'");
		$numArquivo = mysql_num_rows($consulta11);
		
		$consulta14 = mysql_query("SELECT * FROM estatistica WHERE codColaboracao = '$id'");
		if(!($linhaDaConsulta14 = mysql_fetch_assoc($consulta14))){
			echo "Erro na consulta : Não foi encontrado dados na tabela estatistica";
			exit;
		}
		
		require ("cabecalho.php");
		require ("menu.php");?>
		<?php 
		require("../index.js.php");
		?>
		<div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
					<ul>						
						<li class="button" id="toolbar-apply">
						<a href="#" onclick="salvar()" class="toolbar">
							<span class="icon-32-apply"></span>
							Avaliar
						</a>
						</li>

						<li class="divider"></li>

						<li class="button" id="toolbar-cancel">
							<a href="listar_colaboracoes.php?cga=<?php  echo $cga; ?>&tpa=<?php  echo $tpa; ?>&sta=<?php  echo $sta; ?>" class="toolbar">
							<span class="icon-32-cancel"></span>
							Cancelar
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-checkin"><h2>Avaliar Colaboração</h2></div>
			</div>
		</div>
		
		<div id="element-box">
			<div class="m">
				<form action="#" id="application-form" method="post" name="adminForm" class="form-validate">
					<div id="config-document">
						<div id="page-site" class="tab" style="display: block;">
							<div class="noshow">
								<div class="width-60 fltlft">
									<div class="width-100">
										<fieldset class="adminform">
											<legend>Informações da Colaboração</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_titulocolaboracao-lbl" for="jform_titulocolaboracao" class="hasTip required" title="" aria-invalid="false">Título</label>					
													<input type="text" name="jform[titulocolaboracao]" id="jform_titulocolaboracao" value="<?php  echo $linhaDaConsulta['desTituloAssunto'] ?>" readonly="readonly" size="70" class="required"aria-required="true" required="required" aria-invalid="false">
													<input type="hidden" name="id" id="id" value="<?php  echo $id; ?>">
													<input type="hidden" name="cga" id="cga" value="<?php  echo $cga; ?>">
													<input type="hidden" name="tpa" id="tpa" value="<?php  echo $tpa; ?>">
													<input type="hidden" name="sta" id="sta" value="<?php  echo $sta; ?>">
												</li>
												
												<li>
													<label id="jform_descricao-lbl" for="jform_descricao" class="hasTip" title="" aria-invalid="false">Descrição</label>					
													<textarea name="jform[descricao]" id="jform_descricao" cols="60" rows="4" class="required" aria-required="true" required="required" aria-invalid="false" style="width: 305px;" readonly="readonly"><?php  echo $linhaDaConsulta['desColaboracao'] ?></textarea>
												</li>
												
												<li>
													<label id="jform_dataocorrencia-lbl" for="jform_dataocorrencia" class="hasTip required" title="" aria-invalid="false">Data e Hora Ocorrência</label>					
													<input type="text" name="jform[dataocorrencia]" id="jform_dataocorrencia" value="<?php  echo date('d/m/Y', strtotime($linhaDaConsulta['dataOcorrencia'])) ?>" readonly="readonly" size="10" class="required"aria-required="true" required="required" aria-invalid="false">
													
													<input type="text" name="jform[horaocorrencia]" id="jform_horaocorrencia" value="<?php  echo date('H:i:s', strtotime($linhaDaConsulta['horaOcorrencia'])) ?>" readonly="readonly" size="10" class="required"aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_datacriacao-lbl" for="jform_datacriacao" class="hasTip required" title="" aria-invalid="false">Data e Hora Criação</label>					
													<input type="text" name="jform[datacriacao]" id="jform_datacriacao" value="<?php  echo date('d/m/Y', strtotime($linhaDaConsulta['datahoraCriacao'])) ?>" readonly="readonly" size="10" class="required"aria-required="true" required="required" aria-invalid="false">
																		
													<input type="text" name="jform[horacriacao]" id="jform_horacriacao" value="<?php  echo date('H:i:s', strtotime($linhaDaConsulta['datahoraCriacao'])) ?>" readonly="readonly" size="10" class="required"aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_categoriacolaboracao-lbl" for="jform_categoriacolaboracao" class="hasTip required" title="" aria-invalid="false">Categoria</label>
													<?php 
													$codCat = $linhaDaConsulta['codCategoriaEvento'];
													$consulta1 = mysql_query("SELECT * FROM categoriaevento WHERE codCategoriaEvento = '$codCat'");
													if(!($linhaDaConsulta1 = mysql_fetch_assoc($consulta1))){
														echo "Erro na consulta : Não foi encontrado dados na tabela categoriaevento";
														exit;
													}
													?>
													<input type="text" name="jform[categoriacolaboracao]" id="jform_categoriacolaboracao" value="<?php  echo $linhaDaConsulta1['desCategoriaEvento'] ?>" readonly="readonly" size="20" class="required"aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_tipocolaboracao-lbl" for="jform_tipocolaboracao" class="hasTip required" title="" aria-invalid="false">Tipo</label>
													<?php 
													$codTip = $linhaDaConsulta['codTipoEvento'];
													$consulta2 = mysql_query("SELECT * FROM tipoevento WHERE codTipoEvento = '$codTip'");
													if(!($linhaDaConsulta2 = mysql_fetch_assoc($consulta2))){
														echo "Erro na consulta : Não foi encontrado dados na tabela tipoevento";
														exit;
													}
													?>
													<input type="text" name="jform[tipocolaboracao]" id="jform_tipocolaboracao" value="<?php  echo $linhaDaConsulta2['desTipoEvento'] ?>" readonly="readonly" size="20" class="required"aria-required="true" required="required" aria-invalid="false">
												</li>
											</ul>
										</fieldset>
									</div>
								</div>
								<div class="width-40 fltrt">
									<div class="width-100">
										<fieldset class="adminform long">
											<legend>Informações do Colaborador</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_nomeusuario-lbl" for="jform_nomeusuario" class="hasTip required" title="" aria-invalid="false">Nome</label>					
													<input type="text" name="jform[nomeusuario]" id="jform_nomeusuario" value="<?php  echo $linhaDaConsulta3['nomPessoa']; ?>" readonly="readonly" size="35"  class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_email-lbl" for="jform_email" class="hasTip" title="" aria-invalid="false">Email</label>					
													<input type="text" name="jform[email]" id="jform_email" value="<?php  echo $linhaDaConsulta3['endEmail']; ?>" readonly="readonly" size="35" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_faixa_etaria-lbl" for="jform_faixa_etaria" class="hasTip" title="" aria-invalid="false">Faixa Etária</label>					
													<input type="text" name="jform[faixa_etaria]" id="jform_faixa_etaria" value="<?php  echo $linhaDaConsulta3['faixaEtaria']; ?>" readonly="readonly" size="10" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_tipo-lbl" for="jform_tipo" class="hasTip" title="">Tipo de usuário</label>			
													<fieldset id="jform_tipo" class="radio">
														<?php 
														if($linhaDaConsulta3['tipoUsuario'] == 'A'){
															echo '<input type="text" name="jform[faixa_etaria]" id="jform_faixa_etaria" value="Administrador" readonly="readonly" size="15" class="required" aria-required="true" required="required" aria-invalid="false">';
														}
														else{
															echo '<input type="text" name="jform[faixa_etaria]" id="jform_faixa_etaria" value="Colaborador" readonly="readonly" size="15" class="required" aria-required="true" required="required" aria-invalid="false">';
														}
														?>
													</fieldset>
												</li>
												
												<li>
													<label id="jform_pontuacao-lbl" for="jform_pontuacao" class="hasTip" title="" aria-invalid="false">Pontuação</label>					
													<input type="text" name="jform[pontuacao]" id="jform_pontuacao" value="<?php  echo $linhaDaConsulta3['pontos']; ?>" readonly="readonly" size="10" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_classe-lbl" for="jform_classe" class="hasTip" title="" aria-invalid="false">Classe de Usuário</label>					
													<input type="text" name="jform[classe]" id="jform_classe" value="<?php  echo $linhaDaConsulta4['nomeClasse']; ?>" size="30" readonly="readonly" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_ip-lbl" for="jform_ip" class="hasTip required" title="" aria-invalid="false">IP</label>					
													<input type="text" name="jform[ip]" id="jform_ip" value="<?php  echo $linhaDaConsulta['ip'] ?>" readonly="readonly" size="20" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
																
											</ul>
										</fieldset>
									</div>
								</div>
								
								<div class="width-60 fltlft">
									<div class="width-100">
										<fieldset class="adminform">
											<legend>Imagem</legend>
											<ul class="adminformlist">
												<?php  if($numImagem==0)
														echo 'Não há imagem nesta colaboração';
													else{
														$linhaDaConsulta5 = mysql_fetch_assoc($consulta5);
														?>
														<li>
															<label id="jform_tituloimagem-lbl" for="jform_tituloimagem" class="hasTip required" title="" aria-invalid="false">Título</label>					
															<input type="text" name="jform[tituloimagem]" id="jform_tituloimagem" value="<?php  echo $linhaDaConsulta5['desTituloImagem']; ?>" readonly="readonly" size="70"  class="required" aria-required="true" required="required" aria-invalid="false">
														</li>
														<?php 
														if($linhaDaConsulta5['comentarioImagem'] != ''){?>
															<li>
																<label id="jform_descricao_imagem-lbl" for="jform_descricao_imagem" class="hasTip" title="" aria-invalid="false">Descrição</label>					
																<textarea name="jform[descricao_imagem]" id="jform_descricao_imagem" cols="60" rows="3" class="required" aria-required="true" required="required" aria-invalid="false" style="width: 305px;" readonly="readonly"><?php  echo $linhaDaConsulta5['comentarioImagem'] ?></textarea>
															</li>
														<?php }else
																echo '<label id="jform_descricao_imagem-lbl" for="jform_descricao_imagem" class="hasTip required" title="" aria-invalid="false">Não há descrição para essa imagem</label>';?>
														<li>
															<label id="jform_imagem-lbl" for="jform_imagem" class="hasTip" title="" aria-invalid="false"  style="margin-left: 140px;"><a href="../ImagensEnviadas/<?php  echo $linhaDaConsulta5['endImagem'] ?>" target="_blank"><img src="../ImagensEnviadas/<?php  echo $linhaDaConsulta5['endImagem'] ?>"  height="200px"/></a></label>	
														</li>	
														
														<li>
															<label id="jform_nomeimagem-lbl" for="jform_nomeimagem" class="hasTip required" title="" aria-invalid="false">Nome do arquivo</label>					
															<input type="text" name="jform[nomeimagem]" id="jform_nomeimagem" value="<?php  echo $linhaDaConsulta5['endImagem']; ?>" readonly="readonly" size="50"  class="required" aria-required="true" required="required" aria-invalid="false">
														</li>
														
														<li>
															<?php  
																list($widthImagem, $heightImagem, $typeImagem, $attrImagem) = getimagesize("../ImagensEnviadas/".$linhaDaConsulta5["endImagem"]);?>
															<label id="jform_tamanhoimagem-lbl" for="jform_tamanhoimagem" class="hasTip required" title="" aria-invalid="false">Tamanho</label>					
															<input type="text" name="jform[tamanhoimagem]" id="jform_tamanhoimagem" value="<?php  echo number_format(filesize("../ImagensEnviadas/".$linhaDaConsulta5['endImagem'])*0.000000953674316, 2, '.', '') . " MB"; ?>" readonly="readonly" size="10"  class="required" aria-required="true" required="required" aria-invalid="false">
														</li>
														
														<li>
															<label id="jform_resolucaoimagem-lbl" for="jform_resolucaoimagem" class="hasTip required" title="" aria-invalid="false">Resolução</label>					
															<input type="text" name="jform[resolucao]" id="jform_resolucaoimagem" value="<?php  echo $widthImagem.'x'.$heightImagem; ?>" readonly="readonly" size="10"  class="required" aria-required="true" required="required" aria-invalid="false">
														</li>
												<?php  } ?>
											</ul>
										</fieldset>
									</div>
								</div>
								
								<div class="width-40 fltrt">
									<div class="width-100">
										<fieldset class="adminform long">
											<legend>Informações do Autor da Imagem</legend>
											<ul class="adminformlist">
												<?php  if($numImagem==0)
														echo 'Não há imagem nesta colaboração';
													else{
														$codUser = $linhaDaConsulta5['codUsuario'];
														$consulta6 = mysql_query("SELECT * FROM usuario WHERE codUsuario = '$codUser'");
															if(!($linhaDaConsulta6 = mysql_fetch_assoc($consulta6))){
																echo "Erro na consulta : Não foi encontrado dados na tabela usuario";
																exit;
															}
														?>
												<li>
													<label id="jform_nomeusuario_imagem-lbl" for="jform_nomeusuario_imagem" class="hasTip required" title="" aria-invalid="false">Nome</label>					
													<input type="text" name="jform[nomeusuario_imagem]" id="jform_nomeusuario_imagem" value="<?php  echo $linhaDaConsulta6['nomPessoa']; ?>" readonly="readonly" size="35"  class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_email_imagem-lbl" for="jform_email_imagem" class="hasTip" title="" aria-invalid="false">Email</label>					
													<input type="text" name="jform[email_imagem]" id="jform_email_imagem" value="<?php  echo $linhaDaConsulta6['endEmail']; ?>" readonly="readonly" size="35" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_faixa_etaria_imagem-lbl" for="jform_faixa_etaria_imagem" class="hasTip" title="" aria-invalid="false">Faixa Etária</label>					
													<input type="text" name="jform[faixa_etaria_imagem]" id="jform_faixa_etaria_imagem" value="<?php  echo $linhaDaConsulta6['faixaEtaria']; ?>" readonly="readonly" size="10" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_tipo_imagem-lbl" for="jform_tipo_imagem" class="hasTip" title="">Tipo de usuário</label>			
													<fieldset id="jform_tipo_imagem" class="radio">
														<?php 
														if($linhaDaConsulta6['tipoUsuario'] == 'A'){
															echo '<input type="text" name="jform[faixa_etaria_imagem]" id="jform_faixa_etaria_imagem" value="Administrador" readonly="readonly" size="15" class="required" aria-required="true" required="required" aria-invalid="false">';
														}
														else{
															echo '<input type="text" name="jform[faixa_etaria_imagem]" id="jform_faixa_etaria_imagem" value="Colaborador" readonly="readonly" size="15" class="required" aria-required="true" required="required" aria-invalid="false">';
														}
														?>
													</fieldset>
												</li>
												
												<li>
													<label id="jform_pontuacao_imagem-lbl" for="jform_pontuacao_imagem" class="hasTip" title="" aria-invalid="false">Pontuação</label>					
													<input type="text" name="jform[pontuacao_imagem]" id="jform_pontuacao_imagem" value="<?php  echo $linhaDaConsulta6['pontos']; ?>" readonly="readonly" size="10" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<?php 
														$codigoClasse2 = $linhaDaConsulta6['classeUsuario'];
														$consulta7 = mysql_query("SELECT * FROM classesdeusuarios WHERE codClasse = '$codigoClasse2'");
														if(!($linhaDaConsulta7 = mysql_fetch_assoc($consulta7))){
															echo "Erro na consulta : Não foi encontrado dados na tabela classesdeusuarios";
															exit;
														}
													?>
													<label id="jform_classe_imagem-lbl" for="jform_classe_imagem" class="hasTip" title="" aria-invalid="false">Classe de Usuário</label>					
													<input type="text" name="jform[classe_imagem]" id="jform_classe_imagem" value="<?php  echo $linhaDaConsulta7['nomeClasse']; ?>" size="30" readonly="readonly" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_ip_imagem-lbl" for="jform_ip_imagem" class="hasTip required" title="" aria-invalid="false">IP</label>					
													<input type="text" name="jform[ip_imagem]" id="jform_ip_imagem" value="<?php  echo 'Não Capturado'?>" readonly="readonly" size="20" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												<?php  } ?>
																
											</ul>
										</fieldset>
									</div>
								</div>
								
								<div class="width-60 fltlft">
									<div class="width-100">
										<fieldset class="adminform">
											<legend>Vídeo</legend>
											<ul class="adminformlist">
												<?php  if($numVideo==0)
														echo 'Não há video nesta colaboração';
													else{
														$linhaDaConsulta8 = mysql_fetch_assoc($consulta8);
														?>
														<li>
															<label id="jform_titulovideo-lbl" for="jform_titulovideo" class="hasTip required" title="" aria-invalid="false">Título</label>					
															<input type="text" name="jform[titulovideo]" id="jform_titulovideo" value="<?php  echo $linhaDaConsulta8['desTituloVideo']; ?>" readonly="readonly" size="70"  class="required" aria-required="true" required="required" aria-invalid="false">
														</li>
														<?php 
														if($linhaDaConsulta8['comentarioVideo'] != ''){?>
															<li>
																<label id="jform_descricao_video-lbl" for="jform_descricao_video" class="hasTip" title="" aria-invalid="false">Descrição</label>					
																<textarea name="jform[descricao_video]" id="jform_descricao_video" cols="60" rows="3" class="required" aria-required="true" required="required" aria-invalid="false" style="width: 305px;" readonly="readonly"><?php  echo $linhaDaConsulta8['comentarioVideo'] ?></textarea>
															</li>
														<?php }else
																echo '<label id="jform_descricao_video-lbl" for="jform_descricao_video" class="hasTip required" title="" aria-invalid="false">Não há descrição para essa video</label>';?>
														<li>
															<label id="jform_video-lbl" for="jform_video" class="hasTip" title="" aria-invalid="false"  style="margin-left: 140px;"><?php  echo '<iframe width="400" height="300" src="//www.youtube.com/embed/'.$linhaDaConsulta8['desUrlVideo'].'?rel=0" frameborder="0" allowfullscreen></iframe>' ?></label>	
														</li>	
												<?php  } ?>
											</ul>
										</fieldset>
									</div>
								</div>
								
								<div class="width-40 fltrt">
									<div class="width-100">
										<fieldset class="adminform long">
											<legend>Informações do Autor do Vídeo</legend>
											<ul class="adminformlist">
												<?php  if($numVideo==0)
														echo 'Não há video nesta colaboração';
													else{
														$codUser2 = $linhaDaConsulta8['codUsuario'];
														$consulta9 = mysql_query("SELECT * FROM usuario WHERE codUsuario = '$codUser2'");
															if(!($linhaDaConsulta9 = mysql_fetch_assoc($consulta9))){
																echo "Erro na consulta : Não foi encontrado dados na tabela usuario";
																exit;
															}
														?>
												<li>
													<label id="jform_nomeusuario_video-lbl" for="jform_nomeusuario_video" class="hasTip required" title="" aria-invalid="false">Nome</label>					
													<input type="text" name="jform[nomeusuario_video]" id="jform_nomeusuario_video" value="<?php  echo $linhaDaConsulta9['nomPessoa']; ?>" readonly="readonly" size="35"  class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_email_video-lbl" for="jform_email_video" class="hasTip" title="" aria-invalid="false">Email</label>					
													<input type="text" name="jform[email_video]" id="jform_email_video" value="<?php  echo $linhaDaConsulta9['endEmail']; ?>" readonly="readonly" size="35" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_faixa_etaria_video-lbl" for="jform_faixa_etaria_video" class="hasTip" title="" aria-invalid="false">Faixa Etária</label>					
													<input type="text" name="jform[faixa_etaria_video]" id="jform_faixa_etaria_video" value="<?php  echo $linhaDaConsulta9['faixaEtaria']; ?>" readonly="readonly" size="10" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_tipo_video-lbl" for="jform_tipo_video" class="hasTip" title="">Tipo de usuário</label>			
													<fieldset id="jform_tipo_video" class="radio">
														<?php 
														if($linhaDaConsulta9['tipoUsuario'] == 'A'){
															echo '<input type="text" name="jform[faixa_etaria_video]" id="jform_faixa_etaria_video" value="Administrador" readonly="readonly" size="15" class="required" aria-required="true" required="required" aria-invalid="false">';
														}
														else{
															echo '<input type="text" name="jform[faixa_etaria_video]" id="jform_faixa_etaria_video" value="Colaborador" readonly="readonly" size="15" class="required" aria-required="true" required="required" aria-invalid="false">';
														}
														?>
													</fieldset>
												</li>
												
												<li>
													<label id="jform_pontuacao_video-lbl" for="jform_pontuacao_video" class="hasTip" title="" aria-invalid="false">Pontuação</label>					
													<input type="text" name="jform[pontuacao_video]" id="jform_pontuacao_video" value="<?php  echo $linhaDaConsulta9['pontos']; ?>" readonly="readonly" size="10" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<?php 
														$codigoClasse3 = $linhaDaConsulta9['classeUsuario'];
														$consulta10 = mysql_query("SELECT * FROM classesdeusuarios WHERE codClasse = '$codigoClasse3'");
														if(!($linhaDaConsulta10 = mysql_fetch_assoc($consulta10))){
															echo "Erro na consulta : Não foi encontrado dados na tabela classesdeusuarios";
															exit;
														}
													?>
													<label id="jform_classe_video-lbl" for="jform_classe_video" class="hasTip" title="" aria-invalid="false">Classe de Usuário</label>					
													<input type="text" name="jform[classe_video]" id="jform_classe_video" value="<?php  echo $linhaDaConsulta10['nomeClasse']; ?>" size="30" readonly="readonly" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_ip_video-lbl" for="jform_ip_video" class="hasTip required" title="" aria-invalid="false">IP</label>					
													<input type="text" name="jform[ip_video]" id="jform_ip_video" value="<?php  echo 'Não Capturado'?>" readonly="readonly" size="20" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												<?php  } ?>
																
											</ul>
										</fieldset>
									</div>
								</div>
								
								<div class="width-60 fltlft">
									<div class="width-100">
										<fieldset class="adminform">
											<legend>Arquivo</legend>
											<ul class="adminformlist">
												<?php  if($numArquivo==0)
														echo 'Não há arquivo nesta colaboração';
													else{
														$linhaDaConsulta11 = mysql_fetch_assoc($consulta11);
														?>
														<li>
															<label id="jform_tituloarquivo-lbl" for="jform_tituloarquivo" class="hasTip required" title="" aria-invalid="false">Título</label>					
															<input type="text" name="jform[tituloarquivo]" id="jform_tituloarquivo" value="<?php  echo $linhaDaConsulta11['desArquivo']; ?>" readonly="readonly" size="70"  class="required" aria-required="true" required="required" aria-invalid="false">
														</li>
														<?php 
														if($linhaDaConsulta11['comentarioArquivo'] != ''){?>
															<li>
																<label id="jform_descricao_arquivo-lbl" for="jform_descricao_arquivo" class="hasTip" title="" aria-invalid="false">Descrição</label>					
																<textarea name="jform[descricao_arquivo]" id="jform_descricao_arquivo" cols="60" rows="3" class="required" aria-required="true" required="required" aria-invalid="false" style="width: 305px;" readonly="readonly"><?php  echo $linhaDaConsulta11['comentarioArquivo'] ?></textarea>
															</li>
														<?php }else
																echo '<label id="jform_descricao_arquivo-lbl" for="jform_descricao_arquivo" class="hasTip required" title="" aria-invalid="false">Não há descrição para essa arquivo</label>';?>
														
														<li>
															<label id="jform_nomearquivo-lbl" for="jform_nomearquivo" class="hasTip required" title="" aria-invalid="false">Nome do arquivo</label>					
															<input type="text" name="jform[nomearquivo]" id="jform_nomearquivo" value="<?php  echo $linhaDaConsulta11['endArquivo']; ?>" readonly="readonly" size="50"  class="required" aria-required="true" required="required" aria-invalid="false">
														</li>
														
														<li>
															<label id="jform_tamanhoarquivo-lbl" for="jform_tamanhoarquivo" class="hasTip required" title="" aria-invalid="false">Tamanho</label>					
															<input type="text" name="jform[tamanhoarquivo]" id="jform_tamanhoarquivo" value="<?php  echo number_format(filesize("../Arquivos/".$linhaDaConsulta11['endArquivo'])*0.000000953674316, 2, '.', '') . " MB"; ?>" readonly="readonly" size="10"  class="required" aria-required="true" required="required" aria-invalid="false">
														</li>
														
														<li>
															<label id="jform_arquivo-lbl" for="jform_arquivo" class="hasTip" title="" aria-invalid="false"  style="margin-left: 140px;"><a href="../Arquivos/<?php  echo $linhaDaConsulta11['endArquivo'] ?>" target="_blank"><img src="images/layout/botao_download.png"/></a></label>	
														</li>	
												<?php  } ?>
											</ul>
										</fieldset>
									</div>
								</div>
								
								<div class="width-40 fltrt">
									<div class="width-100">
										<fieldset class="adminform long">
											<legend>Informações do Autor do Arquivo</legend>
											<ul class="adminformlist">
												<?php  if($numArquivo==0)
														echo 'Não há arquivo nesta colaboração';
													else{
														$codUser3 = $linhaDaConsulta11['codUsuario'];
														$consulta12 = mysql_query("SELECT * FROM usuario WHERE codUsuario = '$codUser3'");
															if(!($linhaDaConsulta12 = mysql_fetch_assoc($consulta12))){
																echo "Erro na consulta : Não foi encontrado dados na tabela usuario";
																exit;
															}
														?>
												<li>
													<label id="jform_nomeusuario_arquivo-lbl" for="jform_nomeusuario_arquivo" class="hasTip required" title="" aria-invalid="false">Nome</label>					
													<input type="text" name="jform[nomeusuario_arquivo]" id="jform_nomeusuario_arquivo" value="<?php  echo $linhaDaConsulta12['nomPessoa']; ?>" readonly="readonly" size="35"  class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_email_arquivo-lbl" for="jform_email_arquivo" class="hasTip" title="" aria-invalid="false">Email</label>					
													<input type="text" name="jform[email_arquivo]" id="jform_email_arquivo" value="<?php  echo $linhaDaConsulta12['endEmail']; ?>" readonly="readonly" size="35" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_faixa_etaria_arquivo-lbl" for="jform_faixa_etaria_arquivo" class="hasTip" title="" aria-invalid="false">Faixa Etária</label>					
													<input type="text" name="jform[faixa_etaria_arquivo]" id="jform_faixa_etaria_arquivo" value="<?php  echo $linhaDaConsulta12['faixaEtaria']; ?>" readonly="readonly" size="10" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_tipo_arquivo-lbl" for="jform_tipo_arquivo" class="hasTip" title="">Tipo de usuário</label>			
													<fieldset id="jform_tipo_arquivo" class="radio">
														<?php 
														if($linhaDaConsulta12['tipoUsuario'] == 'A'){
															echo '<input type="text" name="jform[faixa_etaria_arquivo]" id="jform_faixa_etaria_arquivo" value="Administrador" readonly="readonly" size="15" class="required" aria-required="true" required="required" aria-invalid="false">';
														}
														else{
															echo '<input type="text" name="jform[faixa_etaria_arquivo]" id="jform_faixa_etaria_arquivo" value="Colaborador" readonly="readonly" size="15" class="required" aria-required="true" required="required" aria-invalid="false">';
														}
														?>
													</fieldset>
												</li>
												
												<li>
													<label id="jform_pontuacao_arquivo-lbl" for="jform_pontuacao_arquivo" class="hasTip" title="" aria-invalid="false">Pontuação</label>					
													<input type="text" name="jform[pontuacao_arquivo]" id="jform_pontuacao_arquivo" value="<?php  echo $linhaDaConsulta12['pontos']; ?>" readonly="readonly" size="10" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<?php 
														$codigoClasse4 = $linhaDaConsulta12['classeUsuario'];
														$consulta13 = mysql_query("SELECT * FROM classesdeusuarios WHERE codClasse = '$codigoClasse4'");
														if(!($linhaDaConsulta13 = mysql_fetch_assoc($consulta13))){
															echo "Erro na consulta : Não foi encontrado dados na tabela classesdeusuarios";
															exit;
														}
													?>
													<label id="jform_classe_arquivo-lbl" for="jform_classe_arquivo" class="hasTip" title="" aria-invalid="false">Classe de Usuário</label>					
													<input type="text" name="jform[classe_arquivo]" id="jform_classe_arquivo" value="<?php  echo $linhaDaConsulta13['nomeClasse']; ?>" size="30" readonly="readonly" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_ip_arquivo-lbl" for="jform_ip_arquivo" class="hasTip required" title="" aria-invalid="false">IP</label>					
													<input type="text" name="jform[ip_arquivo]" id="jform_ip_arquivo" value="<?php  echo 'Não Capturado'?>" readonly="readonly" size="20" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												<?php  } ?>
																
											</ul>
										</fieldset>
									</div>
								</div>
								
								<div class="width-60 fltlft">
									<div class="width-100">
										<fieldset class="adminform">
											<legend>Informações Geográficas</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_latitude-lbl" for="jform_latitude" class="hasTip required" title="" aria-invalid="false">Latitude</label>					
													<input type="text" name="jform[latitude]" id="jform_latitude" value="<?php  echo $linhaDaConsulta['numLatitude']; ?>" readonly="readonly" size="10"  class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												<li>
													<label id="jform_longitude-lbl" for="jform_longitude" class="hasTip required" title="" aria-invalid="false">Longitude</label>					
													<input type="text" name="jform[longitude]" id="jform_longitude" value="<?php  echo $linhaDaConsulta['numLongitude']; ?>" readonly="readonly" size="10"  class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												<li>
													<label id="jform_zoom-lbl" for="jform_zoom" class="hasTip required" title="" aria-invalid="false">Zoom da Colaboração</label>					
													<input type="text" name="jform[zoom]" id="jform_zoom" value="<?php  echo $linhaDaConsulta['zoom']; ?>" readonly="readonly" size="10"  class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												<div align = 'center'>
													<body onload="initialize2(<?php echo $id.','.$linhaDaConsulta['numLatitude'].','.$linhaDaConsulta['numLongitude'].','.$linhaDaConsulta['zoom'];?>);" style="margin: 0;" class="corposite">   
														<div id="map_canvas" style="width: 100%; height: 300px"></div>	
													</body>
												</div>
											</ul>
										</fieldset>
									</div>
								</div>
								
								<div class="width-40 fltrt">
									<div class="width-100">
										<fieldset class="adminform long">
											<legend>Comentarios</legend>
											<ul class="adminformlist">
												
																
											</ul>
										</fieldset>
									</div>
								</div>
								
								<div class="width-40 fltrt">
									<div class="width-100">
										<fieldset class="adminform long">
											<legend>Estatísticas</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_qtd_visualizacao-lbl" for="jform_qtd_visualizacao" class="hasTip required" title="" aria-invalid="false">Quantidade de Visualização</label>					
													<input type="text" name="jform[qtd_visualizacao]" id="jform_qtd_visualizacao" value="<?php  echo $linhaDaConsulta14['qtdVisualizacao']; ?>" readonly="readonly" size="10"  class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												<li>
													<label id="jform_qtd_avaliacao-lbl" for="jform_qtd_avaliacao" class="hasTip required" title="" aria-invalid="false">Quantidade de Avaliação</label>					
													<input type="text" name="jform[qtd_avaliacao]" id="jform_qtd_avaliacao" value="<?php  echo $linhaDaConsulta14['qtdAvaliacao']; ?>" readonly="readonly" size="10"  class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												<li>
													<label id="jform_nota_media-lbl" for="jform_nota_media" class="hasTip required" title="" aria-invalid="false">Nota Média</label>					
													<input type="text" name="jform[nota_media]" id="jform_nota_media" value="<?php  echo $linhaDaConsulta14['notaMedia']; ?>" readonly="readonly" size="10"  class="required" aria-required="true" required="required" aria-invalid="false">
												</li>			
											</ul>
										</fieldset>
									</div>
								</div>
								
								<div class="width-40 fltrt">
									<div class="width-100">
										<fieldset class="adminform long">
											<legend>Avaliação</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_status-lbl" for="jform_status" class="hasTip required" title="" aria-invalid="false">Status
														<span class="star">&nbsp;*</span>
													</label>					
													<select id="jform_status" name="jform[status]" aria-invalid="false">
														<option value="padrao" selected="selected">Escolha sua avaliação</option>
														<option value="A">Aprovado</option>
														<option value="R">Reprovado</option>
													</select>
												</li>
												<li>
													<label id="jform_justificativa-lbl" for="jform_justificativa" class="hasTip" title="" aria-invalid="false">Justificativa</label>					
													<textarea name="jform[justificativa]" id="jform_justificativa" cols="50" rows="5" class="required" aria-invalid="false" style="width: 240px;" ></textarea>
												</li>
												<li>
													<label id="jform_envia_email-lbl" for="jform_envia_email" class="hasTip" title="">Enviar email para Colaborador</label>			
													<fieldset id="jform_envia_email" class="radio">
														<input type="radio" id="jform_envia_email0" name="jform[envia_email]" value="1" >
														<label for="jform_envia_email0">Sim</label>
														<input type="radio" id="jform_envia_email1" name="jform[envia_email]" value="0" checked="checked">
														<label for="jform_envia_email1">Não</label>
														
													</fieldset>
												</li>
												<div align = 'center' style="margin-left:40%;">
													<a href="#" onclick="salvar()" class="toolbar"> 
														<img src="images/layout/avaliar.png"/>
													</a>
												</div>
												
											</ul>
										</fieldset>
									</div>
								</div>
								
							</div>
						</div>
					</div>
				</form>
				<div class="clr"></div>
			</div>
		</div>
	</html>
<?php   require('rodape.php');
	}
?> 
	