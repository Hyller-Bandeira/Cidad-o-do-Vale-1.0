<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 
		$msg = '';
		if(isset($_GET['msg'])) $msg = $_GET['msg'];
		
		//Consultas SQL
		$consulta = mysql_query("SELECT * FROM categoriaevento ORDER BY desCategoriaEvento ASC");
		$numCategorias = mysql_num_rows($consulta);
		
		require ("cabecalho.php");
		require ("menu.php");?>
		
		<div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
					<ul>
						<li class="button" id="toolbar-new">
						<a href="adicionar_categoria.php" class="toolbar">
							<span class="icon-32-new"></span>
							Adicionar
						</a>
						</li>

						<li class="button" id="toolbar-edit">
							<a href="#" onclick="editar(<?php  echo $numCategorias;?>)" class="toolbar">
							<span class="icon-32-edit"></span>
							Editar
							</a>
						</li>
						
						<li class="divider"></li>

						<li class="button" id="toolbar-trash">
							<a href="#" onclick="excluir(<?php  echo $numCategorias;?>)" class="toolbar">
							<span class="icon-32-trash"></span>
							Excluir
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-categories"><h2>Categorias</h2></div>
			</div>
		</div>
		
		<div id="element-box">
			<div class="m">
				<form action="#" id="application-form" method="post" name="listarCategorias" class="form-validate">
					<table class="adminlist">
						<thead>
							<tr>
								<th width="1%">
									<input type="checkbox" name="selecionaTodas" id="selecionaTodas" value="" title="Selecionar todas categorias" onclick="selecionar(<?php  echo $numCategorias;?>)">
								</th>
								<th>
									Nome	
								</th>
							</tr>
						</thead>
						
						<tbody>
							<?php 
							$i = 0;
							while($categoria=mysql_fetch_array($consulta)){
								echo '<tr class="row'.($i%2).'">';
									echo '<td class="center">';
										echo '<input type="checkbox" id="cb'.$i.'" name="cid[]" value="'.$categoria['codCategoriaEvento'].'" title="Selecionar esta categoria">';
									echo '</td>';
									echo '<td>';
										echo '<a href="editar_categoria.php?id='.$categoria['codCategoriaEvento'].'"  style="font-size: 0.85em;">'.$categoria['desCategoriaEvento'].'</a>';
									echo '</td>';
								echo '</tr>';
							$i++;
							}
							?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
		<?php 
		if($msg)
			echo '<script>alert("Existe tipos que fazem parte da categoria que você deseja apagar, remova os tipos primeiro.");</script>';
		?>
			
	</html>
	
	<script  type="text/javascript">
		function selecionar(numCategoria){
			if(document.getElementById('selecionaTodas').checked){
				for(i = 0; i < numCategoria; i++)
					if(!document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = true;
			}else{
				for(i = 0; i < numCategoria; i++)
					if(document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = false;
			}
		}
		
		function editar(numCategoria){
			var count = 0;
			var id;
			
			for(i = 0; i < numCategoria; i++)
				if(document.getElementById('cb'+i).checked){
					count++;
					id = document.getElementById('cb'+i).value;
				}
					
			if(count == 0)
				alert("Você deve selecionar uma categoria para ser editada!");
			else if(count > 1)
				alert("Você deve selecionar somente uma categoria para ser editada!");
			else{
				window.location.href = "editar_categoria.php?id=" + id;
			}
		}
		
		function excluir(numCategoria){
			var count = 0;
			var id = new Array();
			
			for(i = 0; i < numCategoria; i++)
				if(document.getElementById('cb'+i).checked){
					id[count] = document.getElementById('cb'+i).value;
					count++;
				}
			
			var link = "?count=" + count;	
			
			for(i = 0; i < count; i++){
				link += "&id" + i + "=" + id[i];
			}
			if (confirm('Você realmente deseja excluir a(s) categoria(s) selecionada(s)?'))
				window.location.href = "excluir_categoria.php" + link;
		}
	</script>
	
<?php   require('rodape.php');
	}
?> 