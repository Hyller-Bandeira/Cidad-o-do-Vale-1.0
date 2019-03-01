<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user_admin_'.$link_inicial]) && !isset($_SESSION['pass_admin_'.$link_inicial])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<?php 		
		//Consultas SQL
		$consulta = $connection->query("SELECT * FROM classesdeusuarios ORDER BY codClasse ASC");
		$numClasses = $consulta->num_rows;
		
		
		require ("cabecalho.php");
		require ("menu.php");?>
		
		<div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
					<ul>
						<li class="button" id="toolbar-new">
						<a href="adicionar_classe.php" class="toolbar">
							<span class="icon-32-new"></span>
							Adicionar
						</a>
						</li>

						<li class="button" id="toolbar-edit">
							<a href="#" onclick="editar(<?php  echo $numClasses;?>)" class="toolbar">
							<span class="icon-32-edit"></span>
							Editar
							</a>
						</li>
						
						<li class="divider"></li>

						<li class="button" id="toolbar-trash">
							<a href="#" onclick="excluir(<?php  echo $numClasses;?>)" class="toolbar">
							<span class="icon-32-trash"></span>
							Excluir
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-groups"><h2>Classes de Usuários</h2></div>
			</div>
		</div>
		
		<div id="element-box">
			<div class="m">
				<form action="#" id="application-form" method="post" name="listarclasseUsuarios" class="form-validate">
					<table class="adminlist">
						<thead>
							<tr>
								<th width="1%">
									<input type="checkbox" name="selecionaTodas" id="selecionaTodas" value="" title="Selecionar todas classeUsuarios" onclick="selecionar(<?php  echo $numClasses;?>)">
								</th>
								<th>
									Nome	
								</th>
								<th width="30%">
									Faixa de Pontos	
								</th>
							</tr>
						</thead>
						
						<tbody>
							<?php 
							$i = 0;
							while($classeUsuario=$consulta->fetch_array()){
								echo '<tr class="row'.($i%2).'">';
									echo '<td class="center">';
										echo '<input type="checkbox" id="cb'.$i.'" name="cid[]" value="'.$classeUsuario['codClasse'].'" title="Selecionar esta classeUsuario">';
									echo '</td>';
									echo '<td>';
										echo '<a href="editar_classe.php?id='.$classeUsuario['codClasse'].'"  style="font-size: 0.85em;">'.$classeUsuario['nomeClasse'].'</a>';
									echo '</td>';
									echo '<td>';
										echo '<span style="font-size: 0.75em;"><center>'.$classeUsuario['desClasse'].'<center></span>';
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
	</html>
	
	<script  type="text/javascript">
		function selecionar(numclasseUsuario){
			if(document.getElementById('selecionaTodas').checked){
				for(i = 0; i < numclasseUsuario; i++)
					if(!document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = true;
			}else{
				for(i = 0; i < numclasseUsuario; i++)
					if(document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = false;
			}
		}
		
		function editar(numclasseUsuario){
			var count = 0;
			var id;
			
			for(i = 0; i < numclasseUsuario; i++)
				if(document.getElementById('cb'+i).checked){
					count++;
					id = document.getElementById('cb'+i).value;
				}
					
			if(count == 0)
				alert("Você deve selecionar uma Classe para ser editada!");
			else if(count > 1)
				alert("Você deve selecionar somente uma Classe para ser editada!");
			else{
				window.location.href = "editar_classe.php?id=" + id;
			}
		}
		
		function excluir(numclasseUsuario){
			var count = 0;
			var id = new Array();
			
			for(i = 0; i < numclasseUsuario; i++)
				if(document.getElementById('cb'+i).checked){
					id[count] = document.getElementById('cb'+i).value;
					count++;
				}
			
			var link = "?count=" + count;	
			
			for(i = 0; i < count; i++){
				link += "&id" + i + "=" + id[i];
			}
			if (confirm('Você realmente deseja excluir a(s) classe(s) selecionada(s)?'))
				window.location.href = "excluir_classe.php" + link;
		}
	</script>
	
<?php   require 'rodape.php';
	}
?> 