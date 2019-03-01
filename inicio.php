<?php
	session_start();
	header('content-type: text/html; charset=utf-8');
	require 'phpsqlinfo_dbinfo.php';
	require 'headtag.php';
	if(isset($_SESSION['user_'.$link_inicial]) && isset($_SESSION['pass_'.$link_inicial]))
		header("location: colaborar.php");
	else
	{
?>

<!DOCTYPE html>
<html>
	<?php
    createHead(
        array ("title" => $nomePagina . $nome_site,
            "script" => array(
                "http://maps.google.com/maps/api/js?key=AIzaSyAHSnQ6TnIM1jXJCfc79MJw2jB5Qj5KwuM&libraries=places,visualization,geometry",
                "jsor-jcarousel/lib/jquery.jcarousel.min.js",
                "src/jquery.blockUI.js",
                "src/util.js",
                "src/markerclusterer_packed.js",
                "tabelas_dinamicas.js",
                "map.js",
            ),
            "css" => array(
                "jsor-jcarousel/skins/tango/skin.css"),
            "required" => array("index.js.php")));
	?>

	<body onload="initialize()" style="margin: 0;" class="corposite">
		<?php require 'header.php'; ?>
        <div class="div_centro">
            <div class="row">
                <div class="col-md-3" style="width: 180px;">
                    <a onclick="abreTutorial();" style="width: 180px;"><button style="width: 180px;" type="button" class="btn btn-primary" onclick="ga('send', 'event', 'Clique', 'Botão', 'Tutorial');"><span class="glyphicon glyphicon-book"></span> Tutorial</button></a>
                </div>
                <div class="col-md-9">
                    <?php include 'partials/pesquisar_endereco.php'; ?>
                </div>
            </div>
        </div>

        <div id="map_canvas" class="map_canvas"></div>
        <br />

        <div class="div_centro">
            <div class="centro">
                <?php include 'partials/heatmap_opcoes.php'; ?>
            </div>
            <?php include 'partials/tabela_estatistica_rodape.php'; ?>
        </div>

        <?php include 'partials/rodape.php'; ?>

	</body>
</html>


<?php
	}