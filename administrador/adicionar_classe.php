<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user_admin_'.$link_inicial]) && !isset($_SESSION['pass_admin_'.$link_inicial])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 
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
						
						<li class="button" id="toolbar-save-new">
							<a href="#" onclick="salvarenovo()" class="toolbar">
								<span class="icon-32-save-new">
								</span>
								Salvar &amp; Nova
							</a>
						</li>
						
						<li class="divider"></li>

						<li class="button" id="toolbar-cancel">
							<a href="listar_classes.php" class="toolbar">
							<span class="icon-32-cancel"></span>
							Cancelar
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-groups-add"><h2>Nova Classe</h2></div>
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
											<legend>Nova Classe de Usuário</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_novonomeclasse-lbl" for="jform_novonomeclasse" class="hasTip required" title="" aria-invalid="false">Nome
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[novonomeclasse]" id="jform_novonomeclasse" value="" size="50"  aria-invalid="false">
												</li>	
												<li>
													<label id="jform_novafaixa-lbl" for="jform_novafaixa" class="hasTip required" title="" aria-invalid="false">Faixa de Pontos
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[novafaixa]" id="jform_novafaixa" value="" size="50"  aria-invalid="false">
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
			var novonomeclasse  = document.getElementById('jform_novonomeclasse').value;
			var novafaixa  = document.getElementById('jform_novafaixa').value;
			var origem = 'salvar';
			
			if(novonomeclasse == '')
				alert("Informe o nome da classe");
			else
				window.location.href = "cria_classe.php?novonomeclasse=" + novonomeclasse + "&origem=" + origem + "&novafaixa=" + novafaixa;
		}
		
		function salvarenovo(){
			var novonomeclasse  = document.getElementById('jform_novonomeclasse').value;
			var novafaixa  = document.getElementById('jform_novafaixa').value;
			var origem = 'salvarenovo';
			
			if(novonomeclasse == '')
				alert("Informe o nome da classe");
			else
				window.location.href = "cria_classe.php?novonomeclasse=" + novonomeclasse + "&origem=" + origem + "&novafaixa=" + novafaixa;
		}
	</script>
<?php   require 'rodape.php';
	}
?> 
	