<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 
		$statusAtual = '';
		
		if(isset($_GET['sta'])) $statusAtual = $_GET['sta'];
		if($statusAtual == 'padrao')
			$statusAtual = '';
		
		//Consultas SQL
		$consulta = mysql_query("SELECT * FROM menu ORDER BY ordemItem ASC");
		$numItens = mysql_num_rows($consulta);
		
		if($statusAtual != ''){
			$consulta2 = mysql_query("SELECT * FROM menu WHERE statusItem = '$statusAtual'");
			$numItensAtual = mysql_num_rows($consulta2);
		}else
			$numItensAtual = $numItens;
		
		require ("cabecalho.php");
		require ("menu.php");?>
		
		<div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
					<ul>
						<li class="button" id="toolbar-new">
						<a href="adicionar_menu.php?sta=<?php  echo $statusAtual; ?>" class="toolbar">
							<span class="icon-32-new"></span>
							Adicionar
						</a>
						</li>

						<li class="button" id="toolbar-edit">
							<a href="#" onclick="editar(<?php  echo $numItensAtual;?>)" class="toolbar">
							<span class="icon-32-edit"></span>
							Editar
							</a>
						</li>
						
						<li class="divider"></li>
						
						<li class="button" id="toolbar-publicar">
							<a href="#" onclick="publicar(<?php  echo $numItensAtual;?>)" class="toolbar">
							<span class="icon-32-publish"></span>
							Publicar
							</a>
						</li>
						
						<li class="button" id="toolbar-despublicar">
							<a href="#" onclick="despublicar(<?php  echo $numItensAtual;?>)" class="toolbar">
							<span class="icon-32-unpublish"></span>
							Despublicar
							</a>
						</li>
						
						<li class="divider"></li>

						<li class="button" id="toolbar-trash">
							<a href="#" onclick="excluir(<?php  echo $numItensAtual;?>)" class="toolbar">
							<span class="icon-32-trash"></span>
							Excluir
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-levels"><h2>Itens do Menu</h2></div>
			</div>
		</div>
		
		<div id="element-box">
			<div class="m">
				<form action="#" id="application-form" method="post" name="adminForm" class="form-validate">
					<fieldset id="filter-bar">
						<div class="filter-search fltlft">
							<label class="filtro-lbl" for="filtro">Status: </label>
							<select name="filtro_status_item" id="filtro_status_item" class="inputbox" onchange="filtro()">
								<?php 	
									if($statusAtual == ''){
										echo '<option value="padrao" selected="selected">Selecione um status</option>';
										echo '<option value="0">Publicados</option>';
										echo '<option value="1">Despublicados</option>';
									}
									else
										echo '<option value="padrao">Selecione um status</option>';
								
									if($statusAtual == '0'){
										echo '<option value="0" selected="selected">Publicados</option>';
										echo '<option value="1">Despublicados</option>';
									}
									else if($statusAtual == '1'){
										echo '<option value="0">Publicados</option>';
										echo '<option value="1" selected="selected">Despublicados</option>';
									}
								?>
							</select>
						</div>
					</fieldset>
					
					<table class="adminlist">
						<thead>
							<tr>
								<th width="1%">
									<input type="checkbox" name="selecionaTodas" id="selecionaTodas" value="" title="Selecionar todos tipos" onclick="selecionar(<?php  echo $numItens;?>)">
								</th>
								<th>
									Nome	
								</th>
								<th width="7%">
									Ordem
								</th>
								<th width="40%">
									Status
								</th>
							</tr>
						</thead>
						
						<tbody>
							<?php 
							$i = 0;
							while($itemMenu=mysql_fetch_array($consulta)){
								if($statusAtual == $itemMenu['statusItem'] || $statusAtual == ''){
									echo '<tr class="row'.($i%2).'">';
										echo '<td class="center">';
											echo '<input type="checkbox" id="cb'.$i.'" name="cid[]" value="'.$itemMenu['codMenu'].'" title="Selecionar este item">';
										echo '</td>';
										echo '<td>';
											echo '<a href="editar_menu.php?id='.$itemMenu['codMenu'].'"  style="font-size: 0.85em;">'.$itemMenu['nomeItem'].'</a>';
										echo '</td>';
										
										echo '<td class="order" >';
										
										if($i != 0){
											echo '<span>
													<a class="jgrid" href="#" onclick="subir('. $itemMenu['codMenu'] .')" title="Mover para cima">
													    <span class="state uparrow">
														    <span class="text">Mover para cima</span>
														</span>
													</a>
												</span>';
										}else{
											echo '<span>
													<span class="state uparrow_disabled"></span>
												  </span>';
										}
										
										if($i == $numItensAtual - 1){
											echo '<span>
														<span class="state downarrow_disabled"></span>
												  </span>';
										}else{
											echo '<span>
														<a class="jgrid" href="#" onclick="descer('. $itemMenu['codMenu'] .')" title="Mover para baixo">
															<span class="state downarrow">
																<span class="text">Mover para baixo</span>
															</span>
														</a>
													</span>';
										}
										echo '</td>';
										
										if($itemMenu['statusItem'] == '0'){
											echo '<td>';
												echo '<span style="font-size: 0.75em; color: green; font-weight: bold;"><center>Publicado<center></span>';
											echo '</td>';
										}
										else{
											echo '<td>';
												echo '<span style="font-size: 0.75em; color: red; font-weight: bold;"><center>Despublicado<center></span>';
											echo '</td>';
										}
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
		function selecionar(numItens){
			if(document.getElementById('selecionaTodas').checked){
				for(i = 0; i < numItens; i++)
					if(!document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = true;
			}else{
				for(i = 0; i < numItens; i++)
					if(document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = false;
			}
		}
		
		function editar(numItens){
			var count = 0;
			var id;
			var tipoSelecionado = document.getElementById('filtro_status_item').value;
			
			for(i = 0; i < numItens; i++)
				if(document.getElementById('cb'+i).checked){
					count++;
					id = document.getElementById('cb'+i).value;
				}
					
			if(count == 0)
				alert("Você deve selecionar um item para ser editado!");
			else if(count > 1)
				alert("Você deve selecionar somente um item para ser editado!");
			else{
				window.location.href = "editar_menu.php?id=" + id
				+ "&sta=" + tipoSelecionado;
			}
		}
		
		function publicar(numItens){
			var count = 0;
			var id = new Array();
			var tipoSelecionado = document.getElementById('filtro_status_item').value;
			var origem = "Publicar";
			
			for(i = 0; i < numItens; i++)
				if(document.getElementById('cb'+i).checked){
					id[count] = document.getElementById('cb'+i).value;
					count++;
				}
			
			var link = "?count=" + count;	
			
			for(i = 0; i < count; i++){
				link += "&id" + i + "=" + id[i];
			}
			if(count == 0)
				alert("Você deve selecionar um item para ser publicado!");
			else if (confirm('Você realmente deseja publicar o(s) item(ns) selecionado(s)?'))
				window.location.href = "publicar_menu.php" + link
				+ "&sta=" + tipoSelecionado
				+ "&origem=" + origem;
		}
		
		function despublicar(numItens){
			var count = 0;
			var id = new Array();
			var tipoSelecionado = document.getElementById('filtro_status_item').value;
			var origem = "Despublicar";
			
			for(i = 0; i < numItens; i++)
				if(document.getElementById('cb'+i).checked){
					id[count] = document.getElementById('cb'+i).value;
					count++;
				}
			
			var link = "?count=" + count;	
			
			for(i = 0; i < count; i++){
				link += "&id" + i + "=" + id[i];
			}
			if(count == 0)
				alert("Você deve selecionar um item para ser despublicado!");
			else if (confirm('Você realmente deseja despublicar o(s) item(ns) selecionado(s)?'))
				window.location.href = "publicar_menu.php" + link
				+ "&sta=" + tipoSelecionado
				+ "&origem=" + origem;
		}
		
		function excluir(numItens){
			var count = 0;
			var id = new Array();
			var tipoSelecionado = document.getElementById('filtro_status_item').value;
			
			for(i = 0; i < numItens; i++)
				if(document.getElementById('cb'+i).checked){
					id[count] = document.getElementById('cb'+i).value;
					count++;
				}
			
			var link = "?count=" + count;	
			
			for(i = 0; i < count; i++){
				link += "&id" + i + "=" + id[i];
			}
			if (confirm('Você realmente deseja excluir o(s) item(ns) selecionado(s)?'))
				window.location.href = "excluir_menu.php" + link
				+ "&sta=" + tipoSelecionado;
		}
		
		function subir(id){
			var tipoSelecionado = document.getElementById('filtro_status_item').value;
			var origem = "Subir";
			
			window.location.href = "ordem_menu.php"
				+ "?sta=" + tipoSelecionado
				+ "&id=" + id
				+ "&origem=" + origem;
		}
		
		function descer(id){
			var tipoSelecionado = document.getElementById('filtro_status_item').value;
			var origem = "Descer";
			
			window.location.href = "ordem_menu.php"
				+ "?sta=" + tipoSelecionado
				+ "&id=" + id
				+ "&origem=" + origem;
		}
		
		function filtro(){
			var tipoSelecionado = document.getElementById('filtro_status_item').value;
			window.location.href = "listar_menu.php?sta=" + tipoSelecionado;
		}
		
		
	</script>
	
<?php   require('rodape.php');
	}
?> 