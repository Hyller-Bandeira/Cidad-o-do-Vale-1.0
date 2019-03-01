<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user_'.$link_inicial]) && !isset($_SESSION['pass_'.$link_inicial])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 
		$categoriaAtual = '';
		
		if(isset($_GET['cga'])) $categoriaAtual = $_GET['cga'];
		if($categoriaAtual == 'padrao')
			$categoriaAtual = '';
		
		//Consultas SQL
		$consulta = $connection->query("SELECT * FROM tipoevento ORDER BY desTipoEvento ASC");
		$numTipos = $consulta->num_rows;
		
		$consulta1 = $connection->query("SELECT * FROM categoriaevento ORDER BY desCategoriaEvento ASC");
		
		if($categoriaAtual != ''){
			$consulta2 = $connection->query("SELECT * FROM tipoevento WHERE codCategoriaEvento = '$categoriaAtual'");
			$numTiposAtual = $consulta2->num_rows;
		}else
			$numTiposAtual = $numTipos;
		
		require ("cabecalho.php");
		require ("menu.php");?>
		
		<div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
					<ul>
						<li class="button" id="toolbar-new">
						<a href="adicionar_tipo.php?cga=<?php  echo $categoriaAtual; ?>" class="toolbar">
							<span class="icon-32-new"></span>
							Adicionar
						</a>
						</li>

						<li class="button" id="toolbar-edit">
							<a href="#" onclick="editar(<?php  echo $numTiposAtual;?>)" class="toolbar">
							<span class="icon-32-edit"></span>
							Editar
							</a>
						</li>
						
						<li class="divider"></li>

						<li class="button" id="toolbar-trash">
							<a href="#" onclick="excluir(<?php  echo $numTiposAtual;?>)" class="toolbar">
							<span class="icon-32-trash"></span>
							Excluir
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-module"><h2>Tipos</h2></div>
			</div>
		</div>
		
		<div id="element-box">
			<div class="m">
				<form action="#" id="application-form" method="post" name="adminForm" class="form-validate">
					<fieldset id="filter-bar">
						<div class="filter-search fltlft">
							<label class="filtro-lbl" for="filtro">Categoria: </label>
							<select name="filtro_categoria" id="filtro_categoria" class="inputbox" onchange="filtro()">
								<?php 	
									if($categoriaAtual == '')
										echo '<option value="padrao" selected="selected">Selecione uma categoria</option>';
									else
										echo '<option value="padrao">Selecione uma categoria</option>';
									while($categoria = $consulta1->fetch_array()){
										if($categoriaAtual == $categoria['codCategoriaEvento'])
											echo '<option value='.$categoria['codCategoriaEvento'].' selected="selected">'.$categoria['desCategoriaEvento'].'</option>';
										else
											echo '<option value='.$categoria['codCategoriaEvento'].'>'.$categoria['desCategoriaEvento'].'</option>';
									}
								?>
							</select>
						</div>
					</fieldset>
					
					<table class="adminlist">
						<thead>
							<tr>
								<th width="1%">
									<input type="checkbox" name="selecionaTodas" id="selecionaTodas" value="" title="Selecionar todos tipos" onclick="selecionar(<?php  echo $numTipos;?>)">
								</th>
								<th>
									Nome	
								</th>
								<th width="20%">
									Categoria
								</th>
							</tr>
						</thead>
						
						<tbody>
							<?php 
							$i = 0;
							while($tipo=$consulta->fetch_array()){
								if($categoriaAtual == $tipo['codCategoriaEvento'] || $categoriaAtual == ''){
									echo '<tr class="row'.($i%2).'">';
										echo '<td class="center">';
											echo '<input type="checkbox" id="cb'.$i.'" name="cid[]" value="'.$tipo['codTipoEvento'].'" title="Selecionar este tipo">';
										echo '</td>';
										echo '<td>';
											echo '<a href="editar_tipo.php?id='.$tipo['codTipoEvento'].'&cga='.$categoriaAtual.'"  style="font-size: 0.85em;">'.$tipo['desTipoEvento'].'</a>';
										echo '</td>';
										$codigo = $tipo['codCategoriaEvento'];
										$consulta1 = $connection->query("SELECT * FROM categoriaevento WHERE codCategoriaEvento = '$codigo'");
											if(!($linhaDaConsulta1 = $consulta1->fetch_assoc())){
												echo "Erro na consulta : Não foi encontrado dados na tabela categoriaevento";
												exit;
											}
											
											$desCategoriaEvento = $linhaDaConsulta1['desCategoriaEvento'];
										
										echo '<td>';
											echo '<span style="font-size: 0.75em;"><center>'.$desCategoriaEvento.'<center></span>';
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
		function selecionar(numTipos){
			if(document.getElementById('selecionaTodas').checked){
				for(i = 0; i < numTipos; i++)
					if(!document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = true;
			}else{
				for(i = 0; i < numTipos; i++)
					if(document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = false;
			}
		}
		
		function editar(numTipos){
			var count = 0;
			var id;
			var categoriaSelecionada = document.getElementById('filtro_categoria').value;
			
			for(i = 0; i < numTipos; i++)
				if(document.getElementById('cb'+i).checked){
					count++;
					id = document.getElementById('cb'+i).value;
				}
					
			if(count == 0)
				alert("Você deve selecionar um tipo para ser editado!");
			else if(count > 1)
				alert("Você deve selecionar somente um tipo para ser editado!");
			else{
				window.location.href = "editar_tipo.php?id=" + id
				+ "&cga=" + categoriaSelecionada;
			}
		}
		
		function excluir(numTipos){
			var count = 0;
			var id = new Array();
			var categoriaSelecionada = document.getElementById('filtro_categoria').value;
			
			for(i = 0; i < numTipos; i++)
				if(document.getElementById('cb'+i).checked){
					id[count] = document.getElementById('cb'+i).value;
					count++;
				}
			
			var link = "?count=" + count;	
			
			for(i = 0; i < count; i++){
				link += "&id" + i + "=" + id[i];
			}
			if (confirm('Você realmente deseja excluir o(s) tipo(s) selecionado(s)?'))
				window.location.href = "excluir_tipo.php" + link
				+ "&cga=" + categoriaSelecionada;
		}
		
		function filtro(){
			var categoriaSelecionada = document.getElementById('filtro_categoria').value;
			window.location.href = "listar_tipos.php?cga=" + categoriaSelecionada;
		}
		
	</script>
	
<?php   require 'rodape.php';
	}
?> 