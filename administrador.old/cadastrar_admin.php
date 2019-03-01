<?php 
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}
	else{				
		?>
		<html>
			
			<head>
				<title>Registro Realiazado</title>
				
			</head>
			
			<body>
				<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
				<link rel="stylesheet" href="config.css" type="text/css" media="screen" />
				<HR>
				<H1 ALIGN = CENTER>CADASTRO DE ADMINISTRADORES E USUÁRIOS</h1>				
				<HR>
				
				<div  align="center"  >
						<input class="button" type="submit" value="V o l t a r" style="width: 100px; height: 28px;  font-size: 12pt" onclick='voltar()'>
				</div>
				
				<hr>
				
				<div  align="center"  >
					<form name="form" action="cadastrando_admin.php" method="post">
						<p style="margin-left: 10 ">
							<h2>Cadastrar um novo Administrador ou Usuário: </h2>
							<br />
							<table>
							<tr>
							<td>
							<label>Nome*</label><br />
							</td>
							<td>
							<input name="nomPessoa"  type="text" size="10" />
							</td>
							</tr>
							<tr>
							<td>
							<label>Email*</label><br />
							</td>
							<td>
							<input name="endEmail"  type="text" size="10" />
							</td>
							</tr>
							<tr>
							<td>
							<label>Repita o Email*</label>
							</td>							
							<td>
							<input name="endEmail2"  type="text" size="10" />
							</td>
							</tr>
							<tr>
							<td>
							<label>Senha*</label><br />
							</td>							
							<td>
							<input name="senha"  type="password" size="10" />
							</td>
							</tr>
							<tr>
							<td>
							<label>Repita a Senha*</label><br />
							</td>							
							<td>
							<input name="senha2"  type="password" size="10" />
							</td>
							</tr>
							<tr>
							<td>
							<label>Tipo de Usuario*</label><br /><br />
							</td>							
							<td>
							<select name="tipoUsuario">
								<option value="A">Admin</option>
								<option value="S">SuperAdmin</option>
								<option value="C">Colaborador</option>
							</select>
							</td>
							</tr>
							
							</table>
							
							<br />
							(*)Campos obrigatórios
							
							<br /><br />	
							<input class="button" type="submit" value="Cadastrar" style="width: 120px; height: 30px;  font-size: 12pt"/>
						</p>
					</form>
				</div>
				
				<hr>
				
				<div  align="center"  >
					<h2>Pesquisar Administradores e Usuários do Sistema: </h2>
					<form name="form" action="cadastrar_admin.php" method="post" >
						<p>		
							<label>FILTRAR: </label>
							&nbsp;
							&nbsp;
							<select name="Estado">
								<option value="T">Todos</option>
								<option value="C">Usuario Comum</option>
								<option value="A">Administrador</option>
								<option value="S">Super Administrador</option>
							</select>
							
							&nbsp;
							&nbsp;
							
							
							<label>ORDENAR: </label>
							&nbsp;
							&nbsp;
							<select name="Ordem">
								Status
								<option value="A">Codigo Usuario</option>
								<option value="B">Tipo Usuario</option>
								<option value="C">Email</option>
								<option value="D">Nome</option>
							</select>
							
							&nbsp;
							&nbsp;
							&nbsp;
							&nbsp;
							
							<input class="button" type="submit" value="A P L I C A R" style="width: 120px; height: 26px;  font-size: 12pt">
									
						</p>
					</form>

					<script>
						function voltar(){		
							window.location.href="http://www.ide.ufv.br:8008/CidadaoVicosa/administrador/admin_tool.php";
						}
					</script>
					
					<div style="height: 590px;overflow: auto;width: 600px"  >
					<?php  
						require("../phpsqlinfo_dbinfo.php"); 

						$Estado_post = '';
						$Ordem = '';
						
						if(isset($_POST["Estado"])) $Estado_post = $_POST["Estado"];
						if(isset($_POST["Ordem"])) $Ordem = $_POST["Ordem"];
						
						if ($Estado_post == 'C'){ 
							if ($Ordem == 'B')
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'C' ORDER BY tipoUsuario"; 
							else if ($Ordem == 'C')
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'C' ORDER BY endEmail";
							else if ($Ordem == 'D')
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'C' ORDER BY nomPessoa";
									
							else	
								// Select all the rows in the usuario table 
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'C'"; 			
							
							$result = mysql_query($query); 
						}

						else if ($Estado_post == 'A'){ 
							
							if ($Ordem == 'B')
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'A' ORDER BY tipoUsuario"; 
							else if ($Ordem == 'C')
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'A' ORDER BY endEmail";
							else if ($Ordem == 'D')
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'A' ORDER BY nomPessoa";					
							else	
								// Select all the rows in the usuario table 
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'A'"; 				
									
							$result = mysql_query($query); 
						}

						else if ($Estado_post == 'S'){ 
							
							if ($Ordem == 'B')
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'S' ORDER BY tipoUsuario"; 
							else if ($Ordem == 'C')
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'S' ORDER BY endEmail";
							else if ($Ordem == 'D')
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'S' ORDER BY nomPessoa";					
							else	
								// Select all the rows in the usuario table 
								$query = "SELECT * FROM usuario WHERE tipoUsuario = 'S'"; 
								
							// Select all the rows in the usuario table 
							
							$result = mysql_query($query); 
						}

						else { 

							if ($Ordem == 'B')
								$query = "SELECT * FROM usuario WHERE 1 ORDER BY tipoUsuario"; 
							else if ($Ordem == 'C')
								$query = "SELECT * FROM usuario WHERE 1 ORDER BY endEmail";
							else if ($Ordem == 'D')
								$query = "SELECT * FROM usuario WHERE 1 ORDER BY nomPessoa";				
							else	
								// Select all the rows in the usuario table 
								$query = "SELECT * FROM usuario WHERE 1"; 			
							
							// Select all the rows in the usuario table 
							$result = mysql_query($query); 	
						}
						
						
						if (!$result) { 
						  die('Invalid query: ' . mysql_error()); 
						} 

						echo "<table border = '5' cellpadding = '3' cellspacing = '3'>
								<tr>
									<th align='center'>Id</th>
									<th align='center'>Nome</th>
									<th align='center'>Email</th>
									
									<th align='center'>Tipo de Usuario</th>
									
								</tr>";

						/*Enquanto houver dados na tabela para serem mostrados será executado tudo que esta dentro do while */
						while($escrever=mysql_fetch_array($result)){

						/*Escreve cada linha da tabela*/
						echo "<tr><td align='center'>" . $escrever['codUsuario'] . 
							 "</td><td align='center'>" . $escrever['nomPessoa'] . 
							 "</td><td align='center'>" . $escrever['endEmail'] . 
							 
							 "</td><td align='center'>" . $escrever['tipoUsuario'] .
						 
							"</td></tr>";

						}/*Fim do while*/

						echo "</table>"; /*fecha a tabela apos termino de impressão das linhas*/

					?>
				
				</div>
		
		<hr>
				
		</html>
		<?php 
	};
?>
