<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 
		$tipoAtual = '';
		$anm = '';
		
		if(isset($_GET['tpa'])) $tipoAtual = $_GET['tpa'];
		if($tipoAtual == 'padrao')
			$tipoAtual = '';
		
		$anm = '';
		if(isset($_GET['anm'])) $anm = $_GET['anm'];
		
		//Consultas SQL
		$consulta = mysql_query("SELECT * FROM usuario ORDER BY nomPessoa ASC");
		$numUsuarios = mysql_num_rows($consulta);
		
		$consulta1 = mysql_query("SELECT * FROM categoriaevento ORDER BY desCategoriaEvento ASC");
		
		if($tipoAtual != ''){
			$consulta2 = mysql_query("SELECT * FROM usuario WHERE codUsuario = '$tipoAtual'");
			$numUsuariosAtual = mysql_num_rows($consulta2);
		}else
			$numUsuariosAtual = $numUsuarios;
		
		require ("cabecalho.php");
		require ("menu.php");?>
		
		<div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
					<ul>
						<li class="button" id="toolbar-new">
						<a href="adicionar_usuario.php?tpa=<?php  echo $tipoAtual; ?>" class="toolbar">
							<span class="icon-32-new"></span>
							Adicionar
						</a>
						</li>

						<li class="button" id="toolbar-edit">
							<a href="#" onclick="editar(<?php  echo $numUsuariosAtual;?>)" class="toolbar">
							<span class="icon-32-edit"></span>
							Editar
							</a>
						</li>
						
						<li class="divider"></li>

						<li class="button" id="toolbar-trash">
							<a href="#" onclick="excluir(<?php  echo $numUsuariosAtual;?>)" class="toolbar">
							<span class="icon-32-trash"></span>
							Excluir
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-user"><h2>Usuários</h2></div>
			</div>
		</div>
		
		<div id="element-box">
			<div class="m">
				<form action="#" id="application-form" method="post" name="adminForm" class="form-validate">
					<fieldset id="filter-bar">
						<div class="filter-search fltlft">
							<label class="filtro-lbl" for="filtro">Tipo: </label>
							<select name="filtro_tipo_usuario" id="filtro_tipo_usuario" class="inputbox" onchange="filtro()">
								<?php 	
									if($tipoAtual == ''){
										echo '<option value="padrao" selected="selected">Selecione um tipo de usuário</option>';
										echo '<option value="A">Administradores</option>';
										echo '<option value="C">Colaboradores</option>';
									}
									else
										echo '<option value="padrao">Selecione um tipo de usuário</option>';
								
									if($tipoAtual == 'A'){
										echo '<option value="A" selected="selected">Administradores</option>';
										echo '<option value="C">Colaboradores</option>';
									}
									else if($tipoAtual == 'C'){
										echo '<option value="A">Administradores</option>';
										echo '<option value="C" selected="selected">Colaboradores</option>';
									}
								?>
							</select>
						</div>
					</fieldset>
					
					<table class="adminlist">
						<thead>
							<tr>
								<th width="1%">
									<input type="checkbox" name="selecionaTodas" id="selecionaTodas" value="" title="Selecionar todos tipos" onclick="selecionar(<?php  echo $numUsuarios;?>)">
								</th>
								<th>
									Nome	
								</th>
								<th width="25%">
									Email
								</th>
								<th width="15%">
									Tipo de Usuário
								</th>
								<th width="10%">
									Pontos
								</th>
								<th width="10%">
									Faixa Etária
								</th>
							</tr>
						</thead>
						
						<tbody>
							<?php 
							$i = 0;
							while($usuario=mysql_fetch_array($consulta)){
								if($tipoAtual == $usuario['tipoUsuario'] || $tipoAtual == '' || $anm == 's'){
									echo '<tr class="row'.($i%2).'">';
										echo '<td class="center">';
											echo '<input type="checkbox" id="cb'.$i.'" name="cid[]" value="'.$usuario['codUsuario'].'" title="Selecionar este usuario">';
										echo '</td>';
										echo '<td>';
											echo '<a href="editar_usuario.php?id='.$usuario['codUsuario'].'"  style="font-size: 0.85em;">'.$usuario['nomPessoa'].'</a>';
										echo '</td>';
										echo '<td>';
											echo '<span style="font-size: 0.75em;"><center>'.$usuario['endEmail'].'<center></span>';
										echo '</td>';
										if($usuario['tipoUsuario'] == 'A'){
											echo '<td>';
												echo '<span style="font-size: 0.75em;"><center>Administrador<center></span>';
											echo '</td>';
										}
										else{
											echo '<td>';
												echo '<span style="font-size: 0.75em;"><center>Colaborador<center></span>';
											echo '</td>';
										}
										echo '<td>';
											echo '<span style="font-size: 0.75em;"><center>'.$usuario['pontos'].'<center></span>';
										echo '</td>';
										echo '<td>';
											echo '<span style="font-size: 0.75em;"><center>'.$usuario['faixaEtaria'].'<center></span>';
										echo '</td>';
									echo '</tr>';
									$i++;
								}
							}
							?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</html>
	
	<script  type="text/javascript">
		function selecionar(numUsuarios){
			if(document.getElementById('selecionaTodas').checked){
				for(i = 0; i < numUsuarios; i++)
					if(!document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = true;
			}else{
				for(i = 0; i < numUsuarios; i++)
					if(document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = false;
			}
		}
		
		function editar(numUsuarios){
			var count = 0;
			var id;
			var tipoSelecionado = document.getElementById('filtro_tipo_usuario').value;
			
			for(i = 0; i < numUsuarios; i++)
				if(document.getElementById('cb'+i).checked){
					count++;
					id = document.getElementById('cb'+i).value;
				}
					
			if(count == 0)
				alert("Você deve selecionar um usuário para ser editado!");
			else if(count > 1)
				alert("Você deve selecionar somente um usuário para ser editado!");
			else{
				window.location.href = "editar_usuario.php?id=" + id
				+ "&tpa=" + tipoSelecionado;
			}
		}
		
		function excluir(numUsuarios){
			var count = 0;
			var id = new Array();
			var tipoSelecionado = document.getElementById('filtro_tipo_usuario').value;
			
			for(i = 0; i < numUsuarios; i++)
				if(document.getElementById('cb'+i).checked){
					id[count] = document.getElementById('cb'+i).value;
					count++;
				}
			
			var link = "?count=" + count;	
			
			for(i = 0; i < count; i++){
				link += "&id" + i + "=" + id[i];
			}
			if (confirm('Você realmente deseja excluir o(s) usuario(s) selecionado(s)?'))
				window.location.href = "excluir_usuario.php" + link
				+ "&tpa=" + tipoSelecionado;
		}
		
		function filtro(){
			var tipoSelecionado = document.getElementById('filtro_tipo_usuario').value;
			window.location.href = "listar_usuarios.php?tpa=" + tipoSelecionado;
		}
		
		function exibeanonimos(){
			if(document.getElementById('exibe_anonimos').checked)
				window.location.href = "listar_usuarios.php?tpa=" + tipoSelecionado + "&anm=s";
			else
				window.location.href = "listar_usuarios.php?tpa=" + tipoSelecionado + "&anm=";
		}
		
	</script>
	
<?php   require('rodape.php');
	}
?> 