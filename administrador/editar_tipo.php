<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user_admin_'.$link_inicial]) && !isset($_SESSION['pass_admin_'.$link_inicial])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 
		$id = '';
		$cga = '';
		
		if(isset($_GET['id'])) $id = $_GET['id'];
		if(isset($_GET['cga'])) $cga = $_GET['cga'];
		
		//Consultas SQL
		$consulta = $connection->query("SELECT * FROM tipoevento WHERE codTipoEvento = '$id'");
		if(!($linhaDaConsulta = $consulta->fetch_assoc())){
			echo "Erro na consulta : Não foi encontrado dados na tabela categoriaevento";
			exit;
		}
		
		$consulta1 = $connection->query("SELECT * FROM categoriaevento ORDER BY desCategoriaEvento ASC");
		
		$desCategoriaEvento = $linhaDaConsulta['desTipoEvento'];
		$codCategoriaEvento = $linhaDaConsulta['codCategoriaEvento'];
		
		require ("cabecalho.php");
		require ("menu.php");?>
		
		<div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
					<ul>
						<li class="button" id="toolbar-apply">
						<a href="#" onclick="salvar(<?php  echo $id.", ".$cga; ?>)" class="toolbar">
							<span class="icon-32-apply"></span>
							Salvar
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
				<div class="pagetitle icon-48-category-edit"><h2>Editar tipo</h2></div>
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
											<legend>Editar Tipo</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_novonometipo-lbl" for="jform_novonometipo" class="hasTip required" title="" aria-invalid="false">Nome
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[novonometipo]" id="jform_novonometipo" value="<?php  echo $desCategoriaEvento; ?>" size="50"  aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_categoria-lbl" for="jform_categoria" class="hasTip required" title="" aria-invalid="false">Categoria
														<span class="star">&nbsp;*</span>
													</label>					
													<select id="jform_categoria" name="jform[editor]" aria-invalid="false">
														<?php 
														while($categoria = $consulta1->fetch_array()){
															if($categoria['codCategoriaEvento'] == $codCategoriaEvento)
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
		function salvar(id, cga){
			var novoNomeTipo  = document.getElementById('jform_novonometipo').value;
			var novaCategoria = document.getElementById('jform_categoria').value;
			
			if(novoNomeTipo == '')
				alert("Informe o novo nome para o tipo");
			else{
				window.location.href = "edita_tipo.php?novoNomeTipo=" + novoNomeTipo
				+ "&id=" + id
				+ "&novaCategoria=" + novaCategoria
				+ "&cga=" + cga;
			}
		}
	</script>
<?php   require 'rodape.php';
	}
?> 
	