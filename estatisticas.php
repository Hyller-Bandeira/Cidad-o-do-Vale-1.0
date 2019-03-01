<?php
	session_start();
	header('content-type: text/html; charset=utf-8');
	require 'phpsqlinfo_dbinfo.php';
	require 'headtag.php';

	function geraGrafico($tipo, $connection)
	{
		require 'phpsqlinfo_dbinfo.php';
		
		if($tipo == 0)
		{
			$query = sprintf("SELECT desCategoriaEvento , COUNT(colaboracao.codCategoriaEvento) FROM colaboracao, categoriaevento, usuario
							WHERE colaboracao.codCategoriaEvento = categoriaevento.codCategoriaEvento AND usuario.codUsuario = colaboracao.codUsuario  AND usuario.tipoUsuario != 'A'
							GROUP BY desCategoriaEvento");

		}
		else if($tipo == 1)
		{
			$query = sprintf("SELECT usuario.apelidoUsuario as nomPessoa, COUNT( colaboracao.codUsuario ) as numeroColaboracao
							FROM colaboracao, usuario
							WHERE colaboracao.codUsuario = usuario.codUsuario AND usuario.tipoUsuario != 'A'
							GROUP BY usuario.apelidoUsuario
							ORDER BY numeroColaboracao desc
							LIMIT 0 , 5");
		}
		else
		{
			$query = sprintf("SELECT tipoevento.desTipoEvento , COUNT(colaboracao.codCategoriaEvento)
                            FROM colaboracao
                            INNER JOIN tipoevento ON tipoevento.codTipoEvento = colaboracao.codTipoEvento
                            WHERE colaboracao.codCategoriaEvento = ($tipo-1)
                            GROUP BY colaboracao.codCategoriaEvento, tipoevento.desTipoEvento");
		}

		$result = $connection->query($query);
		$code = '';
		while ($row = $result->fetch_array(MYSQLI_NUM))
		{
			$code = $code."[ '".$row[0]."' , ".$row[1]." ],";
		}

		$result->free();
		return $code;
	}
?>

<!DOCTYPE html>
<html>
	<?php
		createHead(
			array("title" => $nomePagina . $nome_site,
			"script" => array("https://www.google.com/jsapi",
                        "tabelas_dinamicas.js",
						"src/jquery.min.js")));
	?>

<body style="margin: 0;" class="corposite">
	<?php require 'header.php'; ?>
	<div class="div_centro">
		<br />
		<div align='center' class='font8' >
			<b>
				Total de Usuários Cadastrados no Sistema:
				<?php
					$query = "SELECT COUNT(*) AS totalUsuarios FROM usuario WHERE tipoUsuario != 'A'";
					$result = $connection->query($query);
					if (!$result)
					{
						die('Invalid query: ' . $connection->error);
					}

					$escrever = $result->fetch_array();
					echo " ";
				?>
				<span style='color: #ff0000'><?php echo $escrever['totalUsuarios']; ?></span>
				||
				Total de Colaborações dos Usuários:
				<?php
					$query = "SELECT COUNT(*) AS totalcolaboracao FROM colaboracao INNER JOIN usuario ON usuario.codUsuario = colaboracao.codUsuario  WHERE usuario.tipoUsuario NOT IN ('A', 'R') ";
					$result = $connection->query($query);
					if (!$result)
					{
						die('Invalid query: ' . $connection->error);
					}

					$escrever = $result->fetch_array();
				?>
				<span style='color: #ff0000'><?php echo $escrever['totalcolaboracao']; ?></span>
			</b>
		</div>
		<br />
		<table class="centro" style="min-height: 400px;">
			<tr>
				<td><label class="font5">Tipos de Colaborações</label></td>
				<td><label class="font5">Usuarios que mais colaboram</label></td>
			</tr>
			<tr>
				<td><div id="chart_div0"></div></td>
				<td><div id="chart_div1"></div></td>
			</tr>

		<?php
			$consulta = $connection->query("SELECT DISTINCT categoriaevento.codCategoriaEvento, categoriaevento.desCategoriaEvento FROM categoriaevento INNER JOIN tipoevento ON tipoevento.codCategoriaEvento = categoriaevento.codCategoriaEvento");

			while ($row = $consulta->fetch_array())
			{
				if ($row2 = $consulta->fetch_array())
				{
					echo "<tr>";
					echo "<td><label class='font5'>Tipos de Colaborações de $row[1]</label></td>";
					echo "<td><label class='font5'>Tipos de Colaborações de $row2[1]</label></td>";
					echo "</tr>";
					$idAjustado = $row[0]+1;
					$idAjustado2 = $row2[0]+1;
					echo "<tr><td><div id='chart_div" . "$idAjustado" . "'></div></td>";
					echo "<td><div id='chart_div" . "$idAjustado2" . "'></div></td></tr>";
				}
				else
				{
					echo "<tr><td><label class='font5'>Tipos de Colaborações de $row[1]</label></td></tr>";
					$idAjustado = $row[0] + 1;
					echo "<tr><td><div id='chart_div" . "$idAjustado" . "'></div></td></tr>";
				}
			}
		?>

		</table>
        <?php include 'partials/tabela_estatistica_rodape.php'; ?>
	</div>
    <?php include 'partials/rodape.php'; ?>
</body>
</html>

<script type="text/javascript">
	google.load('visualization', '1', {'packages':['corechart']});
	google.setOnLoadCallback(drawChart);

	function drawChart()
	{
		<?php
        $consulta = $connection->query("SELECT DISTINCT categoriaevento.codCategoriaEvento, categoriaevento.desCategoriaEvento FROM categoriaevento INNER JOIN tipoevento ON tipoevento.codCategoriaEvento = categoriaevento.codCategoriaEvento");

			while ($row = $consulta->fetch_array())
			{
				if ($row2 = $consulta->fetch_array())
				{
					$idAjustado = $row[0]+1;
					$idAjustado2 = $row2[0]+1;
                    
                    $i = $idAjustado;
                    echo "var data$i = new google.visualization.DataTable();
                             data$i.addColumn('string', 'Nome');
                             data$i.addColumn('number', 'Quantidade');
                             data$i.addRows([" . geraGrafico($i, $connection) . " ]);
                             var chart$i = new google.visualization.PieChart(document.getElementById('chart_div$i'));
                             chart$i.draw(data$i, {width: 450, height: 250});";
                    $i = $idAjustado2;
                    echo "var data$i = new google.visualization.DataTable();
                             data$i.addColumn('string', 'Nome');
                             data$i.addColumn('number', 'Quantidade');
                             data$i.addRows([" . geraGrafico($i, $connection) . " ]);
                             var chart$i = new google.visualization.PieChart(document.getElementById('chart_div$i'));
                             chart$i.draw(data$i, {width: 450, height: 250});";
                }
				else
				{
					$idAjustado = $row[0] + 1;
                    $i = $idAjustado;
                    echo "var data$i = new google.visualization.DataTable();
                         data$i.addColumn('string', 'Nome');
                         data$i.addColumn('number', 'Quantidade');
                         data$i.addRows([" . geraGrafico($i, $connection) . " ]);
                         var chart$i = new google.visualization.PieChart(document.getElementById('chart_div$i'));
                         chart$i.draw(data$i, {width: 450, height: 250});";
				}
			}
			for($i = 0; $i < 10; $i++)
			{
		}
		?>
	}
</script>


