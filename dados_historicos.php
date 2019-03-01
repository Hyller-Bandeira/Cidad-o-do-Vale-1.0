<?php
	session_start();
	header('content-type: text/html; charset=utf-8');
	require 'phpsqlinfo_dbinfo.php';
	require 'headtag.php';
?>

<!DOCTYPE html>
<html>
	<?php
		createHead(
			array("title" => $nomePagina . $nome_site,
                "script" => array("http://maps.google.com/maps/api/js?key=AIzaSyAHSnQ6TnIM1jXJCfc79MJw2jB5Qj5KwuM&libraries=places,visualization,geometry",
						"src/jquery-ui-1.11.4.custom/external/jquery/jquery.js",
						"src/jquery-ui-1.11.4.custom/jquery-ui.min.js",
						"jsor-jcarousel/lib/jquery.jcarousel.min.js",
						"src/jquery.blockUI.js",
						"src/util.js",
						"src/markerclusterer_packed.js",
                        "map.js"),
			"css" => array("style/table.css",
					  "style/tabela_historico.css",
					  "jsor-jcarousel/skins/tango/skin.css"),
			"required" => array("index.js.php", "src/class.eyedatagrid.inc.php")));
	?>

<body onload="initialize()" style="margin: 0;" class="corposite">

	<?php require 'header.php'; ?>

	<script type="text/javascript">
		// Variáveis Globais //
		var latlng;

		function mostrarColaboracao(id, latitude, longitude)
		{
			if (latitude && longitude)
			{
				$('#latitude').val(latitude);
				$('#longitude').val(longitude);
			}
			enviar(id);
		}
	</script>

	<br />
	<style>
		td { white-space: normal; }
	</style>

	<div class="centro">
		<?php
			// Print the table
			EyeDataGrid::useAjaxTable('tabela.php');
		?>
		<br />
		<form name="form_all_data_table" action="all_data_table.php" target='_blank'>
        <button type="submit" class="btn btn-warning active" onclick="ga('send', 'event', 'Clique', 'Botão', 'Gerar Tabela Completa - Dados Histórico');" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-th"></span> Gerar Tabela Completa</button>
	</div>

	<br />
	<br />
	<div align="center">
		<form name="form1" align="center">
			<label><b>Latitude: </b></label>
			<input id='latitude' name="latitude"  type="text" size="20" value='' />
			<label><b>Longitude: </b></label>
			<input id='longitude' name="longitude"  type="text" size="20" value='' />
		</form>
		<br /><br />
		<div id="map_canvas" style="width: 100%; height: 600px"></div>
		<br />
	</div>
    <?php include 'partials/rodape.php'; ?>
</body>
</html>