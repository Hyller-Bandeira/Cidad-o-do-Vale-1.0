<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 
		//Consultas SQL
		$consulta = mysql_query("SELECT * FROM configuracoes");
		if(!($linhaDaConsulta = mysql_fetch_assoc($consulta))){
			echo "Erro na consulta : Não foi encontrado dados na tabela configuracoes";
			exit;
		}
		
		$latitudeInicial = $linhaDaConsulta['latitude'];
		$longitudeInicial = $linhaDaConsulta['longitude'];
		$zoomInicial = $linhaDaConsulta['zoom'];
		$tipoMapaInicial = $linhaDaConsulta['tipoMapa'];
		$loginFacebook = $linhaDaConsulta['loginFacebook'];
		$loginGoogle = $linhaDaConsulta['loginGoogle'];
		$loginAnonimo = $linhaDaConsulta['loginAnonimo'];
		$emailContato = $linhaDaConsulta['emailContato'];
		$senhaContato = $linhaDaConsulta['senhaContato'];
		$linkBase = $linhaDaConsulta['linkBase'];
		$appIDFacebook = $linhaDaConsulta['appIDFacebook'];
		$appSecretFacebook = $linhaDaConsulta['appSecretFacebook'];
		
		  require ("cabecalho.php");
		  require ("menu.php");?>
		
		<div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
					<ul>
						<li class="button" id="toolbar-apply">
						<a href="#" onclick="salvar()" class="toolbar">
							<span class="icon-32-apply"></span>
							Salvar
						</a>
						</li>

						<li class="divider"></li>

						<li class="button" id="toolbar-cancel">
							<a href="index.php" class="toolbar">
							<span class="icon-32-cancel"></span>
							Cancelar
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-config"><h2>Configurações</h2></div>
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
											<legend>Site</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_sitename-lbl" for="jform_sitename" class="hasTip required" title="" aria-invalid="false">Nome do Site
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[sitename]" id="jform_sitename" value="<?php  echo $nome_site; ?> " size="50" aria-invalid="false">
												</li>
												<li>
													<label id="jform_email_contato-lbl" for="jform_email_contato" class="hasTip required" title="" aria-invalid="false">Email para Contato
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[email_contato]" id="jform_email_contato" value="<?php  echo $emailContato; ?>" size="50" aria-invalid="false">
												</li>
												<li>
													<label id="jform_senha_contato-lbl" for="jform_senha_contato" class="hasTip required" title="" aria-invalid="false">Senha do Email
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="password" name="jform[senha_contato]" id="jform_senha_contato" value="<?php  echo $senhaContato; ?>" size="50" aria-invalid="false">
												</li>	
												<li>
													<label id="jform_link-lbl" for="jform_link" class="hasTip required" title="" aria-invalid="false">Link da página inicial
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[link]" id="jform_link" value="<?php  echo $linkBase; ?>" size="50" aria-invalid="false">
												</li>																	
											</ul>
										</fieldset>
									</div>
									
									<div class="width-100">
										<fieldset class="adminform">
											<legend>Mapa</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_latitude-lbl" for="jform_latitude" class="hasTip required" title="" aria-invalid="false">Latitude
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[latitude]" id="jform_latitude" value="<?php  echo $latitudeInicial; ?>" size="10" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_longitude-lbl" for="jform_longitude" class="hasTip required" title="" aria-invalid="false">Longitude
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[longitude]" id="jform_longitude" value="<?php  echo $longitudeInicial; ?>" size="10" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_zoom-lbl" for="jform_zoom" class="hasTip required" title="" aria-invalid="false">Nível de Zoom
														<span class="star">&nbsp;*</span>
													</label>					
													<select id="jform_zoom" name="jform[editor]" aria-invalid="false">
														<?php 
														for($i = 0; $i <= 21; $i++){
															if($i == $zoomInicial)
																echo '<option value='.$i.' selected="selected">'.$i.'</option>';
															else
																echo '<option value='.$i.'>'.$i.'</option>';
														}
														?>
													</select>
												</li>
												
												<li>
													<label id="jform_tipo_mapa-lbl" for="jform_tipo_mapa" class="hasTip required" title="" >Tipo de Mapa
														<span class="star">&nbsp;*</span>
													</label>
													<fieldset id="jform_tipo_mapa" class="radio">
														<?php 
														if($tipoMapaInicial == 'ROADMAP')
															echo '<input type="radio" id="jform_tipo_mapa0" name="jform[tipo_mapa]" value="0" checked="checked">';
														else
															echo '<input type="radio" id="jform_tipo_mapa0" name="jform[tipo_mapa]" value="0">';
														echo '<label for="jform_tipo_mapa0">Mapa</label>';
														
														if($tipoMapaInicial == 'SATELLITE')
															echo '<input type="radio" id="jform_tipo_mapa1" name="jform[tipo_mapa]" value="1" checked="checked">';
														else
															echo '<input type="radio" id="jform_tipo_mapa1" name="jform[tipo_mapa]" value="1">';
														echo '<label for="jform_tipo_mapa1">Satélite</label>';
														
														if($tipoMapaInicial == 'TERRAIN')
															echo '<input type="radio" id="jform_tipo_mapa2" name="jform[tipo_mapa]" value="2" checked="checked">';
														else
															echo '<input type="radio" id="jform_tipo_mapa2" name="jform[tipo_mapa]" value="2">';
														echo '<label for="jform_tipo_mapa2">Relevo Físico</label>';
														
														if($tipoMapaInicial == 'HYBRID')
															echo '<input type="radio" id="jform_tipo_mapa3" name="jform[tipo_mapa]" value="3" checked="checked">';
														else
															echo '<input type="radio" id="jform_tipo_mapa3" name="jform[tipo_mapa]" value="3">';
														echo '<label for="jform_tipo_mapa3">Mapa e Satélite</label>';
														?>
													</fieldset>
												</li>
																			
											</ul>
										</fieldset>
									</div>
									
								</div>
								
								<div class="width-40 fltrt">
									<div class="width-100">
										<fieldset class="adminform long">
											<legend>Login</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_facebook-lbl" for="jform_facebook" class="hasTip" title="">Facebook</label>			
													<fieldset id="jform_facebook" class="radio">
														<?php 
														if($loginFacebook == '1'){
															echo '<input type="radio" id="jform_facebook0" name="jform[facebook]" value="1" checked="checked">';
															echo '<label for="jform_facebook0">Sim</label>';
															echo '<input type="radio" id="jform_facebook1" name="jform[facebook]" value="0">';
															echo '<label for="jform_facebook1">Não</label>';
														}
														else{
															echo '<input type="radio" id="jform_facebook0" name="jform[facebook]" value="1">';
															echo '<label for="jform_facebook0">Sim</label>';
															echo '<input type="radio" id="jform_facebook1" name="jform[facebook]" value="0" checked="checked">';
															echo '<label for="jform_facebook1">Não</label>';
														}
														?>
													</fieldset>
												</li>
												
												<li>
													<label id="jform_sitename-lbl" for="jform_appIDFacebook" class="hasTip" title="" aria-invalid="false">App ID Facebook
													</label>					
													<input type="text" name="jform[appIDFacebook]" id="jform_appIDFacebook" value="<?php  echo $appIDFacebook; ?>" size="25" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_sitename-lbl" for="jform_appSecretFacebook" class="hasTip" title="" aria-invalid="false">App Secret Facebook
													</label>					
													<input type="text" name="jform[appSecretFacebook]" id="jform_appSecretFacebook" value="<?php  echo $appSecretFacebook; ?>" size="25" aria-invalid="false">
												</li>
												
												
												<li>
													<label id="jform_google-lbl" for="jform_google" class="hasTip" title="">Google+</label>			
													<fieldset id="jform_google" class="radio">
														<?php 
														if($loginGoogle == '1'){
															echo '<input type="radio" id="jform_google0" name="jform[google]" value="1" checked="checked">';
															echo '<label for="jform_google0">Sim</label>';
															echo '<input type="radio" id="jform_google1" name="jform[google]" value="0">';
															echo '<label for="jform_google1">Não</label>';
														}
														else{
															echo '<input type="radio" id="jform_google0" name="jform[google]" value="1">';
															echo '<label for="jform_google0">Sim</label>';
															echo '<input type="radio" id="jform_google1" name="jform[google]" value="0"checked="checked">';
															echo '<label for="jform_google1">Não</label>';
														}
														?>
													</fieldset>
												</li>
												
												<li>
													<label id="jform_anonimo-lbl" for="jform_anonimo" class="hasTip" title="">Anônimo</label>			
													<fieldset id="jform_anonimo" class="radio">
														<?php 
														if($loginAnonimo == '1'){
															echo '<input type="radio" id="jform_anonimo0" name="jform[anonimo]" value="1" checked="checked">';
															echo '<label for="jform_anonimo0">Sim</label>';
															echo '<input type="radio" id="jform_anonimo1" name="jform[anonimo]" value="0">';
															echo '<label for="jform_anonimo1">Não</label>';
														}
														else{
															echo '<input type="radio" id="jform_anonimo0" name="jform[anonimo]" value="1">';
															echo '<label for="jform_anonimo0">Sim</label>';
															echo '<input type="radio" id="jform_anonimo1" name="jform[anonimo]" value="0" checked="checked">';
															echo '<label for="jform_anonimo1">Não</label>';
														}
														?>
													</fieldset>
												</li>
																
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
	
	<script  type="text/javascript">
		function salvar(){
			var novoNomeSite  = document.getElementById('jform_sitename').value;
			var novaLatitude  = document.getElementById('jform_latitude').value;
			var novaLongitude  = document.getElementById('jform_longitude').value;
			var novoZoom  = document.getElementById('jform_zoom').value;
			var novoEmailContato  = document.getElementById('jform_email_contato').value;
			var senhaEmailContato  = document.getElementById('jform_senha_contato').value;
			var novoLink  = document.getElementById('jform_link').value;
			var novoTipoMapa  = '';
			var novoLoginF = '';
			var novoLoginG = '';
			var novoLoginA = '';
			var appIDFacebook  = document.getElementById('jform_appIDFacebook').value;
			var appSecretFacebook  = document.getElementById('jform_appSecretFacebook').value;
			
			if(document.getElementById('jform_tipo_mapa1').checked)
				novoTipoMapa = 'SATELLITE';
			else if(document.getElementById('jform_tipo_mapa2').checked)
				novoTipoMapa = 'TERRAIN';
			else if(document.getElementById('jform_tipo_mapa3').checked)
				novoTipoMapa = 'HYBRID';
			else
				novoTipoMapa = 'ROADMAP';
			
			if(!document.getElementById('jform_facebook0').checked)
				novoLoginF = '0';
			else
				novoLoginF = '1';

			
			if(!document.getElementById('jform_google0').checked)
				novoLoginG = '0';
			else
				novoLoginG = '1';
			
			if(!document.getElementById('jform_anonimo0').checked)
				novoLoginA = '0';
			else
				novoLoginA = '1';
			
			window.location.href = "alterar_configuracao.php?novoNomeSite=" + novoNomeSite 
			+ "&novaLatitude=" + novaLatitude 
			+ "&novaLongitude=" + novaLongitude
			+ "&novoZoom=" + novoZoom
			+ "&novoTipoMapa=" + novoTipoMapa
			+ "&novoLoginF=" + novoLoginF
			+ "&novoLoginG=" + novoLoginG
			+ "&novoLoginA=" + novoLoginA
			+ "&novoEmailContato=" + novoEmailContato
			+ "&senhaEmailContato=" + senhaEmailContato
			+ "&novoLink=" + novoLink
			+ "&appIDFacebook=" + appIDFacebook
			+ "&appSecretFacebook=" + appSecretFacebook;

			
			
		}
	</script>
<?php   require('rodape.php');
	}
?> 
	