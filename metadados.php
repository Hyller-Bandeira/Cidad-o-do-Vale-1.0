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
            "script" => array("http://maps.google.com/maps/api/js?key=AIzaSyAHSnQ6TnIM1jXJCfc79MJw2jB5Qj5KwuM&libraries=places,visualization,drawing",
					//"src/jquery-ui-1.11.4.custom/external/jquery/jquery.js",
					//"src/jquery-ui-1.11.4.custom/jquery-ui.min.js",
					"jsor-jcarousel/lib/jquery.jcarousel.min.js",
					"src/jquery.blockUI.js",
					"src/util.js",
                    "map.js",
					"src/markerclusterer_packed.js"),
		"css" => array("jsor-jcarousel/skins/tango/skin.css",
				 "src/jquery-ui-1.11.4.custom/jquery-ui.min.css",
				 "style/metadados.css"),
		"required" => array("index.js.php")));
	?>

<body onload="initialize()" style="margin: 0;" class="corposite">

	<?php require 'header.php'; ?>

	<script type='text/javascript'>
		'use strict';

        google.maps.event.addDomListener(window, 'load', mapaDeBusca);
		var element;
		var norte;
		var sul;
		var leste;
		var oeste;

		function enviarFormulario()
		{
			$.blockUI({ message: 'Carregando Metadados' });

			var search = $('#search').val();
			var dataInicio = $('#datepicker').val();
			var dataFim = $('#datepicker_2').val();
			var categoria_atual = $('#selectCategoria').val();
			var tipo_atual = $('#selectTipo').val();

			$.get('search.php', {search: search, categoria_atual: categoria_atual, tipo_atual: tipo_atual,
								 norte: norte, dataInicio: dataInicio, dataFim: dataFim, sul: sul,
								 leste: leste, oeste: oeste}, function(data)
			{
				//alert(data);
				$('#variosMetadados').html('');
				gerageraVariosMetadadosResumidos(data);
				$.unblockUI();
			});
		}

		function gerageraVariosMetadadosResumidos(data)
		{
			var xmlhttp = new XMLHttpRequest();

			xmlhttp.open("GET", "gera_metadados_resumidos.php?id=" + data, false);
			xmlhttp.onreadystatechange=function()
			{
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
				{
					var results = xmlhttp.responseText;
					var metadados = $("#variosMetadados");

					var xml = parseXml(results);
					var colaboracao = xml.documentElement.getElementsByTagName("marker");
					for (var i = 0; i < colaboracao.length; ++i)
					{
						var id_corrente = colaboracao[i].getAttribute("codColaboracao");
						metadados.append("<fieldset align = 'left' style = 'width:460px; border-width:5px;'><fieldset><table width = '430px'>" +

						 "<tr bgcolor='#d6d6d6'><td class = 'tdMDfixo2' > Título:</td><td class = 'tdMDdinamico2'>" + colaboracao[i].getAttribute("desTituloAssunto") + "</td></tr>"+
						 "<tr bgcolor='#ffffff'><td class = 'tdMDfixo2'>Categoria:</td><td class = 'tdMDdinamico2'>" + colaboracao[i].getAttribute("desCategoriaEvento")+ "</td></tr>"+
						 "<tr bgcolor='#d6d6d6'><td class = 'tdMDfixo2'>Tipo:</td><td class = 'tdMDdinamico2'>" + (colaboracao[i].getAttribute("desTipoEvento") == '' ? '-' : colaboracao[i].getAttribute("desTipoEvento")) + "</td></tr>"+
						 "<tr bgcolor='#ffffff'><td class = 'tdMDfixo2'>Data e Hora:</td><td class = 'tdMDdinamico2'>" + colaboracao[i].getAttribute("datahoraCriacao")+ "</td></tr>"+
						 "</table></fieldset><br />" +
                         "<button id='expandir" + id_corrente + "' name='expandir' class='btn btn-warning active' onclick='geraVariosMetadados("+id_corrente+"); ga(&#039;send&#039;, &#039;event&#039;, &#039;Clique&#039;, &#039;Botão&#039;, &#039;Expandir Metadados&#039;);'  style = 'margin: 0 7px; background-color:rgb(247, 68, 69)' ><strong> <span class='glyphicon glyphicon-resize-full'></span> Expandir metadados</strong></button>"+
                         "<button id='contrair" + id_corrente + "' name='contrair' class='btn btn-warning active' onclick='fecharMetadados("+id_corrente+"); ga(&#039;send&#039;, &#039;event&#039;, &#039;Clique&#039;, &#039;Botão&#039;, &#039;Fechar Expansão Metadados&#039;);' style = 'display:none; margin: 0 7px; background-color:rgb(247, 68, 69)' ><strong> <span class='glyphicon glyphicon-resize-small'></span> Fechar expansão</strong></button>"+

                         "<button class='btn btn-warning active' style='background-color:rgb(247, 68, 69)' onclick='pre_enviar("+id_corrente+"); ga(&#039;send&#039;, &#039;event&#039;, &#039;Clique&#039;, &#039;Botão&#039;, &#039;Visualizar Metadados&#039;);'><strong> <span class='glyphicon glyphicon-eye-open' style = 'margin: 0 7px;' ></span> Visualizar</strong></button>"+

						 "<span id=metadadosAtual" + id_corrente +"> </span>"+

						 "</fieldset><br />");
					}

					window.location.hash = "";
					window.location.hash = "localDosMetadados";

                    if (colaboracao.length == 0) {
                        bootbox.alert('Nenhuma colaboração foi encontrada!');
                        $('#map_canvas').hide();
                        $('#botoesHeatMap').hide();
                        $('#buscaNoGoogleMaps').hide();
                    }
				}
			}

			xmlhttp.send(null);
		}

		function pre_enviar(id_corrente)
		{
			$('#map_canvas').css('display', 'block');
			$('#botoesHeatMap').css('display', 'block');
			$('#buscaNoGoogleMaps').css('display', 'block');
			initialize();
			enviar (id_corrente);
		}

		function geraVariosMetadados(id)
		{
			// $.get('gera_metadados.php', {id: id}, function(data)
			// {
			// 	$('#metadadosAtual' + id).css('display', 'inline').html('<br /><br /><fieldset>' + data + '</fieldset>');
			// 	$('#expandir' + id).css('display', 'none');
			// 	$('#contrair' + id).css('display', 'inline');

			// 	window.location.hash = '';
			// 	window.location.hash = 'metadadosAtual' + id;
			// });

			var xmlhttp = new XMLHttpRequest();

			xmlhttp.open("GET", "gera_metadados.php?id=" + id, false);
			xmlhttp.onreadystatechange=function()
			{
				if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
				{
                    $("metadadosAtual" + id).attr("style", "display:inline");
					var results = xmlhttp.responseText;
					var metadados = $("#metadadosAtual" + id);
					metadados.html("<br /><br /><fieldset>" + results + "</fieldset>");

                    $("expandir" + id).attr("style", "display:inline");
                    $("contrair" + id).attr("style", "display:inline");

					window.location.hash = "";
					window.location.hash = "metadadosAtual" + id;
				}
			}

			xmlhttp.send(null);
		}

		function fecharMetadados(id)
		{
			$('#metadadosAtual' + id).css('display', 'none');
			$('#expandir' + id).css('display', 'inline');
			$('#contrair' + id).css('display', 'none');
		}

		function mapaDeBusca()
		{
			var longitude_inicial = parseFloat($("#longitude_inicial").val());
			var latitude_inicial = parseFloat($("#latitude_inicial").val());
			var zoom_inicial = parseInt($("#zoom_inicial").val());
			var tipoMapa_inicial = $("#tipoMapa_inicial").val();

			var latlng = new google.maps.LatLng(latitude_inicial, longitude_inicial);
			if(tipoMapa_inicial == 'SATELLITE')
				var myOptions =
				{
					zoom: zoom_inicial,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.SATELLITE,
					scrollwheel: true
				};
			else if(tipoMapa_inicial == 'TERRAIN')
				var myOptions =
				{
					zoom: zoom_inicial,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.TERRAIN,
					scrollwheel: true
				};
			else if(tipoMapa_inicial == 'HYBRID')
				var myOptions =
				{
					zoom: zoom_inicial,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.HYBRID,
					scrollwheel: true
				};
			else
				var myOptions =
				{
					zoom: zoom_inicial,
					center: latlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					scrollwheel: true
				};

			var mapBusca = new google.maps.Map(document.getElementById("map_canvas_busca"), myOptions);

			var drawingManager = new google.maps.drawing.DrawingManager(
			{
				drawingMode: google.maps.drawing.OverlayType.MARKER,
				drawingControl: true,
				drawingControlOptions:
				{
					position: google.maps.ControlPosition.TOP_CENTER,
					drawingModes: [google.maps.drawing.OverlayType.RECTANGLE]
				},
				markerOptions:
				{
					icon: 'images/beachflag.png',
					title: 'teste'
				},
				rectangleOptions:
				{
					fillColor: '#ffffff',
					fillOpacity: 0,
					strokeColor: '#ff0000',
					strokeWeight: 1,
					clickable: true,
					draggable: true,
					editable: true,
					zIndex: 1
				}
			});

			drawingManager.setMap(mapBusca);
			drawingManager.setDrawingMode(google.maps.drawing.OverlayType.RECTANGLE);

			google.maps.event.addDomListener(drawingManager, 'rectanglecomplete', function fecharDraw (event)
			{
				drawingManager.setDrawingMode(null);

				if (element) element.setMap(null);
				element = event;
				var norteLesteSulOeste = element.getBounds();
				var norteLeste = norteLesteSulOeste.getNorthEast();
				var SulOeste = norteLesteSulOeste.getSouthWest();
				norte = norteLeste.lat();
				leste = norteLeste.lng();
				sul = SulOeste.lat();
				oeste = SulOeste.lng();

				google.maps.event.addDomListener (element, 'bounds_changed', function atualizaRetangulo (event)
				{
					var norteLesteSulOeste = element.getBounds();
					norteLeste = norteLesteSulOeste.getNorthEast();
					SulOeste = norteLesteSulOeste.getSouthWest();
					norte = norteLeste.lat();
					leste = norteLeste.lng();
					sul = SulOeste.lat();
					oeste = SulOeste.lng();
				});

			});
		} // final do inicializar

		$(function()
		{
			$('#datepicker').datepicker(
			{
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd/mm/yy',
				dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
				dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
				dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
				monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
				monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
				nextText: 'Próximo',
				prevText: 'Anterior'
			});
			$('#datepicker_2').datepicker(
			{
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd/mm/yy',
				dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
				dayNamesMin: ['D','S','T','Q','Q','S','S','D'],
				dayNamesShort: ['Dom','Seg','Ter','Qua','Qui','Sex','Sáb','Dom'],
				monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
				monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
				nextText: 'Próximo',
				prevText: 'Anterior'
			});
		});

		function loadXMLDoc(valor)
		{
			$.get('result.php', {id: valor}, function(data)
			{
				var campo_select = document.getElementById('selectTipo');
				campo_select.options.length = 0;
				data = data.split(",");
				campo_select.options[0] = new Option( 'Todos', '' );
				for(var i = 0; i < data.length; ++i)
				{
					var str = data[i].split( "|" );
					campo_select.options[i + 1] = new Option( str[0], str[1]);
				}
                if (campo_select.length > 2) {
                    $('#tipo-select').show();
                } else {
                    $('#tipo-select').hide();
                }
			});
		}
	</script>

	<div class="div_centro">
		<center  class="font8">
			<fieldset width = '100%'>
				<legend><h3>Pesquisar Metadados</h3></legend>
				<b>Busca espacial: Desenhe um retângulo envolvente no mapa.</b><br /><br />
				<div id="map_canvas_busca" style="width:400px;height:300px;" ></div><br />

				<b>Busca Temporal</b><br /><br />
				Data Inicial: <input type="text" id="datepicker"/>
				Data Final: <input type="text" id="datepicker_2"/>

				<br /><br /><b>Busca Categoria e Tipo</b><br /><br />

				<?php require 'phpsqlinfo_dbinfo.php'; ?>
				Categoria:
				<select name='selectCategoria' id = 'selectCategoria' onchange='loadXMLDoc( this.value )' class='form'>
					<option value=''>Todas</option>
						<?php $consulta = $connection->query('SELECT * FROM categoriaevento'); ?>
						<?php while($row = $consulta->fetch_assoc())
						{ ?>
				 			<option value=<?php echo $row["codCategoriaEvento"]; ?>>
				 			<?php echo $row["desCategoriaEvento"];?></option>
						<?php } ?>
				</select>
				<span id='tipo-select' style="display: none;">
                    Tipo:
                    <select name='selectTipo' id = 'selectTipo'  class='form'>
                    </select>
                </span>

				<input type="hidden" name="longitude_inicial" id="longitude_inicial" value="<?php  echo $longitude_inicial; ?>">
				<input type="hidden" name="latitude_inicial" id="latitude_inicial" value="<?php  echo $latitude_inicial; ?>">
				<input type="hidden" name="zoom_inicial" id="zoom_inicial" value="<?php  echo $zoom_inicial; ?>">
				<input type="hidden" name="tipoMapa_inicial" id="tipoMapa_inicial" value="<?php  echo $tipoMapa_inicial; ?>">

				<form id = 'formularioBusca' name = 'formularioBusca' action="javascript:enviarFormulario()" method='GET'>
					<h3 class="font8" id='localDosMetadados' name='localDosMetadados'>Busca Textual</h3>
					<input type='text' size='90' id='search' name='search'></br></br>
                    <button type="submit" name='submit' class="btn btn-warning active" onclick="ga('send', 'event', 'Clique', 'Botão', 'Pesquisar Metadados');" style="background-color:rgb(247, 68, 69)"><strong> <span class="glyphicon glyphicon-search"></span> Pesquisar</strong></button>
				</form>
			</fieldset>
		</center>
		<hr>
		<div  align = 'center' class="font8">
			<div id="variosMetadados" name="variosMetadados"></div>
		</div>
		<hr>

		<div id="map_canvas" style="width: 100%; height: 600px; display: none;" ></div><br />

		<div id="botoesHeatMap" class="centro" style='display: none;'>
            <?php include 'partials/heatmap_opcoes.php'; ?>
		</div>
	</div>

    <?php include 'partials/rodape.php'; ?>
</body>
</html>
