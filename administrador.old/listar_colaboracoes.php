<?php 	
	require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}else{
?>

	<html>
		<script  type="text/javascript">
			function semlinha(){
			var origem = '';
				document.getElementById('cabecalho').style.visibility = "hidden";
				/*if(origem == "categoria")
					alert("Não há colaboração(es) nesta categoria");
				else(origem == "tipo")
					alert("Não há colaboração(es) com esse tipo");
				else
					alert("Não há colaboração(es) para esta pesquisa");
				*/
				
				
			}
		</script>
		<?php 
		$tipoAtual = '';
		$cga = '';
		$sta = '';
		
		if(isset($_GET['cga'])) $cga = $_GET['cga'];
			
		if($cga == 'padrao') 
			$cga = '';
			
		if(isset($_GET['sta'])) $sta = $_GET['sta'];
			
		if($sta == 'padrao')
			$sta = '';
		
		if(isset($_GET['tpa'])) $tipoAtual = $_GET['tpa'];
			
		if($tipoAtual == 'padrao' || $cga == '')
			$tipoAtual = '';
		
		
		//Consultas SQL
		$consulta = mysql_query("SELECT * FROM colaboracao ORDER BY datahoraCriacao DESC");
		$numColaboracoes = mysql_num_rows($consulta);
		
		if($cga == '' && $sta == '' && $tipoAtual == '')
			$numColaboracoesAtual = $numColaboracoes;
		else if($cga != '' && $sta != '' && $tipoAtual == ''){
			$consulta5 = mysql_query("SELECT * FROM colaboracao WHERE (codCategoriaEvento = '$cga') AND (tipoStatus = '$sta') ORDER BY datahoraCriacao DESC");
			$numColaboracoesAtual = mysql_num_rows($consulta5);
		}
		else if($cga != '' && $sta == '' && $tipoAtual != ''){
			$consulta5 = mysql_query("SELECT * FROM colaboracao WHERE (codCategoriaEvento = '$cga') AND (codTipoEvento = '$tipoAtual') ORDER BY datahoraCriacao DESC");
			$numColaboracoesAtual = mysql_num_rows($consulta5);
		}
		else if($cga != '' && $sta == '' && $tipoAtual == ''){
			$consulta5 = mysql_query("SELECT * FROM colaboracao WHERE (codCategoriaEvento = '$cga') ORDER BY datahoraCriacao DESC");
			$numColaboracoesAtual = mysql_num_rows($consulta5);
		}
		else if($cga == '' && $sta != '' && $tipoAtual == ''){
			$consulta5 = mysql_query("SELECT * FROM colaboracao WHERE (tipoStatus = '$sta') ORDER BY datahoraCriacao DESC");
			$numColaboracoesAtual = mysql_num_rows($consulta5);
		}
		else if($cga == '' && $sta == '' && $tipoAtual != ''){
			$consulta5 = mysql_query("SELECT * FROM colaboracao WHERE (codTipoEvento = '$tipoAtual') ORDER BY datahoraCriacao DESC");
			$numColaboracoesAtual = mysql_num_rows($consulta5);
		}
		else if($cga == '' && $sta != '' && $tipoAtual != ''){
			$consulta5 = mysql_query("SELECT * FROM colaboracao WHERE (tipoStatus = '$sta') AND (codTipoEvento = '$tipoAtual') ORDER BY datahoraCriacao DESC");
			$numColaboracoesAtual = mysql_num_rows($consulta5);
		}
		else if($cga != '' && $sta != '' && $tipoAtual != ''){
			$consulta5 = mysql_query("SELECT * FROM colaboracao WHERE (codCategoriaEvento = '$cga') AND (tipoStatus = '$sta') AND (codTipoEvento = '$tipoAtual') ORDER BY datahoraCriacao DESC");
			$numColaboracoesAtual = mysql_num_rows($consulta5);
		}
		
		$consulta1 = mysql_query("SELECT * FROM categoriaevento ORDER BY desCategoriaEvento ASC");
		
		
		require ("cabecalho.php");
		require ("menu.php");?>
		
		<div id="toolbar-box">
			<div class="m">
				<div class="toolbar-list" id="toolbar">
					<ul>
						<li class="button" id="toolbar-edit">
							<a href="#" onclick="editar(<?php  echo $numColaboracoesAtual;?>)" class="toolbar">
							<span class="icon-32-apply"></span>
							Avaliar
							</a>
						</li>
						
						<li class="divider"></li>

						<li class="button" id="toolbar-trash">
							<a href="#" onclick="excluir(<?php  echo $numColaboracoesAtual;?>)" class="toolbar">
							<span class="icon-32-trash"></span>
							Excluir
							</a>
						</li>
					</ul>
					<div class="clr"></div>
				</div>
				<div class="pagetitle icon-48-marker"><h2>Colaborações</h2></div>
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
									if($cga == '')
										echo '<option value="padrao" selected="selected">Selecione uma categoria</option>';
									else
										echo '<option value="padrao">Selecione uma categoria</option>';
									while($categoria = mysql_fetch_array($consulta1)){
										if($cga == $categoria['codCategoriaEvento'])
											echo '<option value='.$categoria['codCategoriaEvento'].' selected="selected">'.$categoria['desCategoriaEvento'].'</option>';
										else
											echo '<option value='.$categoria['codCategoriaEvento'].'>'.$categoria['desCategoriaEvento'].'</option>';
									}
								?>
							</select>
						</div>
						
						<div class="filter-search2 fltlft" style="margin-left:15px;">
							<label class="filtro-lbl" for="filtro">Tipo: </label>
							<select name="filtro_tipo" id="filtro_tipo" class="inputbox" onchange="filtro()">
								<?php 	
									if($cga == '')
										echo '<option value="padrao" selected="selected">Selecione uma categoria primeiro</option>';
									else{
										if($tipoAtual == '')
											echo '<option value="padrao"  selected="selected">Selecione um tipo</option>';
										else
											echo '<option value="padrao">Selecione um tipo</option>';
											
										$consulta4 = mysql_query("SELECT * FROM tipoevento WHERE codCategoriaEvento = '$cga' ORDER BY desTipoEvento ASC");
										while($tipo = mysql_fetch_array($consulta4)){
											if($tipoAtual == $tipo['codTipoEvento'])
												echo '<option value='.$tipo['codTipoEvento'].' selected="selected">'.$tipo['desTipoEvento'].'</option>';
											else
												echo '<option value='.$tipo['codTipoEvento'].'>'.$tipo['desTipoEvento'].'</option>';
										}
									}
								?>
							</select>
						</div>
						
						<div class="filter-search2 fltlft" style="margin-left:15px;">
							<label class="filtro-lbl" for="filtro">Status: </label>
							<select name="filtro_status" id="filtro_status" class="inputbox" onchange="filtro()">
								<?php 	
									if($sta == '')
										echo '<option value="padrao" selected="selected">Selecione um Status</option>';
									else
										echo '<option value="padrao">Selecione um Status</option>';
									if($sta == 'E')
										echo '<option value="E" selected="selected">Em Análise</option>';
									else
										echo '<option value="E">Em Análise</option>';
									if($sta == 'A')
										echo '<option value="A" selected="selected">Aprovada</option>';
									else
										echo '<option value="A">Aprovada</option>';
									if($sta == 'R')
										echo '<option value="R" selected="selected">Reprovada</option>';
									else
										echo '<option value="R">Reprovada</option>';
									
									
								?>
							</select>
						</div>
					</fieldset>
					
					<table class="adminlist">
						<thead id="cabecalho">
							<tr>
								<th width="1%">
									<input type="checkbox" name="selecionaTodas" id="selecionaTodas" value="" title="Selecionar todos tipos" onclick="selecionar(<?php  echo $numColaboracoes;?>)">
								</th>
								<th>
									Título	
								</th>
								<th width="15%">
									Categoria
								</th>
								<th width="15%">
									Tipo
								</th>
								<th width="12%">
									Data da Criação
								</th>
								<th width="12%">
									Status
								</th>
							</tr>
						</thead>
						
						<tbody>
							<?php 
							$i = 0;
							while($colaboracao=mysql_fetch_array($consulta)){
								if(($tipoAtual == $colaboracao['codTipoEvento'] || $tipoAtual == '') && ($cga == $colaboracao['codCategoriaEvento'] || $cga == '') && ($sta == $colaboracao['tipoStatus'] || $sta == '')){
									echo '<tr class="row'.($i%2).'">';
										echo '<td class="center">';
											echo '<input type="checkbox" id="cb'.$i.'" name="cid[]" value="'.$colaboracao['codColaboracao'].'" title="Selecionar este usuario">';
										echo '</td>';
										echo '<td>';
											echo '<a href="avaliar_colaboracao.php?id='.$colaboracao['codColaboracao'].'&cga='.$cga.'&sta='.$sta.'&tpa='.$tipoAtual.'"  style="font-size: 0.85em;">'.$colaboracao['desTituloAssunto'].'</a>';
										echo '</td>';
										$categoria = $colaboracao['codCategoriaEvento'];
										$consulta2 = mysql_query("SELECT * FROM categoriaevento WHERE codCategoriaEvento = '$categoria' ");
										$nomeCategoria=mysql_fetch_array($consulta2);
										echo '<td>';
											echo '<span style="font-size: 0.75em;"><center>'.$nomeCategoria['desCategoriaEvento'].'<center></span>';
										echo '</td>';
										
										$tipo = $colaboracao['codTipoEvento'];
										$consulta3 = mysql_query("SELECT * FROM tipoevento WHERE codTipoEvento = '$tipo' ");
										$nomeTipo=mysql_fetch_array($consulta3);
										
										echo '<td>';
											echo '<span style="font-size: 0.75em;"><center>'.$nomeTipo['desTipoEvento'].'<center></span>';
										echo '</td>';
										
										echo '<td>';
											echo '<span style="font-size: 0.75em;"><center>'.date('d/m/Y', strtotime($colaboracao['datahoraCriacao'])).'<center></span>';
										echo '</td>';
										
										echo '<td>';
											if($colaboracao['tipoStatus'] == 'E')
												echo '<span style="font-size: 0.75em;color: rgb(214, 128, 0);font-weight: bold;"><center>Em Análise<center></span>';
											else if($colaboracao['tipoStatus'] == 'A')
												echo '<span style="font-size: 0.75em; color: green; font-weight: bold;"><center>Aprovada<center></span>';
											else if($colaboracao['tipoStatus'] == 'R')
												echo '<span style="font-size: 0.75em; color: red; font-weight: bold;"><center>Reprovada<center></span>';
										echo '</td>';
									echo '</tr>';
									$i++;
								}
							}
							if($numColaboracoesAtual == 0){
								echo '<script  type="text/javascript">';
								echo 'document.getElementById("cabecalho").style.visibility = "hidden";';
								echo '</script>';
								echo '<div id="mensagem" style="margin-bottom:-20px; margin-top:20px; font-size: 13px; color: rgb(243, 2, 2); font-weight: bold;">Não há colaboração correspondente a esta busca!</div>';
							}
							?>
						</tbody>
					</table>
				</form>
			</div>
		</div>
	</html>
	
	<script  type="text/javascript">
		function selecionar(numColaboracoes){
			if(document.getElementById('selecionaTodas').checked){
				for(i = 0; i < numColaboracoes; i++)
					if(!document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = true;
			}else{
				for(i = 0; i < numColaboracoes; i++)
					if(document.getElementById('cb'+i).checked) 
						document.getElementById('cb'+i).checked = false;
			}
		}
		
		function editar(numColaboracoes){
			var count = 0;
			var id;
			var categoriaSelecionada = document.getElementById('filtro_categoria').value;
			var tipoSelecionado = document.getElementById('filtro_tipo').value;
			var statusSelecionado = document.getElementById('filtro_status').value;
			
			for(i = 0; i < numColaboracoes; i++)
				if(document.getElementById('cb'+i).checked){
					count++;
					id = document.getElementById('cb'+i).value;
				}
					
			if(count == 0)
				alert("Você deve selecionar uma colaboração para ser avaliada!");
			else if(count > 1)
				alert("Você deve selecionar somente uma colaboração para ser avaliada!");
			else{
				window.location.href = "avaliar_colaboracao.php?id=" + id
				+ "&cga=" + categoriaSelecionada
				+ "&tpa=" + tipoSelecionado
				+ "&sta=" + statusSelecionado;
			}
		}
		
		function excluir(numColaboracoes){
			var count = 0;
			var id = new Array();
			var categoriaSelecionada = document.getElementById('filtro_categoria').value;
			var tipoSelecionado = document.getElementById('filtro_tipo').value;
			var statusSelecionado = document.getElementById('filtro_status').value;
			
			for(i = 0; i < numColaboracoes; i++)
				if(document.getElementById('cb'+i).checked){
					id[count] = document.getElementById('cb'+i).value;
					count++;
				}
			
			var link = "?count=" + count;	
			
			for(i = 0; i < count; i++){
				link += "&id" + i + "=" + id[i];
			}
			if (confirm('Você realmente deseja excluir a(s) colaboração(es) selecionada(s)?'))
				window.location.href = "excluir_colaboracao.php" + link
				+ "&cga=" + categoriaSelecionada
				+ "&tpa=" + tipoSelecionado
				+ "&sta=" + statusSelecionado;
		}
		function exibeanonimos(){
			if(document.getElementById('exibe_anonimos').checked)
				window.location.href = "listar_usuarios.php?tpa=" + tipoSelecionado + "&cga=s";
			else
				window.location.href = "listar_usuarios.php?tpa=" + tipoSelecionado + "&cga=";
		}
		
		function filtro(){
			var categoriaSelecionada = document.getElementById('filtro_categoria').value;
			var tipoSelecionado = document.getElementById('filtro_tipo').value;
			var statusSelecionado = document.getElementById('filtro_status').value;
			
			window.location.href = "listar_colaboracoes.php?cga=" + categoriaSelecionada + "&tpa=" + tipoSelecionado + "&sta=" + statusSelecionado;
		}
	</script>
	
<?php   require('rodape.php');
	}
?> 