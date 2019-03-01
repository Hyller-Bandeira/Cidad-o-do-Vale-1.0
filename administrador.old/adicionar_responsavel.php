<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 
		$tpa = '';
		if(isset($_GET['tpa'])) $tpa = $_GET['tpa'];
		
		$consulta = mysql_query("SELECT * FROM categoriaevento ORDER BY desCategoriaEvento ASC");
		
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
							<a href="listar_usuarios.php?tpa=<?php  echo $tpa; ?>" class="toolbar">
							<span class="icon-32-cancel"></span>
							Cancelar
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-user-add"><h2>Novo Usuário</h2></div>
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
											<legend>Informações do Responsável</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_nome-lbl" for="jform_nome" class="hasTip required" title="" aria-invalid="false">Nome
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[nome]" id="jform_nome" value="" size="50" aria-invalid="false">
													<input type="hidden" name="tpa" id="tpa" value="<?php  echo $tpa; ?>">
												</li>
												
												<li>
													<label id="jform_email-lbl" for="jform_email" class="hasTip" title="" aria-invalid="false">Email
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[email]" id="jform_email" value="" size="50" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_rep_email-lbl" for="jform_rep_email" class="hasTip" title="" aria-invalid="false">Repíta o Email
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[rep_email]" id="jform_rep_email" value="" size="50" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_coordenada-lbl" for="jform_rep_email" class="hasTip" title="" aria-invalid="false">Localização
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[coordenada]" id="jform_coordenada" value="" size="50" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_categoria-lbl" for="jform_categoria" class="hasTip required" title="" aria-invalid="false">Categoria
														<span class="star">&nbsp;*</span>
													</label>					
													<select id="jform_categoria" name="jform[editor]" aria-invalid="false">
														<?php 
														if($cga == '')
															echo '<option value="padrao" selected="selected">Selecione uma categoria</option>';
														while($categoria = mysql_fetch_array($consulta)){
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
								
								<div class="width-40 fltrt">
								
								</div>
								
								<div class="width-40 fltrt">
									<div class="width-100">
										<fieldset class="adminform long" >
											<label id="mensagem_erro"></label>
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
			var novoNome  = document.getElementById('jform_nome').value;
			var novoEmail  = document.getElementById('jform_email').value;
			var repNovoEmail = document.getElementById('jform_rep_email').value;
			var novaCoordenada  = document.getElementById('jform_coordenada').value;
			var novaCategoria = document.getElementById('jform_categoria').value;
			var origem = 'salvar';
			if(validar()){
				window.location.href = "cria_responsavel.php?novoNome=" + novoNome 
				+ "&novoEmail=" + novoEmail
				+ "&repNovoEmail=" + repNovoEmail				
				+ "&novaCoordenada=" + novaCoordenada
				+ "&novaCategoria=" + novaCategoria
				+ "&origem=" + origem
				+ "&tpa=" + tpa;
			}else
				window.location.href = "listar_responsaveis.php";
			
		}
		
		function salvarenovo(id){
			var novoNome  = document.getElementById('jform_nome').value;
			var novoEmail  = document.getElementById('jform_email').value;
			var repNovoEmail = document.getElementById('jform_rep_email').value;
			var novaCoordenada  = document.getElementById('jform_coordenada').value;	
			var novaCategoria = document.getElementById('jform_categoria').value;
			var origem = 'salvarenovo';
			var tpa = document.getElementById('tpa').value;
			
			if(validar()){
				window.location.href = "cria_responsavel.php?novoNome=" + novoNome 
				+ "&novoEmail=" + novoEmail
				+ "&repNovoEmail=" + repNovoEmail				
				+ "&novaCoordenada=" + novaCoordenada
				+ "&novaCategoria=" + novaCategoria
				+ "&origem=" + origem
				+ "&tpa=" + tpa;
			}else
				window.location.href = "listar_responsaveis.php";
			
		}
		/*
		function verifica_email(){
		
		if(window.XMLHttpRequest){	// codigo para IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// codigo para IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		
		var endEmail = document.getElementById("endEmail").value;
					
		xmlhttp.open("GET", "verifica_email.php?endEmail=" + endEmail , true);				
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				results = xmlhttp.responseText;
				if (results == "0"){
					document.getElementById("mens_erro_cadastro").innerHTML = 'ATENÇÃO: Email já cadastrado';
					cadastro.endEmail.focus();
					document.getElementById("submit_registro").disabled=true;
				}
				else{
					document.getElementById("mens_erro_cadastro").innerHTML ="";
					document.getElementById("submit_registro").disabled=false;
				}
				//alert (results);							
			}
		}
		xmlhttp.send(null);
		//
		//tirar o submit		
	}
	*/
	
	function validar() {
		var email = document.getElementById("jform_email").value;
		
		if(!valida_email(email)){
			document.getElementById("mensagem_erro").innerHTML = 'ATENÇÃO: Este endereço de email é inválido';
			cadastro.endEmail.focus();
			return false;
		}
		return true;
	}
	
	function valida_email(email){
		var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
		var check=/@[\w\-]+\./;
		var checkend=/\.[a-zA-Z]{2,3}$/;
		if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
		else {return true;}
	}			
	
	</script>
<?php   require('rodape.php');
	}
?> 
	