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
                "script" => array("http://maps.google.com/maps/api/js?key=AIzaSyAHSnQ6TnIM1jXJCfc79MJw2jB5Qj5KwuM&libraries=places,visualization",
						//"src/jquery-ui-1.11.4.custom/external/jquery/jquery.js",
						//"src/jquery-ui-1.11.4.custom/jquery-ui.min.js",
						"jsor-jcarousel/lib/jquery.jcarousel.min.js",
						"src/jquery.blockUI.js",
						"src/util.js",
						"src/markerclusterer_packed.js",
						"tabelas_dinamicas.js"),
			"css" => array("config.css",
					 "jsor-jcarousel/skins/tango/skin.css"),
			"required" => array("index.js.php")));
	?>


<body onload="initialize()" style="margin: 0;" class="corposite">
	<?php require 'header.php'; ?>
	<div class="div_centro">
        <?php include 'partials/pesquisar_endereco.php'; ?>
		<h4 align='center' class="font8">Em Desenvolvimento ... Novas estatísticas estarão disponíveis em breve!!</h4>
		<br />
		<div id="map_canvas" style="width: 100%; height: 600px;" ></div><br />

		<div class="centro">
            <?php include 'partials/heatmap_opcoes.php'; ?>
		</div>




	</div>
    <?php include 'partials/rodape.php'; ?>
</body>
</html>
