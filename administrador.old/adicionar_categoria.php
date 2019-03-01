<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
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
							<a href="listar_categorias.php" class="toolbar">
							<span class="icon-32-cancel"></span>
							Cancelar
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-category-add"><h2>Nova Categoria</h2></div>
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
											<legend>Nova Categoria</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_novonomecategoria-lbl" for="jform_novonomecategoria" class="hasTip required" title="" aria-invalid="false">Nome
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[novonomecategoria]" id="jform_novonomecategoria" value="" size="50"  aria-invalid="false">
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
			var novoNomeCategoria  = document.getElementById('jform_novonomecategoria').value;
			var origem = 'salvar';
			
			if(novoNomeCategoria == '')
				alert("Informe o nome da categoria");
			else
				window.location.href = "cria_categoria.php?novoNomeCategoria=" + novoNomeCategoria + "&origem=" + origem;
		}
		
		function salvarenovo(){
			var novoNomeCategoria  = document.getElementById('jform_novonomecategoria').value;
			var origem = 'salvarenovo';
			
			if(novoNomeCategoria == '')
				alert("Informe o nome da categoria");
			else
				window.location.href = "cria_categoria.php?novoNomeCategoria=" + novoNomeCategoria + "&origem=" + origem;
		}
	</script>
<?php   require('rodape.php');
	}
?> 
	