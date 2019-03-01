<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user_admin_'.$link_inicial]) && !isset($_SESSION['pass_admin_'.$link_inicial])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 
		$cga = '';
		if(isset($_GET['cga'])) $cga = $_GET['cga'];
		$consulta = $connection->query("SELECT * FROM categoriaevento ORDER BY desCategoriaEvento ASC");
		
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
							<a href="listar_tipos.php?cga=<?php  echo $cga; ?>" class="toolbar">
							<span class="icon-32-cancel"></span>
							Cancelar
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-new"><h2>Novo Tipo</h2></div>
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
											<legend>Novo Tipo</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_novonometipo-lbl" for="jform_novonometipo" class="hasTip required" title="" aria-invalid="false">Nome
														<span class="star">&nbsp;*</span>
													</label>
													<input type="hidden" name="cga" id="cga" value="<?php  echo $cga; ?>">
													<input type="text" name="jform[novonometipo]" id="jform_novonometipo" value="" size="50" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_categoria-lbl" for="jform_categoria" class="hasTip required" title="" aria-invalid="false">Categoria
														<span class="star">&nbsp;*</span>
													</label>					
													<select id="jform_categoria" name="jform[editor]" aria-invalid="false">
														<?php 
														if($cga == '')
															echo '<option value="padrao" selected="selected">Selecione uma categoria</option>';
														while($categoria = $consulta->fetch_array()){
															if($cga == $categoria['codCategoriaEvento'])
																echo '<option value='.$categoria['codCategoriaEvento'].' selected="selected">'.$categoria['desCategoriaEvento'].'</option>';
															else
																echo '<option value='.$categoria['codCategoriaEvento'].'>'.$categoria['desCategoriaEvento'].'</option>';
														}
														
														?>
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
			var novoNomeTipo  = document.getElementById('jform_novonometipo').value;
			var novaCategoria = document.getElementById('jform_categoria').value;
			var cga = document.getElementById('cga').value;
			var origem = 'salvar';
			
			if(novoNomeTipo == '' && novaCategoria == 'padrao')
				alert("Informe o nome do tipo e a categoria a qual ele pertence.");
			else if (novoNomeTipo == '')
				alert("Informe o nome do tipo");
			else if(novaCategoria == 'padrao')
				alert("Informe a categoria a qual o tipo pertence.");
			else{
			window.location.href = "cria_tipo.php?novoNomeTipo=" + novoNomeTipo
			+ "&novaCategoria=" + novaCategoria
			+ "&cga=" + cga
			+ "&origem=" + origem;
			}
		}
		
		function salvarenovo(){
			var novoNomeTipo  = document.getElementById('jform_novonometipo').value;
			var novaCategoria = document.getElementById('jform_categoria').value;
			var cga = document.getElementById('cga').value;
			var origem = 'salvarenovo';
			
			if(novoNomeTipo == '' && novaCategoria == 'padrao')
				alert("Informe o nome do tipo e a categoria a qual ele pertence.");
			else if (novoNomeTipo == '')
				alert("Informe o nome do tipo");
			else if(novaCategoria == 'padrao')
				alert("Informe a categoria a qual o tipo pertence.");
			else{
			window.location.href = "cria_tipo.php?novoNomeTipo=" + novoNomeTipo
			+ "&novaCategoria=" + novaCategoria
			+ "&cga=" + cga
			+ "&origem=" + origem;
			}
		}
	</script>
<?php   require 'rodape.php';
	}
?> 
	