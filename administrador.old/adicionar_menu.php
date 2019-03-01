<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 
		$sta = '';
		if(isset($_GET['sta'])) $sta = $_GET['sta'];
		
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
								Salvar &amp; Novo
							</a>
						</li>
						
						<li class="divider"></li>

						<li class="button" id="toolbar-cancel">
							<a href="listar_menu.php?sta=<?php  echo $sta; ?>" class="toolbar">
							<span class="icon-32-cancel"></span>
							Cancelar
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-levels-add"><h2>Novo Item de Menu</h2></div>
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
											<legend>Informações do Item</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_nome-lbl" for="jform_nome" class="hasTip required" title="" aria-invalid="false">Nome
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[nome]" id="jform_nome" value="" size="50" aria-invalid="false">
													<input type="hidden" name="sta" id="sta" value="<?php  echo $sta; ?>">
												</li>
												
												<li>
													<label id="jform_email-lbl" for="jform_endereco" class="hasTip" title="" aria-invalid="false">Endereço
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[endereco]" id="jform_endereco" value="" size="50" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_faixa_etaria-lbl" for="jform_status_item" class="hasTip" title="" aria-invalid="false">Status<span class="star">&nbsp;*</span></label>					
													<select id="jform_status_item" name="jform[faixa_etaria]" aria-invalid="false">
														<option value="0" selected="selected">Publicado</option>;
														<option value="1">Despublicado</option>;
													</select>
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
			var novoNome  = document.getElementById('jform_nome').value;
			var novoEndereco  = document.getElementById('jform_endereco').value;
			var statusItem  = document.getElementById('jform_status_item').value;
			var origem = 'salvar';
			var sta = document.getElementById('sta').value;
			
			window.location.href = "cria_menu.php?novoNome=" + novoNome 
			+ "&novoEndereco=" + novoEndereco			
			+ "&statusItem=" + statusItem
			+ "&origem=" + origem
			+ "&sta=" + sta;
		}
		
		function salvarenovo(){
			var novoNome  = document.getElementById('jform_nome').value;
			var novoEndereco  = document.getElementById('jform_endereco').value;
			var statusItem  = document.getElementById('jform_status_item').value;			
			var origem = 'salvarenovo';
			var sta = document.getElementById('sta').value;
			
			window.location.href = "cria_menu.php?novoNome=" + novoNome 
			+ "&novoEndereco=" + novoEndereco			
			+ "&statusItem=" + statusItem
			+ "&origem=" + origem
			+ "&sta=" + sta;
		}	
	
	</script>
<?php   require('rodape.php');
	}
?> 
	