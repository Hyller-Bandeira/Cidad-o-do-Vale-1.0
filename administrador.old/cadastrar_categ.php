<?php 
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}
	else{				
		?>
		<link rel="stylesheet" href="config.css" type="text/css" media="all" />
		&nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
		

		<div  align="center"  >
			<HR>
			<h1>CADASTRO DE CATEGORIAS</h1>
			<HR>
			<input class="button" type="submit" value="V o l t a r" style="width: 100px; height: 28px;  font-size: 12pt" onclick='voltar()'>
			<HR>
			<form name="form" action="cadastrando_categ.php" method="post">
				<p>
					<h2>Cadastrar uma nova categoria: </h2>
					
					<label>Descrição da Categoria*</label>
					<br />
					<br />
					<textarea name="desCategoriaEvento" rows="10" cols="40"></textarea>	
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
		</div>
		<div  align="center" style='width: 100%; height: 590px;overflow: auto; position:relative;'  >
		
			<?php  
				require("../phpsqlinfo_dbinfo.php"); 
				 
				// Select all the rows in the colaboracao table 
				$query = "SELECT * FROM categoriaevento WHERE 1"; 
				$result = mysql_query($query); 
				if (!$result) { 
				  die('Invalid query: ' . mysql_error()); 
				} 

				echo "	<table border = '5' cellpadding = '3' cellspacing = '3'>
						<tr>
							<th align='center'>Id</th>
							<th align='center'>Categoria</th>										
						</tr>";

				/*Enquanto houver dados na tabela para serem mostrados será executado tudo que esta dentro do while */
				while($escrever=mysql_fetch_array($result)){
					/*Escreve cada linha da tabela*/
					echo "<tr><td align='center'>" . $escrever['codCategoriaEvento'] . 
						 "</td><td align='center'>" . $escrever['desCategoriaEvento'] .					 
						"</td></tr>";
				}/*Fim do while*/

				echo "</table>"; /*fecha a tabela apos termino de impressão das linhas*/
				 
			?>
		</div>
		
		<HR>
		
		<?php 
	};
?>

