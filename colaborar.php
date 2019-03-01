<?php
	session_start();
	header('content-type: text/html; charset=utf-8');
	require 'headtag.php';
	require 'phpsqlinfo_dbinfo.php';

	if(!isset($_SESSION['user_'.$link_inicial]) && !isset($_SESSION['pass_'.$link_inicial]))
		header("location: registro.php");
	else
	{
?>

<!DOCTYPE html>
<html>
	<?php
	createHead(
		array("title" => $nomePagina . $nome_site,
            "script" => array("http://maps.google.com/maps/api/js?key=AIzaSyAHSnQ6TnIM1jXJCfc79MJw2jB5Qj5KwuM&libraries=places,visualization,geometry",
					"src/jquery.form.js",
					"jsor-jcarousel/lib/jquery.jcarousel.min.js",
					"src/jquery.blockUI.js",
					"links.js",
					"src/util.js",
					"tabelas_dinamicas.js",
					"map.js",
                    "bootstrap/js/filestyle.min.js",
                    "bootstrap/datetimepicker/js/bootstrap-datetimepicker.js",
                    "bootstrap/datetimepicker/js/locales/bootstrap-datetimepicker.pt-BR.js",
                    "src/moment-js/moment.js",
                    "src/markerclusterer_packed.js"),
		"css" => array(
                "http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css",
                //"bootstrap/css/bootstrap.css",
                "bootstrap/datetimepicker/css/bootstrap-datetimepicker.min.css",
                "config.css",
				"jsor-jcarousel/skins/tango/skin.css"),
		"required" => array("calendar/tc_calendar.php",
					   "colaborar.js.php")));
	?>

	<body id='wholething' onload="initialize()">

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

        <!-- Modal -->
        <div id="modal-keywords" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" onclick="atualizaLongLat(); ga('send', 'event', 'Clique', 'Fechar', 'Modal Palavras-chave');" style="background-color:rgb(247, 68, 69)">&times;</button>
                        <h3 class="modal-title">Envio de palavras-chave</h3>
                    </div>
                    <div class="modal-body">
                        <p class="text-left">Informe até 10 palavras-chave separadas por ponto e vírgula (;)</p>
                        <div class="form-group">
                            <label for="comment">Palavras-chave:</label>
                            <textarea class="form-control" rows="5" id="keywordstxt" maxlength="150"></textarea>
                        </div>
                        <span class="small">Ex: água suja; cano quebrado...</span>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="atualizaLongLat(); ga('send', 'event', 'Clique', 'Botão', 'Pular Envio de Palavras-chave');">Pular</button>
                        <button type="button" class="btn btn-success" data-dismiss="modal" onclick="save_keywords(); ga('send', 'event', 'Clique', 'Botão', 'Enviar Palavras-chave');">Enviar</button>
                    </div>
                </div>

            </div>
        </div>

        <!-- Modal -->
        <div id="info-selos" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" onclick="ga('send', 'event', 'Clique', 'Fechar', 'Modal Selos de conquista: Número de colaborações 1');">&times;</button>
                        <h4 class="modal-title">Selos de conquista: Número de colaborações 1</h4>
                    </div>
                    <div class="modal-body text-center">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="images/selos/numeroDeColaboracoes1.png" class="img-responsive" style="margin: 0 auto;">
                            </div>

                            <div class="col-md-9">
                                <div class="row text-center" style="margin: 0;">
                                    <p>Você ganhou um selo de conquista por ter realizado sua primeira colaboração. Você pode ver seus selos em seu perfil.</p>
                                </div>
                                <div class="row text-center"  style="margin: 20px 0 0 0;">
                                    <a href='user_profile.php?uid=<?php echo $_SESSION['code_user_'.$link_inicial]; ?>' title='Ver perfil' target="_blank">
                                        <button type="button" class="btn btn-warning active" onclick="ga('send', 'event', 'Clique', 'Botão', 'Ver Perfil - Modal Selos de conquista: Número de colaborações 1');" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-user"></span> <strong> Ver Perfil</strong></button>
                                    </a>
                                    <a href="selos.php" target="_blank"><button type="button" class="btn btn-warning active" onclick="ga('send', 'event', 'Clique', 'Botão', 'Ver Selos - Modal Selos de conquista: Número de colaborações 1');" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-eye-open"></span><strong> Ver Selos</strong></button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="ga('send', 'event', 'Clique', 'Botão', 'Fechar - Modal Selos de conquista: Número de colaborações 1');">Fechar</button>
                    </div>
                </div>

            </div>
        </div>

        <script>
            $(function()
            {
                var userid = <?php echo $_SESSION['code_user_' . $link_inicial]; ?>;
                var ifmsg;

                $.ajax(
                {
                    method: 'POST',
                    url: 'sem_dicas.php',
                    data: {func: 'seen', user: userid},
                    async: false
                }).done(function(data) { ifmsg = data; });

                if (ifmsg != 0) viewhelp = false;
            });

            $('#map_canvas').on('mode_changed', function()
            {
                var userid = <?php echo $_SESSION['code_user_' . $link_inicial]; ?>;
                var ifmsg;

                $.ajax(
                    {
                        method: 'POST',
                        url: 'sem_dicas.php',
                        data: {func: 'seen', user: userid},
                        async: false
                    }).done(function(data) { ifmsg = data; });

                if (ifmsg != 0) viewhelp = false;

                $('#helpopover').popover({
                    content: function()
                    {
                        if (mapmode == 'colab') {
                            ga('send', 'event', 'Sistema de Ajuda', 'Mensagem', 'Clique no mapa para iniciar uma colaboração');
                            return "Clique em qualquer ponto do mapa para iniciar uma colaboração. Se necessário, clique e arraste para navegar pelo mapa e utilize a ferramenta de zoom (parte superior direita do mapa) para aumentar a precisão de sua colaboração.";
                        } else if (mapmode == 'vis') {
                            ga('send', 'event', 'Sistema de Ajuda', 'Mensagem', 'Seja bem vindo(a)');
                            return "Seja bem vindo(a)! Para realizar uma colaboração, altere o modo clicando na opção \"Colaborar\" na parte superior esquerda do mapa.";
                        } else if (mapmode == 'winop') {
                            ga('send', 'event', 'Sistema de Ajuda', 'Mensagem', 'Preencha os dados do formulário');
                            return "Preencha os dados do formulário e clique no botão \"Enviar Colaboração\". Você também pode enviar uma Imagem, Vídeo ou Arquivo, basta selecionar a aba desejada.";
                        } else if (mapmode == 'keys') {
                            ga('send', 'event', 'Sistema de Ajuda', 'Mensagem', 'Informe algumas palavras-chave');
                            return "Caso queira, informe algumas palavras-chave que descrevam sua colaboração e clique em \"Enviar\", caso contrário clique no botão \"Pular\"";
                        }
                    },
                    placement: 'right'
                });

                if (viewhelp)
                {
                    $('#helpopover').popover('show');
                    $('#helpopover').data("bs.popover").inState.click = true;
                }
            });

            $('body').on('shown.bs.popover', function() {
                ga('send', 'event', 'Sistema de Ajuda', 'Exibiu', 'Exibiu');
                $('#helpopovertext').html('Fechar');
            });
            $('body').on('hidden.bs.popover', function() {
                ga('send', 'event', 'Sistema de Ajuda', 'Escondeu', 'Escondeu');
                $('#helpopovertext').html('Ajuda ');
            });

            $(document).on('click', '#helpopover', function() {
                if (viewhelp) {
                    ga('send', 'event', 'Clique', 'Botão', 'Fechar Ajuda');
                } else {
                    ga('send', 'event', 'Clique', 'Botão', 'Ajuda');
                }
                viewhelp = !viewhelp;
            });

            $(document).one('click', '#helpopover', function()
            {
                var userid = <?php echo $_SESSION['code_user_' . $link_inicial]; ?>;
                $.ajax(
                {
                    method: 'POST',
                    url: 'sem_dicas.php',
                    data: {func: 'ignore', user: userid}
                });

                viewhelp = false;
            });

            $('#modal-keywords').on('hidden.bs.modal', function(event)
            {
                // Close the messsage here
                mapmode = 'colab';
                $('#helpopover').popover('hide');
                ga('send', 'event', 'Sistema de Ajuda', 'Finalizou colaboração', 'Mensagem fecha automaticamente');
                $('helpopovertext').html('Ajuda');
            });
        </script>

        <?php include 'partials/rodape.php'; ?>
   </body>
</html>
<?php
	}
