<!--<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?libraries=geometry&sensor=false&key=AIzaSyAHSnQ6TnIM1jXJCfc79MJw2jB5Qj5KwuM"></script>-->
<?php
    // require 'funcoes.js.php';
    require 'phpsqlinfo_dbinfo.php';
?>

<input type="hidden" name="longitude_inicial" id="longitude_inicial" value="<?php echo $longitude_inicial; ?>">
<input type="hidden" name="latitude_inicial" id="latitude_inicial" value="<?php echo $latitude_inicial; ?>">
<input type="hidden" name="zoom_inicial" id="zoom_inicial" value="<?php echo $zoom_inicial; ?>">
<input type="hidden" name="tipoMapa_inicial" id="tipoMapa_inicial" value="<?php echo $tipoMapa_inicial; ?>">

<script type="text/javascript" src="funcoes.js"></script>
<script type="text/javascript" src="src/moment-js/moment.js"></script>
<!-- <script type="text/javascript" src="bootstrap/js/transition.js"></script> -->
<script type="text/javascript" src="bootstrap/js/collapse.js"></script>
<script type="text/javascript">
    'use strict';
    var imageRed = new google.maps.MarkerImage('http://labs.google.com/ridefinder/images/mm_20_red.png',
//    var imageRed = new google.maps.MarkerImage('',
		new google.maps.Size(12, 20),
		new google.maps.Point(0,0),
		new google.maps.Point(10, 20));
		
	var imageBlue = new google.maps.MarkerImage('http://labs.google.com/ridefinder/images/mm_20_blue.png',
		new google.maps.Size(12, 20),
		new google.maps.Point(0,0),
		new google.maps.Point(10, 20));
	
    var shadow = new google.maps.MarkerImage('http://maps.google.com/intl/en_us/mapfiles/ms/micons/msmarker.shadow.png',
        new google.maps.Size(59, 20),
        new google.maps.Point(0,0),
        new google.maps.Point(10, 20));

    // Define a property to hold the Home state
    // HomeControl.prototype.marcar = null;     // Marked for removal
    // var marker_atual;                        // Marked for removal
    // var pos_info_win = 0;                    // Marked for removal
    // var tipoStatus;                          // Marked for removal
    var mapmode = 'vis';
    var viewhelp = true;
    var listaCluster = [];
    var pos = 0;
    var map;
    var latlng;
    var geocoder = null;
    var marker;
    var infowindow;
    var infowindowLoadMarker;
    var latlngMarcadorAtual;
    var marcadorGlobal;
    var listaMarcadores = [];
    var listaInfowindowLoadMarker = [];
    // var pointarray;
    var heatmap;
    var VGI_Data = [];
    var edicao = 'false';
    var zoom;
    var id_marcador_atual;
    var markerCluster;

    function initialize(modo)
    {
        map = initMap();

        // Botoes colaborar e visualizar
        var visualbutton = document.createElement('div');
        var colabutton = document.createElement('div');
        var mode_selected = document.createElement('div');
        var homeControl = new HomeControl(visualbutton, colabutton, mode_selected, map);
        mode_selected.index = 1;
        visualbutton.index = 2;
        colabutton.index = 2;

        var helpsys = $('<div id="helpopoverdiv" style="padding-left: 10px; padding-bottom: 18%;"><button id="helpopover" type="button" class="btn btn-primary" data-container="body"><span class="glyphicon glyphicon-question-sign"></span> <span id="helpopovertext">Ajuda</span> </button></div>');

        google.maps.event.addDomListener(map, 'idle', function()
        {
            google.maps.event.clearListeners(map, 'idle');
            mapmode = 'vis';
            $('#map_canvas').trigger('mode_changed');
        });

        google.maps.event.addListener(map, 'zoom_changed', function () {
            exibeMapCluster(map, listaCluster)
            heatmap.setOptions({radius: getNewRadius()});
        });

        map.controls[google.maps.ControlPosition.LEFT_CENTER].push(helpsys[0]);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(mode_selected);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(visualbutton);
        map.controls[google.maps.ControlPosition.TOP_LEFT].push(colabutton);

        <?php
        $ids_filtros = '';
        if (isset($_POST['ids_filtros'])) $ids_filtros = $_POST['ids_filtros'];

        if ($ids_filtros): ?>
            var ids_filtros = '<?php echo $ids_filtros; ?>';
            load_marker_filtro(ids_filtros);
        <?php else : ?>
            load_marker();
        <?php endif; ?>

        // Geocode e autocomplete
        geocoder = new google.maps.Geocoder();

        var input = document.getElementById('geocode');
        var options =
        {
            types: ['geocode'],
            componentRestrictions: {country: 'br'}
        };

        var autocomplete = new google.maps.places.Autocomplete(input, options);
        autocomplete.bindTo('bounds', map);

        var pointArray = new google.maps.MVCArray(VGI_Data);
        
        heatmap = new google.maps.visualization.HeatmapLayer(
        {
            data: pointArray,
            radius: getNewRadius()
        });
    } // Final do inicializar

    function loadXMLDoc(valor)
    {
        var select = $('#codTipoEvento');
        select.empty();
        select.append('<option value="">Carregando...</option>');
        select.prop( "disabled", true );
        $.get('result.php', {id: valor}, function(data)
        {
            select.empty();
            select.append('<option value="">Selecione</option>');
            data = data.split(',');
            for (var i = 0; i < data.length; ++i)
            {
                var str = data[i].split('|');
                select.append('<option value=' + str[1] + '>' + str[0] + '</option>');
            }

            select.prop( "disabled", false );

            if(data[0].length > 0) {
                $('#area-tipo').show();
                select.prop('required',true);
            } else {
                $('#area-tipo').hide();
                select.prop('required',false);
            }
        });
    }

    function enviarComentario()
    {
        ga('send', 'event', 'Função', 'Envia Comentário', 'Entrada');
        $('#comentario').find('[type=submit]').attr("disabled", "disabled");
        var codColaboracao = $('#codColaboracao').val();
        var usuario_id = $('#usuario_id').val();
        var desComentario = $('#desComentario').val();


        $.post('comentario.php', {codColaboracao: codColaboracao, usuario_id: usuario_id, desComentario: desComentario}, function(resposta)
        {
            if (resposta.substr(0, 1) != '#'){
                bootbox.alert(resposta);
                $('#comentario').find('[type=submit]').removeAttr('disabled');
                ga('send', 'event', 'Função', 'Envia Comentário', 'Falha');
            } else {
                downloadUrl('phpsqlajax_genxml_forum.php?valor3=' +  $('#codColaboracao').val(), function(data)
                {
                    var xml = parseXml(data);
                    var colaboracao = xml.documentElement.getElementsByTagName('marker');
                    var forum = colaboracao[0].getAttribute('forum');
                    $('#divForum').html(forum);
                    $('#desComentario').val('');
                    bootbox.alert('Comentário adicionado com Sucesso!!!');
                    ga('send', 'event', 'Função', 'Envia Comentário', 'Sucesso');

                    if ($('#sem-comentario').length > 0) {
                        $('#sem-comentario').hide();
                        $('#com-comentario').show();
                    }

                    $('#comentario').find('[type=submit]').removeAttr('disabled');
                    return true;
                });
            }
        });

        return true;
    }

    function avaliaColaboracao(){
        ga('send', 'event', 'Função', 'Avaliar Colaboração', 'Entrada');
        var nota = $('#nota').val();
        var codUsuario = $('#usuario_id').val();
        var codColaboracao = $('#codColaboracao').val();

        if (nota) {
            $.get('nota.php', {nota: nota, codUsuario: codUsuario, codColaboracao: codColaboracao}, function(data)
            {
                if (data.substr(0, 1) != '#'){
                    bootbox.alert(data);
                    ga('send', 'event', 'Função', 'Avaliar Colaboração', 'Falha');
                } else {
                    if (infowindow) infowindow.close();
                    if  (infowindowLoadMarker) infowindowLoadMarker.close();

                    bootbox.alert('Nota fornecida com sucesso!!');
                    ga('send', 'event', 'Função', 'Avaliar Colaboração', 'Sucesso');
                    $('form#formularioNota').hide();

                    var id_atual = parseInt(data.substr(1));
                    if ((id_atual > 0) && (!isNaN(id_atual))){
                        open_infowindows_especifico(id_atual, listaMarcadores[id_atual]);
                    }
                }
            });

        } else {
            bootbox.alert('Escolha uma nota.');
            ga('send', 'event', 'Função', 'Avaliar Colaboração', 'Nota Vazia');
        }
    }

    function HomeControl(div, div2, mode_selected, map)
    {
        var controlDiv = $(div);
        var controlDiv2 = $(div2);
        var controlDiv3 = $(mode_selected);
        var control = $(this);

        var controlUI3 = $('<div class="alert alert-warning" style="padding: 7px; margin-top: 10px;font-size: 12px;"><span>Você está no modo de <strong  id="info-mode-selected" class="text-uppercase">visualização</strong></span></div>');
        controlDiv3.append(controlUI3);

        var controlUI = $('<button id="modo_visualizar" type="button" class="btn btn-warning active" style="display:none; margin: 10px 5px 5px 5px; background-color:rgb(247, 68, 69)"onclick="ga(\'send\', \'event\', \'Clique\', \'Botão\', \'Modo Visualizar\');"><strong> <span class="glyphicon glyphicon-eye-open"></span> Visualizar</strong></button>');
        controlDiv.append(controlUI);

        var controlUI2 = $('<button id="modo_colaborar" type="button" class="btn btn-warning active" style="margin: 10px 5px 5px 5px; background-color:rgb(247, 68, 69)" onclick="ga(\'send\', \'event\', \'Clique\', \'Botão\', \'Modo Colaborar\');"><strong> <span class="glyphicon glyphicon-screenshot"></span> Colaborar</strong></button>');
        controlDiv2.append(controlUI2);

        google.maps.event.addDomListener(controlUI[0], 'click', function()
        {
            mapmode = 'vis';
            $('#map_canvas').trigger('mode_changed');

            $('#modo_visualizar').hide();
            $('#modo_colaborar').show();
            $('#info-mode-selected').text('visualização');

            map.setOptions({draggableCursor:''});

            remove_marker_click();
        });

        google.maps.event.addDomListener(controlUI2[0], 'click', function()
        {
            mapmode = 'colab';
            $('#map_canvas').trigger('mode_changed');

            $('#modo_visualizar').show();
            $('#modo_colaborar').hide();
            $('#info-mode-selected').text('colaboração');

            map.setOptions({draggableCursor:'crosshair'});

            marker_click();
        });
    }

    //-------------------------------------------------- IMPLEMENTACAO WIKI ---------------------------------------------------------

    function wikiVGI(id, descricao, titulo)
    {
        ga('send', 'event', 'Função', 'Revisão Wiki', 'Entrada');
        var code_user = <?php echo $_SESSION['code_user_'.$link_inicial]; ?>;
        $.get('atualizadescricao.php', {id: id, descricao: descricao, usuario: code_user, titulo: titulo}, function(data)
        {
            if (data.substr(0, 1) != '#'){
                bootbox.alert(data);
                Cancelar();
                ga('send', 'event', 'Função', 'Revisão Wiki', 'Falha');
            } else {
                if (infowindowLoadMarker) infowindowLoadMarker.close();

                bootbox.alert('Alteração Wiki realizada com sucesso!!!');
                ga('send', 'event', 'Função', 'Revisão Wiki', 'Sucesso');

                var id_atual = parseInt(data.substr(1));
                if ((id_atual > 0) && (!isNaN(id_atual))){
                    open_infowindows_especifico(id_atual, listaMarcadores[id_atual]);
                }
            }
        });
    }

    function Edicao(titulo_atual, descricao_atual)
    {
        $('#botaoEditar').hide();           // Desabilita Botao Editar
        $('#botaoSalvar').show();           // Exibe Botão Salvar
        $('#botaoCancelar').show();         // Exibe Botão Cancelar
        $('#descricoes').hide();            // Desabilita slider
        $('#editar_colaboracao').show();    // Exibe form de edicao

        $('#novo_titulo').val(titulo_atual);
        $('#nova_descricao').val(descricao_atual);
    }

    function Salvar(codigo)
    {
        var novotitulo = $('#novo_titulo').val();           // Pega valor do novo Titulo
        var novadescricao = $('#nova_descricao').val();     // Pega valor da nova colaboração
        wikiVGI(codigo, novadescricao, novotitulo);         // Envia para o PHP valores para atualizar a colaboração
    }

    function Cancelar()
    {
        $('#botaoSalvar').hide();           // Desabilita Botao Salvar
        $('#botaoCancelar').hide();         // Desabilita Botao Cancelar
        $('#botaoEditar').show();           // Exibe Botão Editar
        $('#descricoes').show();            // Exibe Slider
        $('#editar_colaboracao').hide();    // Desabilita form de edicao
    }

    //---------- FIM -------------
    function createInfoWindows(point, marker, dados_colaboracao)
    {
        ga('send', 'event', 'Função', 'Criar InfoWindows', 'Entrada');
        var code_user = <?php echo $_SESSION['code_user_'.$link_inicial]; ?>;
        dados_colaboracao.pode_editar = true;
        $.get('jaAvaliou.php', {codUsuario: code_user, codColaboracao: dados_colaboracao.codColaboracao}, function(data) {
            dados_colaboracao.ja_avaliou = (data == '1');

            $.post('partials/colaboracao_view.php', dados_colaboracao, function(resposta){
                infowindowLoadMarker = new google.maps.InfoWindow({content: resposta, maxWidth: 1500});

                google.maps.event.addListener(infowindowLoadMarker, 'domready', function()
                {
                    $("#tabs").tabs();

                    geraMetadados($('#codColaboracao').val());

                    var options =
                    {
                        target:        '#output1',
                        beforeSubmit:  showRequest,
                        success:       showResponse2
                    };

                    $('#frmFoto').ajaxForm(options);
                    $('#infowindowview').parent().css('overflow', 'hidden');
                    $('div.gm-style-iw').children().css('overflow', 'hidden');

                    $(":file").filestyle();
                    $('.buttonText').attr('style', 'margin-left:7px');
                    $('#Imagem').parent().find('.buttonText').html('Selecione a Imagem');
                    $('#arquivo').parent().find('.buttonText').html('Selecione o Arquivo');
                });

                map.panTo(marker.getPosition());
                //map.setZoom(14);
                infowindowLoadMarker.open(map, marker);
            });
        });

    }

    function remove_marker_click() { google.maps.event.clearListeners(map, "click"); }

    function DataHora()
    {
        $("#dataHoraDaColaboracao").val(moment(new Date()).format('DD/MM/YYYY - kk:mm:ss'));
        setTimeout('DataHora()', 1000);
    }

    //funcao para criar marcadores pelo click do mouse
    function marker_click()
    {
        ga('send', 'event', 'Clique', 'Mapa', 'Adicionou marcador');
        var code_user = <?php echo $_SESSION['code_user_'.$link_inicial]; ?>;
        var html =  "<div id='infowindowmarker' class='balao' style='width: 550px; height: 470px;'>"+

                        "<form id='frmArq' action='phpsqlinfo_addrow.php' method='post' enctype='multipart/form-data' onsubmit='return getKeywords()' >"+

                            "<div id='tabs'>" +
                                "<ul>" +
                                    "<li><a href='#tab-1' onclick='ga(\"send\", \"event\", \"Clique\", \"Aba\", \"Dados\");'><span>Dados</span></a></li>" +
                                    "<li><a href='#tab-2' onclick='ga(\"send\", \"event\", \"Clique\", \"Aba\", \"Imagem\");'><span>Imagem</span></a></li>" +
                                    "<li><a href='#tab-3' onclick='ga(\"send\", \"event\", \"Clique\", \"Aba\", \"Vídeos\");'><span>Vídeos</span></a></li>" +
                                    "<li><a href='#tab-4' onclick='ga(\"send\", \"event\", \"Clique\", \"Aba\", \"Arquivo\");'><span>Arquivo</span></a></li>" +
                                "</ul>" +

                                "<div id='tab-1' class='balao'>" +
                                    "<div class='row'>" +
                                        "<div class='col-md-12'>" +
                                            "<fieldset class='form-group' style='margin-bottom: 8px;'>" +
                                                "<label for='desTituloAssunto'>Título<span style= 'color:red;'>*</span></label>" +
                                                "<input class='form-control' type='text' id='desTituloAssunto' name='desTituloAssunto' placeholder='Informe um título para a colaboração' maxlength='100' required='required'/>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                        "<div class='col-md-6'>" +
                                            "<fieldset class='form-group' style='margin-bottom: 8px;'>" +
                                                "<label for='codCategoriaEvento'>Categoria<span style= 'color:red;'>*</span></label>" +
                                                "<select name='categoria' class='form-control c-select' id='codCategoriaEvento' onchange='loadXMLDoc(this.value)'  required='required'>" +
                                                    "<option value=''>Selecione</option>" +
                                                    "<?php  $consulta = $connection->query('SELECT * FROM categoriaevento'); ?> " +
                                                    "<?php  while($row = $consulta->fetch_assoc()) { ?> " +
                                                    "<option value=<?php echo $row["codCategoriaEvento"]; ?> />" +
                                                    "<?php  echo $row["desCategoriaEvento"]; ?></option>" +
                                                    "<?php  } ?> " +
                                                "</select> " +
                                            "</fieldset>" +
                                        "</div>" +
                                            "<div id='area-tipo' class='col-md-6' style='display: none;'>" +
                                                "<fieldset class='form-group' style='margin-bottom: 8px;'>" +
                                                    "<label for='codTipoEvento'>Tipo<span style= 'color:red;'>*</span></label>" +
                                                    "<select name='subcategoria' class='form-control c-select' id='codTipoEvento'>" +
                                                        "<option value=''>Selecione</option>" +
                                                        "<?php  $consulta2 = $connection->query('SELECT * FROM tipoevento WHERE codCategoriaEvento = (SELECT codCategoriaEvento FROM categoriaevento ORDER BY desCategoriaEvento LIMIT 1) ORDER BY desTipoEvento'); ?> " +
                                                        "<?php  while( $row2 = $consulta2->fetch_assoc() ){  ?> " +
                                                        "<option value=<?php  echo $row2["codTipoEvento"];?>>" +
                                                        "<?php  echo $row2["desTipoEvento"];?></option>" +
                                                        "<?php  } ?> " +
                                                    "</select> " +
                                                "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                        "<div class='col-md-6'>" +
                                            "<fieldset class='form-group' style='margin-bottom: 0'>" +
                                                "<label for=''>Data e Hora da Ocorrência</label>" +
                                                "<div class='input-group date form_datetime col-md-12' data-date-format='dd/mm/yyyy - HH:ii:ss' data-link-field='dtp_input1'>" +
                                                    "<input id='dataHoraOcorrencia' name='dataHoraOcorrencia' class='form-control' size='16' type='text' value=''>" +
                                                    "<span class='input-group-addon'><span class='glyphicon glyphicon-calendar'></span></span>" +
                                                "</div>" +
                                                "<input type='hidden' id='dtp_input1' value='' />" +
                                            "</fieldset>" +
                                        "</div>" +
                                        "<div class='col-md-6'>" +
                                            "<fieldset class='form-group' style='margin-bottom: 0'>" +
                                                "<label for=''>Data e Hora da Colaboração</label>" +
                                                "<input id='dataHoraDaColaboracao' name='dataHoraDaColaboracao' class='form-control' data-date-format='dd/mm/yyyy - H:i' size='16' type='text' value='' readonly>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row' style='text-align: center; margin-bottom: 5px'>" +
                                        "<div class='col-md-12'>" +
                                            "<small class='text-center'>Obs.: O momento da ocorrência pode ser diferente do momento da colaboração.</small>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                        "<div class='col-md-12'>" +
                                            "<fieldset class='form-group' style='margin-bottom: 0;'>" +
                                                "<label for='desColaboracao'>Descrição da colaboração<span style= 'color:red;'>*</span></label>" +
                                                "<textarea class='form-control' rows='3' id='desColaboracao' name='desColaboracao' style='resize: none;' placeholder='Descreva sua colaboração' required='required' title='Descreva sua colaboração'  x-moz-errormessage='Descreva sua colaboração'></textarea>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                       "<div class='col-md-12'>" +
                                        "<small>(<span style= 'color:red;'>*</span>) Campos Obrigatórios</small>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row text-center'>" +
                                        "<div class='col-md-12'>" +
                                            "<button type='button' class='btn btn-danger' style='margin-right: 20px' onclick='fecharMarker(); ga(\"send\", \"event\", \"Clique\", \"Botão\", \"Remover Marcador\");'><span class='glyphicon glyphicon-remove'></span> <strong>Remover Marcador</strong></button>" +
                                            "<button type='submit' class='btn btn-success' onclick='ga(\"send\", \"event\", \"Clique\", \"Botão\", \"Enviar Colaboração\");'><span class='glyphicon glyphicon-share-alt'></span> <strong>Enviar Colaboração</strong></button>" +
                                        "</div>" +
                                    "</div>" +
                                "</div>"+
                                "<input type='hidden' name='usuario_id' id='usuario_id' name='usuario_id' value = '<?php echo $_SESSION['code_user_'.$link_inicial]; ?>'/>" +
                                "<input type='hidden' name='latitudeAtual' id='latitudeAtual' />" +
                                "<input type='hidden' name='longitudeAtual' id='longitudeAtual' />" +
                                "<input type='hidden' name='zoom' id='zoom' />" +
                                "<input type='hidden' name='keywords' id='keywords' />" +

                                "<div id='tab-2' class='balao'>" +
                                    "<div class='row'>" +
                                        "<div class='col-md-12'>" +
                                            "<fieldset class='form-group'>" +
                                                "<label for='desTituloImagem'>Título da Imagem<span style= 'color:red;'>*</span></label>" +
                                                "<input class='form-control' type='text' id='desTituloImagem' name='desTituloImagem' placeholder='Informe um título para a imagem' maxlength='100'/>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                        "<div class='col-md-12'>" +
                                            "<fieldset class='form-group'>" +
                                                "<label for='Imagem' class='file'>Imagem<span style= 'color:red;'>*</span></label>" +
                                                "<input type='file' class='filestyle'  name='Imagem' id='Imagem'>" +
                                                "<span class='file-custom'></span>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                        "<div class='col-md-12'>" +
                                            "<fieldset class='form-group'>" +
                                                "<label for='comentImagem'>Comentário da Imagem</label>" +
                                                "<textarea class='form-control' rows='4' id='comentImagem' name='comentImagem' style='resize: none;' placeholder='Descreva a imagem'></textarea>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                       "<div class='col-md-12'>" +
                                        "<small>(<span style= 'color:red;'>*</span>) Campos Obrigatórios</small>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row text-center'>" +
                                        "<div class='col-md-12'>" +
                                            "<button type='submit' class='btn btn-success btn-lg' onclick='ga(\"send\", \"event\", \"Clique\", \"Botão\", \"Enviar Dados - Imagem\");'><span class='glyphicon glyphicon-share-alt'></span> <strong>Enviar Dados</strong></button>" +
                                        "</div>" +
                                    "</div>" +
                                "</div>"+

                                "<div id='tab-3' class='balao'>"+

                                    "<div class='row'>" +
                                        "<div class='col-md-12'>" +
                                            "<fieldset class='form-group'>" +
                                                "<label for='desTituloVideo'>Título do Video<span style= 'color:red;'>*</span></label>" +
                                                "<input class='form-control' type='text' id='desTituloVideo' name='desTituloVideo' placeholder='Informe um título para o vídeo' maxlength='100'/>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                        "<div class='col-md-12'  style='margin-bottom: 5px;'>" +
                                            "<fieldset class='form-group' style='margin-bottom: 0'>" +
                                                "<label for='desUrlVideo'>URL do Video<span style= 'color:red;'>*</span></label>" +
                                                "<input class='form-control' type='text' id='desUrlVideo' name='desUrlVideo' placeholder='Informe a URL do vídeo'/>" +
                                            "</fieldset>" +
                                            "<small><strong>Obs.:</strong> Apenas Urls de Video do YouTube</small>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                        "<div class='col-md-12'>" +
                                            "<fieldset class='form-group'>" +
                                                "<label for='comentVideo'>Comentário do Vídeo</label>" +
                                                "<textarea class='form-control' rows='4' id='comentVideo' name='comentVideo' style='resize: none;' placeholder='Descreva o vídeo'></textarea>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                       "<div class='col-md-12'>" +
                                        "<small>(<span style= 'color:red;'>*</span>) Campos Obrigatórios</small>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row text-center'>" +
                                        "<div class='col-md-12'>" +
                                            "<button type='submit' class='btn btn-success btn-lg'  onclick='ga(\"send\", \"event\", \"Clique\", \"Botão\", \"Enviar Dados - Vídeo\");'><span class='glyphicon glyphicon-share-alt'></span> <strong>Enviar Dados</strong></button>" +
                                        "</div>" +
                                    "</div>" +
                                "</div>"+

                                '<div id="tab-4" class="balao">' +
                                    "<div class='row'>" +
                                        "<div class='col-md-12'>" +
                                            "<fieldset class='form-group'>" +
                                                "<label for='desArquivo'>Título do Arquivo<span style= 'color:red;'>*</span></label>" +
                                                "<input class='form-control' type='text' id='desArquivo' name='desArquivo' placeholder='Informe um título para o arquivo' maxlength='100'/>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                        "<div class='col-md-12'>" +
                                            "<fieldset class='form-group'>" +
                                                "<label for='arquivo' class='file'>Arquivo<span style= 'color:red;'>*</span></label>" +
                                                "<input type='file' class='filestyle'  name='arquivo' id='arquivo'>" +
                                                "<span class='file-custom'></span>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                        "<div class='col-md-12'>" +
                                            "<fieldset class='form-group'>" +
                                                "<label for='comentArq'>Comentário do Arquivo</label>" +
                                                "<textarea class='form-control' rows='4' id='comentArq' name='comentArq' style='resize: none;' placeholder='Descreva o arquivo'></textarea>" +
                                            "</fieldset>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row'>" +
                                       "<div class='col-md-12'>" +
                                        "<small>(<span style= 'color:red;'>*</span>) Campos Obrigatórios</small>" +
                                        "</div>" +
                                    "</div>" +

                                    "<div class='row text-center'>" +
                                        "<div class='col-md-12'>" +
                                            "<button type='submit' class='btn btn-success btn-lg' onclick='ga(\"send\", \"event\", \"Clique\", \"Botão\", \"Enviar Dados - Arquivo\");'><span class='glyphicon glyphicon-share-alt'></span> <strong>Enviar Dados</strong></button>" +
                                        "</div>" +
                                    "</div>" +
                                "</div>" +
                            "</div>" +
                        "</form>" +
                    "</div>" +
                "</body>" +
            "</html>";

        infowindow = new google.maps.InfoWindow({content: html});

        google.maps.event.addListener(infowindow, 'domready', function()
        {
            $("#tabs").tabs();

            var options =
            {
                target:        '#output1',
                beforeSubmit:  showRequest,
                success:       showResponse
            };

            // Bind formulário usando 'ajaxForm'
            $('#frmArq').ajaxForm(options);
            DataHora();
            $('#infowindowmarker').parent().css('overflow', 'hidden');
            $('div.gm-style-iw').children().css('overflow', 'hidden');

            $('.form_datetime').datetimepicker({
                language:  'pt-BR',
                endDate: new Date(),
                weekStart: 1,
                todayBtn:  1,
                autoclose: 1,
                todayHighlight: 1,
                startView: 2,
                forceParse: 0,
                showMeridian: 1
            });

            $(":file").filestyle();
            $('.buttonText').attr('style', 'margin-left:7px');
            $('#Imagem').parent().find('.buttonText').html('Selecione a Imagem');
            $('#arquivo').parent().find('.buttonText').html('Selecione o Arquivo');

            $('#frmArq').submit(function(event)
            {
                mapmode = 'keys';
                $('#map_canvas').trigger('mode_changed');
            });
        });

        google.maps.event.addListener(infowindow, 'closeclick', function(event)
        {
            mapmode = 'colab';
            $('#map_canvas').trigger('mode_changed');
        });

        google.maps.event.addListener(map, 'click', function(event)
        {
            var marker;
            marker = new google.maps.Marker(
            {
                position: event.latLng,
                map: map,
                draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function() { geocodePosition(marker.getPosition()); });

            geocodePosition(marker.getPosition());

            if (infowindow) infowindow.close();
            if (infowindowLoadMarker) infowindowLoadMarker.close();
            if (marcadorGlobal) marcadorGlobal.setMap(null);

            marcadorGlobal = marker;
            infowindow.open(map, marker);
            latlngMarcadorAtual = marker.getPosition();
            zoom = map.getZoom();

            google.maps.event.addListener(marker, 'click', function()
            {
                if (infowindowLoadMarker) infowindowLoadMarker.close();
                infowindow.open(map, marker);
                latlngMarcadorAtual = marker.getPosition();
            });

            mapmode = 'winop';
            $('#map_canvas').trigger('mode_changed');
        });
    }

    function getKeywords()
    {
        $('#keywordstxt').val('');
        if ($('#desTituloAssunto').val() != '' && $('#codCategoriaEvento').val() != '' && $('#desColaboracao').val() != '')
        {
            $('#modal-keywords').modal('toggle');
            return false;
        }
        else
        {
            $.blockUI({ message: 'Enviando Colaboração...' });
            $('#latitudeAtual').val(latlngMarcadorAtual.lat());
            $('#longitudeAtual').val(latlngMarcadorAtual.lng());
            $('#zoom').val(zoom);
        }
    }

    function save_keywords()
    {
        if ($('#keywordstxt').val() != '') {
            $('#keywords').val($('#keywordstxt').val());
        }
        atualizaLongLat();
    }

    function atualizaLongLat()
    {
        $.blockUI({ message: 'Enviando Colaboração...' });
        $('#latitudeAtual').val(latlngMarcadorAtual.lat());
        $('#longitudeAtual').val(latlngMarcadorAtual.lng());
        $('#zoom').val(zoom);
        $('#frmArq').submit();
    }

    function enviaEmail()
    {
        ga('send', 'event', 'Função', 'Envia Email', 'Entrada');
        // $.get('email_apos_colaboracao.php', {}, function(data) {});
        var xmlhttp = new XMLHttpRequest();

        xmlhttp.open("GET", "email_apos_colaboracao.php", true);
        xmlhttp.onreadystatechange = function()
        {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200){
                var results = xmlhttp.responseText;
                ga('send', 'event', 'Função', 'Envia Email', 'Sucesso');
            }else {
                ga('send', 'event', 'Função', 'Envia Email', 'Falha');
            }
        }

        xmlhttp.send(null);
    }

    //  --------------------  JQUERY  --------------------//

    // Pre-submit callback
    function showRequest(formData, jqForm, options)
    {
        var queryString = $.param(formData);
        return true;
    }

    // Post-submit callback
    function showResponse(responseText, statusText, xhr, $form)
    {
        enviaEmail();

        $.unblockUI();
        if (responseText.substr(0, 1) == '#')
        {
            $.post('verifica_se_sera_bloqueado.php', {user_id: <?php echo $_SESSION['code_user_'.$link_inicial]; ?>} , function (data){
                var nome_usuario = "<?php echo $_SESSION['name_user_'.$link_inicial]; ?>";
                var primeiras_letras = "";
                for (var i = 0; i < 7; ++i)
                    primeiras_letras += nome_usuario[i];
                if (primeiras_letras == 'Anonimo') {
                    bootbox.alert('Por ser um usuário anônimo, sua colaboração será analisada antes de divulgada. Caso deseje que a colaboração apareça no mapa instantaneamente, realize um registro!<br><div style="margin-top: 30px; color: red;" class="text-center"><strong>' + data + '</strong></div>');

                    ga('send', 'event', 'Função', 'Colaboração', 'Anônima');
                } else {
                    $.post('quantidade_colaboracao.php', {user_id: <?php echo $_SESSION['code_user_'.$link_inicial]; ?>} , function (resposta){
                        if (resposta == 1) {
                            $('#info-selos').modal("show");
                        } else {
                            bootbox.alert("Colaboração Enviada com Sucesso !!!" + '<br><div style="margin-top: 30px; color: red;" class="text-center"><strong>' + data + '</strong></div>');

                            ga('send', 'event', 'Função', 'Colaboração', 'Sucesso');
                        }
                    });
                }
            });

            $('#frmArq').each (function(){
                this.reset();
            });
        }
        else{
            bootbox.alert(responseText);
        }

        fecharMarker();
        load_marker();

        var id_atual = parseInt(responseText.substr(1));
        if ((id_atual > 0) && (!isNaN(id_atual))){
            open_infowindows_especifico(id_atual, listaMarcadores[id_atual]);
        }
    }

    // Post-submit callback
    function showResponse2(responseText, statusText, xhr, $form)
    {
        ga('send', 'event', 'Função', 'Colaboração Atualizada', 'Entrada');
        if (responseText.substr(0, 1) != '#'){
            bootbox.alert(responseText);
            ga('send', 'event', 'Função', 'Colaboração Atualizada', 'Falha');
        } else {
            if (infowindowLoadMarker) infowindowLoadMarker.close();

            bootbox.alert('Colaboração Atualizada com Sucesso!!!');
            ga('send', 'event', 'Função', 'Colaboração Atualizada', 'Sucesso');


            var id_atual = parseInt(responseText.substr(1));
            if ((id_atual > 0) && (!isNaN(id_atual))){
                open_infowindows_especifico(id_atual, listaMarcadores[id_atual]);
            }
        }
    }

    //  --------------------  JQUERY FIM  --------------------//

    function fecharMarker()
    {
        var t = setTimeout('infowindow.close();', 10);
        var t = setTimeout('marcadorGlobal.setMap(null);', 10);
    }

    function geocodePosition(pos)
    {
        geocoder.geocode({latLng: pos}, function(responses)
        {
            if (responses && responses.length > 0) updateMarkerAddress(responses[0].formatted_address);
            else updateMarkerAddress('Cannot determine address at this location.');
        });
    }

    function updateMarkerAddress(str) { document.getElementById('geocode').value = str; }

    // REMOVE
    function modoFull()
    {
        ga('send', 'event', 'Função', 'Modo Visualização', 'Full');
        $('#div_centro').css('width', '100%');
        $('#map_canvas').css('width', '100%');
        $('#map_canvas').css('height', '92%');
        $('#modoNormal').attr('class', 'button');
        $('#modoFull').attr('class', 'button middle ativo2');
        initialize('full');
    }

    function modoNormal()
    {
        ga('send', 'event', 'Função', 'Modo Visualização', 'Normal');
        $('#div_centro').css('width', '1000px');
        $('#map_canvas').css('width', '100%');
        $('#map_canvas').css('height', '600px');
        $('#modoFull').attr('class', 'button');
        $('#modoNormal').attr('class', 'button middle ativo2');
        initialize('normal');
    }
</script>