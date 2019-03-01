<?php
	session_start();
	header('content-type: text/html; charset=utf-8');
	require 'headtag.php';
	require 'phpsqlinfo_dbinfo.php';
?>

<!DOCTYPE html>
<html>
	<?php
		createHead(
			array("title" => $nomePagina . $nome_site,
                "script" => array("http://maps.google.com/maps/api/js?key=AIzaSyAHSnQ6TnIM1jXJCfc79MJw2jB5Qj5KwuM&libraries=places,visualization",
						 "https://www.google.com/jsapi",
						 //"src/jquery-ui-1.11.4.custom/external/jquery/jquery.js",
						 //"src/jquery-ui-1.11.4.custom/jquery-ui.min.js",
						 "jsor-jcarousel/lib/jquery.jcarousel.min.js",
						 "src/jquery.blockUI.js",
						 "src/util.js",
						 "src/markerclusterer_packed.js",
						 "map.js"),
			"css" => array("config.css",
					  "jsor-jcarousel/skins/tango/skin.css"),
			"required" => array("analise_dados.js.php")));
	?>

	<body onload="initialize()" style="margin: 0;" class="corposite">

		<?php require 'header.php'; ?>

		<div class="div_centro">
            <?php include 'partials/pesquisar_endereco.php'; ?>
		</div>

		<div id="map_canvas" class="map_canvas"></div>
		<br />

		<div class="centro">
            <?php include 'partials/heatmap_opcoes.php'; ?>
		</div>

		<div align = 'center' class="font8">
			<br>
			<Label> Selecione a Categoria do Gráfico 1</Label>
			<select name='categoria_atual' id = 'categoria_atual' class="form7" onchange="criarGrafico($('#categoria_atual').val(), $('#categoria_atual_2').val(), 1);">
					<?php
						$consulta = $connection->query("SELECT * FROM categoriaevento");
						while ($row = $consulta->fetch_array(MYSQLI_NUM)) { echo "<option value= '$row[0]'> $row[1] </option>"; }
					?>
			</select>
			<Label>Selecione a Categoria do Gráfico 2</Label>
			<select name='categoria_atual_2' id = 'categoria_atual_2'  class="form7" onchange="criarGrafico($('#categoria_atual').val(), $('#categoria_atual_2').val(), 2);">
					<?php
					$consulta = $connection->query("SELECT * FROM categoriaevento");
					while ($row = $consulta->fetch_array(MYSQLI_NUM)) { echo "<option id='escolha". $row[0] . "'" . " value= '$row[0]'> $row[1] </option>"; }
					?>
			</select>
			<br><br>
		</div>
		<div style="background-color: rgb(243, 243, 243); border: 1px solid; width: 1000px; margin: 0 auto;">
			<table class="centro" style="margin: 0 auto;">
				<tr>
					<td><label id="texto1" class="font5"></label></td>
					<td><label id="texto2" class="font5"></label></td>
				</tr>
				<tr>
					<td><div id="chart_div1"></div></td>
					<td><div id="chart_div2"></div></td>
				</tr>
			</table>
		</div>
		<br />

        <?php include 'partials/rodape.php'; ?>
	</body>
</html>