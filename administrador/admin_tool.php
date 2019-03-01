<?php 
	session_start();
	require("../phpsqlinfo_dbinfo.php");
	header('content-type: text/html; charset=utf-8');

	if(empty($_SESSION['user_admin_'.$link_inicial]) && empty($_SESSION['pass_admin_'.$link_inicial]))
	{
		header("location: naologado_admin.html");
	}
	else
	{
		//Consultas SQL
		//Achar número total de usuários
		$consulta = "SELECT COUNT(*) AS totalUsuarios FROM usuario";
		$resultado = $connection->query($consulta);
		if (!$resultado)
		{
			die('Invalid consulta: ' . $connection->error);
		}
		$totalUsuario = $resultado->fetch_assoc();
		
		//Achar número total de colaborações
		$consulta2 = "SELECT COUNT(*) AS totalcolaboracao FROM colaboracao";
		$resultado2 = $connection->query($consulta2);
		if (!$resultado2) { 
			die('Invalid consulta2: ' . $connection->error);
		}
		$totalColaboracoes = $resultado2->fetch_assoc();
				
		?>
		<html>
			<?php 
				require ("cabecalho.php");
				require ("menu.php");
			?>
				
			<div id="content-box">
				<div id="element-box">
					<div class="m">
						<div class="adminform">
							<div class="cpanel-left">
								<div class="cpanel">
									<div class="icon-wrapper">
										<div class="icon">
											<a href="listar_categorias.php">
												<img src="images/conteudo/icon-48-category.png" alt="">
													<span>Listar Categorias</span>
											</a>
										</div>
									</div>
									<div class="icon-wrapper">
										<div class="icon">
											<a href="listar_menu.php">
												<img src="images/conteudo/icon-48-levels.png" alt="">
													<span>Gerenciar Menu</span>
											</a>
										</div>
									</div>
									<div class="icon-wrapper">
										<div class="icon">
											<a href="listar_tipos.php">
												<img src="images/conteudo/icon-48-module.png" alt="">
													<span>Listar Tipos</span>
											</a>
										</div>
									</div>
									<div class="icon-wrapper">
										<div class="icon">
											<a href="adicionar_usuario.php">
												<img src="images/conteudo/icon-48-user-add.png" alt="">
													<span>Adicionar Usuário</span>
											</a>
										</div>
									</div>
									<div class="icon-wrapper">
										<div class="icon">
											<a href="configuracoes.php">
												<img src="images/conteudo/icon-48-config.png" alt="">
													<span>Configurações</span>
											</a>
										</div>
									</div>
									<div class="icon-wrapper">
										<div class="icon">
											<a href="listar_colaboracoes.php">
												<img src="images/conteudo/icon-48-marker.png" alt="">
													<span>Colaborações</span>
											</a>
										</div>
									</div>
									<div class="icon-wrapper">
										<div class="icon">
											<a href="http://www.dpi.ufv.br/projetos/clickonmap/">
												<img src="images/conteudo/icon-48-site.png" alt="">
													<span>Site ClickOnMap</span>
											</a>
										</div>
									</div>
								</div>
							</div>
							
							<div class="cpanel-right">
									
								<div id="panel-sliders" class="pane-sliders">
									<div style="display:none;"><div></div></div>
									<div style="margin-top: 80px; margin-left: 50px;">
										<h3>Total de Usuários cadastrados no sistema: <?php  echo $totalUsuario['totalUsuarios']; ?></h3>
										<h3>Total de colaborações realizadas: <?php  echo $totalColaboracoes['totalcolaboracao']; ?></h3>
									</div>
								</div>
							</div>
							<div class="clr"></div>
						</div>
					</div>
				</div>
			</div>
		</html>
	<?php
		require 'rodape.php';
	}