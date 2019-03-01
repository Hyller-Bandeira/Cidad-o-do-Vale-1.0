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
		$sta = '';
		
		if(isset($_GET['id'])) $id = $_GET['id'];
		if(isset($_GET['sta'])) $sta = $_GET['sta'];
		
		//Consultas SQL
		$consulta = $connection->query("SELECT * FROM menu WHERE codMenu = '$id'");
		if(!($linhaDaConsulta = $consulta->fetch_assoc())){
			echo "Erro na consulta : Não foi encontrado dados na tabela menu";
			exit;
		}
		
		require ("cabecalho.php");
		require ("menu.php");?>
		
		<div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
					<ul>
						<li class="button" id="toolbar-apply">
						<a href="#" onclick="salvar(<?php  echo $id; ?>)" class="toolbar">
							<span class="icon-32-apply"></span>
							Salvar
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
				<div class="pagetitle icon-48-menumgr"><h2>Editar Item do Menu</h2></div>
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
											<legend>Editar Item do Menu</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_novonome-lbl" for="jform_novonome" class="hasTip required" title="" aria-invalid="false">Nome
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[novonome]" id="jform_novonome" value="<?php  echo $linhaDaConsulta['nomeItem']; ?>" size="50"  aria-invalid="false">
													<input type="hidden" name="sta" id="sta" value="<?php  echo $sta; ?>">
												</li>
												
												<li>
													<label id="jform_email-lbl" for="jform_endereco" class="hasTip" title="" aria-invalid="false">Endereço
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[endereco]" id="jform_endereco" value="<?php  echo $linhaDaConsulta['enderecoItem']; ?>" size="50" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_faixa_etaria-lbl" for="jform_faixa_etaria" class="hasTip" title="" aria-invalid="false">Status<span class="star">&nbsp;*</span></label>					
													<select id="jform_faixa_etaria" name="jform[faixa_etaria]" aria-invalid="false">
														<?php 
														if($linhaDaConsulta['statusItem'] == '0'){
															echo '<option value="0" selected="selected">Publicado</option>';
															echo '<option value="1">Despublicado</option>';
														}
														if($linhaDaConsulta['statusItem'] == '1'){
															echo '<option value="0">Publicado</option>';
															echo '<option value="1" selected="selected">Despublicado</option>';
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
		function salvar(id){
			var novoNome  = document.getElementById('jform_novonome').value;
			var novoEndereco  = document.getElementById('jform_endereco').value;
			var novoStatus  = document.getElementById('jform_faixa_etaria').value;
			var sta  = document.getElementById('sta').value;
			
			window.location.href = "edita_menu.php?novoNome=" + novoNome 
			+ "&novoEndereco=" + novoEndereco 
			+ "&novoStatus=" + novoStatus
			+ "&id=" + id
			+ "&sta=" + sta;
		}
		
	</script>
<?php   require 'rodape.php';
	}
?> 
	