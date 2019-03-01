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
		$tpa = '';
		
		if(isset($_GET['id'])) $id = $_GET['id'];
		if(isset($_GET['tpa'])) $tpa = $_GET['tpa'];
		
		//Consultas SQL
		$consulta = $connection->query("SELECT * FROM usuario WHERE codUsuario = '$id'");
		if(!($linhaDaConsulta = $consulta->fetch_assoc())){
			echo "Erro na consulta : Não foi encontrado dados na tabela usuario";
			exit;
		}
		
		$codigoClasse = $linhaDaConsulta['classeUsuario'];
		
		$consulta1 = $connection->query("SELECT * FROM classesdeusuarios WHERE codClasse = '$codigoClasse'");
		if(!($linhaDaConsulta1 = $consulta1->fetch_assoc())){
			echo "Erro na consulta : Não foi encontrado dados na tabela classesdeusuarios";
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
							<a href="listar_usuarios.php?tpa=<?php  echo $tpa; ?>" class="toolbar">
							<span class="icon-32-cancel"></span>
							Cancelar
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-category-edit"><h2>Editar Usuário</h2></div>
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
											<legend>Editar Usuário</legend>
											<ul class="adminformlist">
												<li>
													<label id="jform_novonome-lbl" for="jform_novonome" class="hasTip required" title="" aria-invalid="false">Nome
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[novonome]" id="jform_novonome" value="<?php  echo $linhaDaConsulta['nomPessoa']; ?>" size="50"  aria-invalid="false">
													<input type="hidden" name="tpa" id="tpa" value="<?php  echo $tpa; ?>">
												</li>
												
												<li>
													<label id="jform_email-lbl" for="jform_email" class="hasTip" title="" aria-invalid="false">Email
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[email]" id="jform_email" value="<?php  echo $linhaDaConsulta['endEmail']; ?>" size="50" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_faixa_etaria-lbl" for="jform_faixa_etaria" class="hasTip" title="" aria-invalid="false">Faixa Etária</label>					
													<select id="jform_faixa_etaria" name="jform[faixa_etaria]" aria-invalid="false">
														<?php 
														if($linhaDaConsulta['faixaEtaria'] == '')
															echo '<option value="0" selected="selected">Selecione uma faixa etária</option>';
														if($linhaDaConsulta['faixaEtaria'] == '0 - 17')
															echo '<option value="0" selected="selected">até 17 anos</option>';
														else
															echo '<option value="0">até 17 anos</option>';
														
														if($linhaDaConsulta['faixaEtaria'] == '18 - 25')
															echo '<option value="1" selected="selected">18 - 25 anos</option>';
														else
															echo '<option value="1">18 - 25 anos</option>';
														
														if($linhaDaConsulta['faixaEtaria'] == '26 - 64')
															echo '<option value="2" selected="selected">26 - 65 anos</option>';
														else
															echo '<option value="2">26 - 65 anos</option>';
															
														if($linhaDaConsulta['faixaEtaria'] == 'mais de 65')
															echo '<option value="3" selected="selected">mais de 65 anos</option>';
														else
															echo '<option value="3">mais de 65 anos</option>';
														
														?>
													</select>
												</li>
												
												<li>
													<label id="jform_tipo-lbl" for="jform_tipo" class="hasTip" title="">Tipo de usuário<span class="star">&nbsp;*</span></label>			
													<fieldset id="jform_tipo" class="radio">
														<?php 
														if($linhaDaConsulta['tipoUsuario'] == 'A'){
															echo '<input type="radio" id="jform_tipo0" name="jform[tipo]" value="1" checked="checked">';
															echo '<label for="jform_tipo0">Administrador</label>';
															echo '<input type="radio" id="jform_tipo1" name="jform[tipo]" value="0">';
															echo '<label for="jform_tipo1">Colaborador</label>';
														}
														else{
															echo '<input type="radio" id="jform_tipo0" name="jform[tipo]" value="1">';
															echo '<label for="jform_tipo0">Administrador</label>';
															echo '<input type="radio" id="jform_tipo1" name="jform[tipo]" value="0" checked="checked">';
															echo '<label for="jform_tipo1">Colaborador</label>';
														}
														?>
													</fieldset>
												</li>
												
												<li>
													<label id="jform_email-lbl" for="jform_email" class="hasTip" title="" aria-invalid="false">Pontuação
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="text" name="jform[pontuacao]" id="jform_pontuacao" value="<?php  echo $linhaDaConsulta['pontos']; ?>" size="10" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_email-lbl" for="jform_email" class="hasTip" title="" aria-invalid="false">Classe de Usuário</label>					
													<input type="text" name="jform[classe]" id="jform_classe" value="<?php  echo $linhaDaConsulta1['nomeClasse']; ?>" size="30" readonly="readonly" class="required" aria-required="true" required="required" aria-invalid="false">
												</li>
												
												
												
											</ul>
										</fieldset>
									</div>
									
								</div>
								
								<div class="width-40 fltrt">
									<div class="width-100">
										<fieldset class="adminform long">
											<legend>Alterar Senha</legend>
											<ul class="adminformlist">												
												<li>
													<label id="jform_nova_senha-lbl" for="jform_nova_senha" class="hasTip required" title="" aria-invalid="false">Nova Senha
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="password" name="jform[nova_senha]" id="jform_nova_senha" value="" size="50" aria-invalid="false">
												</li>
												
												<li>
													<label id="jform_repita_nova_senha-lbl" for="jform_repita_nova_senha" class="hasTip required" title="" aria-invalid="false">Repita Nova Senha
														<span class="star">&nbsp;*</span>
													</label>					
													<input type="password" name="jform[repita_nova_senha]" id="jform_repita_nova_senha" value="" size="50" aria-invalid="false">
												</li>
																
											</ul>
										</fieldset>
									</div>
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
		<?php
		$erroAux = '';
		if(isset($_GET['erro'])) $erroAux = $_GET['erro'];
		
		if ($erroAux == 1){
		
		?>					
			document.getElementById("mensagem_erro").innerHTML = 'ATENÇÃO: Login ou Senha Inválidos';
			form.login.focus();
			//return;
			<?php }
		?>
		
		function salvar(id){
			var novoNome  = document.getElementById('jform_novonome').value;
			var novoEmail  = document.getElementById('jform_email').value;
			var novaFaixaEtaria  = document.getElementById('jform_faixa_etaria').value;
			var novoTipo  = '';
			var novaPontuação  = document.getElementById('jform_pontuacao').value;
			var novaSenha  = document.getElementById('jform_nova_senha').value;
			var repNovaSenha  = document.getElementById('jform_repita_nova_senha').value;	
			var tpa  = document.getElementById('tpa').value;		
			
			if(novaFaixaEtaria == '0')
				novaFaixaEtaria = '0 - 17';
			else if(novaFaixaEtaria == '1')
				novaFaixaEtaria = '18 - 25';
			else if(novaFaixaEtaria == '2')
				novaFaixaEtaria = '26 - 65';
			else
				novaFaixaEtaria = 'mais de 65';
			
			if(document.getElementById('jform_tipo0').checked)
				novoTipo = 'A';
			else
				novoTipo = 'C';
				
			if(novaSenha == '' || validar()){
				window.location.href = "edita_usuario.php?novoNome=" + novoNome 
				+ "&novoEmail=" + novoEmail 
				+ "&novaFaixaEtaria=" + novaFaixaEtaria
				+ "&novoTipo=" + novoTipo
				+ "&novaPontuação=" + novaPontuação
				+ "&novaSenha=" + novaSenha
				+ "&repNovaSenha=" + repNovaSenha
				+ "&id=" + id
				+ "&tpa=" + tpa;
			}else
				window.location.href = "editar_usuario.php";
			
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
		var senha = document.getElementById("jform_nova_senha").value;
		var rep_senha = document.getElementById("jform_repita_nova_senha").value;
		
		if (senha.length < 6) {
		document.getElementById("mensagem_erro").innerHTML = 'ATENÇÃO: Sua senha deve conter no mínimo 6 caracteres';
		cadastro.senha.focus();
		return false;
		}

		if (rep_senha == "") {
		document.getElementById("mensagem_erro").innerHTML = 'ATENÇÃO: Confirme a sua senha';
		cadastro.senha2.focus();
		return false;
		}
		
		if (senha != rep_senha) {
		document.getElementById("mensagem_erro").innerHTML = "ATENÇÃO: Sua senha não confere";
		cadastro.senha2.focus();
		return false;
		}
		
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
<?php   require 'rodape.php';
	}
?> 
	