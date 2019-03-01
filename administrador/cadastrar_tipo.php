<?php
    require("../phpsqlinfo_dbinfo.php");
	session_start();
	if(!isset($_SESSION['user_admin_'.$link_inicial]) && !isset($_SESSION['pass_admin_'.$link_inicial])){
		header("location: naologado_admin.html");
	}
	else{				
		?>
		<link rel="stylesheet" href="config.css" type="text/css" media="all" />
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		

		<div  align="center"  >
			<HR>
			<h1>CADASTRO DE TIPOS</h1>
			<HR>
			<input class="button" type="submit" value="V o l t a r" style="width: 100px; height: 28px;  font-size: 12pt" onclick='voltar()'>
			<HR>
			<form name="form" action="cadastrando_tipo.php" method="post">
				<p>
					<h2>Cadastrar um novo tipo de uma categoria: </h2>
					<label>Categoria do Tipo*</label>
					<br />
					<br />
					<?php  require("../phpsqlinfo_dbinfo.php");?>
					<select name='codCategoriaEvento' style= 'width: 250px;' >
						<option>
						</option>
							<?php  $consulta = $connection->query('SELECT * FROM categoriaevento'); ?>
							<?php  while( $row = $consulta->fetch_assoc() ){  ?>
					 		<option value=<?php  echo $row["codCategoriaEvento"];?>>
					 		<?php  echo $row["desCategoriaEvento"];?></option>
							<?php  } ?>
					</select>
					<br />
					<br />
					<label>Descrição do Tipo*</label>
					<br />
					<br />
					<textarea name="desTipoEvento" rows="10" cols="40"></textarea>	
					<br />
					
					
					<br />
					(*)Campos obrigatórios
					<br /><br />	
					
					<input class="button" type="submit" value="C a d a s t r a r" style="width: 150px; height: 28px;  font-size: 12pt" />
					<br />
					<br />						
				</p>
			</form>
			<HR>
			
		</div>



		<script>
			function voltar(){		
				window.location.href="http://www.ide.ufv.br:8008/CidadaoVicosa/administrador/admin_tool.php";
			}
		</script>
		<div align="center">
			<h2>Lista de Todas as Categorias Existentes no Sistema: </h2>
		</DIV>
		<div  align="center" style='width: 100%; height: 590px;overflow: auto; position:relative;'  >		
			<?php  
				require("../phpsqlinfo_dbinfo.php"); 

				// Select all the rows in the colaboracao table 
				$query = "SELECT * FROM tipoevento WHERE 1"; 
				$result = $connection->query($query);
				if (!$result) { 
				  die('Invalid query: ' . $connection->error);
				} 

				echo "	<table border = '5' cellpadding = '3' cellspacing = '3'>
						<tr>
							<th align='center'>Id</th>
							<th align='center'>Tipo</th>
							<th align='center'>Categoria</th>								
						</tr>";

				/*Enquanto houver dados na tabela para serem mostrados será executado tudo que esta dentro do while */
				while($escrever=$result->fetch_array()){
					/*Escreve cada linha da tabela*/
					
					$temp1 = $escrever['codCategoriaEvento'];
					$consultaCategoria = $connection->query("SELECT * FROM categoriaevento WHERE codCategoriaEvento = '$temp1'" );
					$rowCategoria = $consultaCategoria->fetch_assoc();
					
					echo "<tr><td align='center'>" . $escrever['codTipoEvento'] . 
						 "</td><td align='center'>" . $escrever['desTipoEvento'] .
						 
						
						 "</td><td align='center'>" . $rowCategoria['desCategoriaEvento'] .
						 
						"</td></tr>";
				}/*Fim do while*/

				echo "</table>"; /*fecha a tabela apos termino de impressão das linhas*/
				 
			?>
		</div>
		
		<HR>
		
		<?php 
	};
?>

