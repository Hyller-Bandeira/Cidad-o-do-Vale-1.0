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
		"script" => array("jquery.dynatree-1.2.5/jquery/jquery.js",
					"jquery.dynatree-1.2.5/jquery/jquery-ui.custom.js",
					"jquery.dynatree-1.2.5/jquery/jquery.cookie.js",
					"jquery.dynatree-1.2.5/src/jquery.dynatree.js"),
		"css" => array("jquery.dynatree-1.2.5/src/skin-vista/ui.dynatree.css")));
	?>

<body style="margin: 0;" class="corposite">

	<?php require 'header.php'; ?>

	<div class="div_centro" align="center" style="min-height: 500px">
        <div align="left" class="text-center" Style = 'width: 400px;margin-bottom: 10px;'><h4>Selecione as categorias que deseja filtrar</h4></div>
		<div id="tree" align="left"  Style = 'width: 400px;'></div>
        <div align="center" style="margin-top: 20px;">
            <button id="btnSelectAll" type="submit" class="btn btn-warning active" style="margin: 7px; background-color:rgb(247, 68, 69)" onclick="ga('send', 'event', 'Clique', 'Botão', 'Marcar Todos (Filtro)');"><span class="glyphicon glyphicon-check"></span> Marcar Todos</button>
            <button id="btnDeselectAll" type="submit" class="btn btn-warning active" style="margin: 7px; background-color:rgb(247, 68, 69)" onclick="ga('send', 'event', 'Clique', 'Botão', 'Desmarcar Todos (Filtro)');"><span class="glyphicon glyphicon-unchecked"></span> Desmarcar Todos</button>
        </div>
		<?php if(!isset($_SESSION['user_'.$link_inicial]) && !isset($_SESSION['pass_'.$link_inicial]))
		{ ?>
			<form name="form_filtro" action="inicio.php" method="post" align="center">
				<input id="ids_filtros" name = "ids_filtros" type='hidden' />
                <button type="submit" class="btn btn-warning btn-lg active" onclick="ga('send', 'event', 'Clique', 'Botão', 'Filtrar (Filtros)');" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
			</form>
		<?php
		}
		else
		{ ?>
			<form name="form_filtro" action="colaborar.php" method="post" align="center">
				<input id="ids_filtros" name = "ids_filtros" type='hidden' />
                <button type="submit" class="btn btn-warning btn-lg active" onclick="ga('send', 'event', 'Clique', 'Botão', 'Filtrar (Filtros)');" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-filter"></span> Filtrar</button>
			</form>
		<?php } ?>

		<?php require 'tree_data.php'; ?>

	</div>
    <?php include 'partials/rodape.php'; ?>
</body>
</html>