// Event:	codCategoriaEvento, codTipoEvento, desTituloAssunto, dataOcorrencia, horaOcorrencia, desColaboracao,
// 			tipoStatus, codColaboracao, notaMedia, forum, qtdVisualizacao, qtdAvaliacao, datahoraCriacao
// Image:	desTituloImagem, endImagem, comentarioImagem
// Video:	desTituloVideo, desUrlVideo, comentarioVideo
// File:	comentarioArquivo, tituloArquivo, endArquivo

'use strict';

// HomeControl.prototype.marcar = null;		// Marked for removal
// var marker_atual;						// Marked for removal
// var pos_info_win = 0;					// Marked for removal
// var tipoStatus;							// Marked for removal
// var pointarray;							// Marked for removal
// var colaborar = false;					// Marked for removal
var listaCluster = [];
var pos = 0;
var latlng;
var listaInfowindowLoadMarker = [];
var edicao = 'false';
var markerCluster;
var map;								// Used in: initialize(), remove_marker_click()
var geocoder = null;					// Used in: initialize(), geocodePosition()
var marker;								// Used in: createInfoWindows()
var infowindow;							// Used in: loadXMLDocNota(), fecharMarker()
var infowindowLoadMarker;				// Used in: loadXMLDocNota(), wikiVGI(), showResponse2()
var latlngMarcadorAtual;				// Used in: atualizaLongLat()
var marcadorGlobal;						// Used in: fecharMarker()
var listaMarcadores = [];				// Used in: wikiVGI(), showResponse(), showResponse2()
var heatmap;							// Used in: initialize()
var VGI_Data = [];						// Used in: initialize()
var zoom;								// Used in: atualizaLongLat()
var id_marcador_atual;					// Used in: wikiVGI(), showResponse2()

// Uses globals: map, geocoder, pointarray, heatmap
// Calls: load_marker_filtro(), load_marker()
// Uses google's stuff
function initialize(modo)
{
	var longitude_inicial = parseFloat($('#longitude_inicial').val());
	var latitude_inicial = parseFloat($('#latitude_inicial').val());
	var zoom_inicial = parseInt($('#zoom_inicial').val());
	var tipoMapa_inicial = $('#tipoMapa_inicial').val();
	var latlng = new google.maps.LatLng(latitude_inicial, longitude_inicial);
	var myOptions =
	{
		zoom: zoom_inicial,
		center: latlng,
		scrollwheel: false
	};

	if (tipoMapa_inicial == 'SATELLITE') myOptions['mapTypeId'] = google.maps.MapTypeId.SATELLITE;
	else if (tipoMapa_inicial == 'TERRAIN') myOptions['mapTypeId'] = google.maps.MapTypeId.TERRAIN;
	else if (tipoMapa_inicial == 'HYBRID') myOptions['mapTypeId'] = google.maps.MapTypeId.HYBRID;
	else myOptions['mapTypeId'] = google.maps.MapTypeId.ROADMAP;

	map = new google.maps.Map($('#map_canvas'), myOptions);

	// Botoes colaborar e visualizar
	var homeControlDiv = document.createElement('div');
	var homeControlDiv2 = document.createElement('div');
	var homeControl = new HomeControl(homeControlDiv, homeControlDiv2, map);
	homeControlDiv.index = 1;
	homeControlDiv2.index = 2;
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(homeControlDiv);
	map.controls[google.maps.ControlPosition.TOP_LEFT].push(homeControlDiv2);

	if ($('ids_filtros').length > 0) load_marker_filtro($('ids_filtros').val());
	else load_marker();

	// Geocode e autocomplete
	geocoder = new google.maps.Geocoder();

	var input = $('#geocode');
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
		radius: 20
	});
}

function loadXMLDoc(valor)
{
	$.get('result.php', {id: valor}, function(data)
	{
		var campo_select = document.forms[2].subcategoria;
		campo_select.options.length = 0;
		data = data.split(',');
		for(var i = 0; i < data.length; ++i)
		{
			var str = data[i].split('|');
			campo_select.options[i] = new Option(str[0], str[1]);
		}
	});
}

function loadXMLDoc2()
{
	var xmlhttp = new XMLHttpRequest();

	var valor1 = $('#Comentario').desComentario.val();
	var valor2 = $('#Comentario').usuario_id.val();
	var valor3 = $('#Comentario').codColaboracao.val();
	xmlhttp.open('POST', 'comentario.php', true);
	xmlhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');	// Setando Content-type
	var str = 'desComentario=' + valor1 + '&usuario_id=' + valor2 + '&codColaboracao=' + valor3;
	xmlhttp.send(str);
	var forum;
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			var results = xmlhttp.responseText;
			downloadUrl(base + 'phpsqlajax_genxml_forum.php?valor3=' + valor3, function(data)
			{
				var xml = parseXml(data);
				var colaboracao = xml.documentElement.getElementsByTagName('marker');
				forum = colaboracao[0].getAttribute('forum');
				$('#divForum').html(forum);
				alert('Comentário Adicionado com Sucesso!!!');
			});
		}
	}

	$('#desComentario').val('');
	return true;
}

function jaAvaliou(codUsuario, codColaboracao)
{
	var results = 0;
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.open('GET', 'jaAvaliou.php?codUsuario=' + codUsuario + '&codColaboracao=' + codColaboracao , false);
	xmlhttp.send(null);

	if (xmlhttp.status == 200) results = xmlhttp.responseText;
	return (results != 0);
}

// Uses globals:
// infowindow, infowindowLoadMarker
// Calls: open_infowindows_especifico()
function loadXMLDocNota(nota, codUsuario, codColaboracao)
{
	if (nota)
	{
		$.get('nota.php', {nota: nota, codUsuario: codUsuario, codColaboracao: codColaboracao}, function(data)
		{
			if (infowindow)	infowindow.close();
			if (infowindowLoadMarker) infowindowLoadMarker.close();

			alert('Nota fornecida com sucesso!!');
			open_infowindows_especifico(codColaboracao, listaMarcadores[codColaboracao]);
		});
		
		$('#formularioNota').css('visibility', 'hidden');
	}
	else alert('Escolha uma nota.');
}

// Calls: remove_marker_click(), marker_click()
// Uses google's stuff
// 'map' parameter is not used
function HomeControl(div, div2, map)
{
	var controlDiv = div;
	var controlDiv2 = div2;

	controlDiv.style.padding = '5px';
	controlDiv2.style.padding = '5px';

	// Set CSS for the control border
	var controlUI = document.createElement('div');
	controlUI.style.backgroundColor = 'white';
	controlUI.style.borderStyle = 'solid';
	controlUI.style.borderWidth = '1px';
	controlUI.style.cursor = 'pointer';
	controlUI.style.textAlign = 'center';
	controlUI.title = 'Clique aqui para visualizar';
	controlDiv.appendChild(controlUI);

	// Set CSS for the control interior
	var controlText = document.createElement('div');
	controlText.style.fontFamily = 'Arial, sans-serif';
	controlText.style.fontSize = '15px';
	controlText.style.paddingLeft = '20px';
	controlText.style.paddingRight = '20px';
	controlText.style.color = '#999999';
	controlText.innerHTML = 'Visualizar';
	controlUI.appendChild(controlText);

	// Set CSS for the control border
	var controlUI2 = document.createElement('div');
	controlUI2.style.backgroundColor = 'white';
	controlUI2.style.borderStyle = 'solid';
	controlUI2.style.borderWidth = '1px';
	controlUI2.style.cursor = 'pointer';
	controlUI2.style.textAlign = 'center';
	controlUI2.title = 'Clique aqui para colaborar';
	controlDiv2.appendChild(controlUI2);

	// Set CSS for the control interior
	var controlText2 = document.createElement('div');
	controlText2.style.fontFamily = 'Arial, sans-serif';
	controlText2.style.fontSize = '15px';
	controlText2.style.paddingLeft = '20px';
	controlText2.style.paddingRight = '20px';
	controlText2.innerHTML = 'Colaborar';
	controlUI2.appendChild(controlText2);

	var colaborar;
	google.maps.event.addDomListener(controlUI, 'click', function()
	{
		colaborar = false;
		controlText2.style.background = 'white';
		controlText2.style.color = '#000000';
		controlText.style.background = 'linear-gradient(to bottom, rgb(121, 121, 121) 40%, rgb(63, 63, 63) 70%);';
		controlText.style.color = '#999999';
		remove_marker_click();
	});

	google.maps.event.addDomListener(controlUI2, 'click', function()
	{
		colaborar = true;
		controlText.style.background = 'white';
		controlText.style.color = '#000000';
		controlText2.style.background = 'linear-gradient(to bottom, rgb(121, 121, 121) 40%, rgb(63, 63, 63) 70%);';
		controlText2.style.color = '#999999';
		marker_click();
	});
}

function createInfoWindows(event, image, video, file)
{
	// Event
	$('#event_desc_title_subj').html(event.desc_title_subj);
	$('#event_cod_cat_type').html('Categoria: ' + event.cod_cat + '  |  Tipo: ' + event.cod_type);
	$('#event_date_time').html(event.date + (event.timevt != '' ? ' - ' + event.timevt : ''));
	$('#event_datetime_creation').html(event.datetime_creation);
	$('#save_button').onclick = function() { Salvar(event.cod_colab); }

	$('#event_desc_colab').html(event.desc_colab);

	var all_desc_colabs = event.desc_colab.split('¥');
	var nWikis = all_desc_colabs.length;
	var ul = $('#mycarousel');

	for (var i = nWikis - 2; i >= 0; ++i)
	{
		var element = document.createElement('li');
		var text = document.createTextNode(all_desc_colabs[i]);
		element.appendChild(text);

		ul.insertBefore(element, ul.childNodes[0]);
	}

	$('#all_desc_colab_a').html(all_desc_colabs[nWikis - 1]);
	$('#all_desc_colab_a').html(all_desc_colabs[nWikis - 1]);

	if (event.type_status == 'A') $('#event_type_status').html('Status: Colaboração aprovada.');
	else if (event.type_status == 'E') $('#event_type_status').html('Status: Em avaliação.');

	if (!jaAvaliou(code_user, event.cod_colab))
	{
		$('#formularioNota').css('display', 'block');
		$('#botaoNota').onclick = function()
		{
			loadXMLDocNota($('#nota').val(), code_user, event.cod_colab);
		}
	}
	else if (event.amount_grades > 0)
	{
		$('#notaMedia').css('display', 'block');
		$('#event_amount_grades').html(event.amount_grades);
		$('#event_amount_vis').html(event.amount_vis);
		$('#event_avg_grade').html(event.avg_grade);
	}

	$('#usuario_id_a').val(code_user);
	$('#usuario_id_b').val(code_user);

	$('#event_cod_colab_a').val(event.cod_colab);
	$('#event_cod_colab_b').val(event.cod_colab);

	$('#event_forum').html(event.forum);

	// Image
	if (image.address)
	{
		$('#tab-2-hidd').css('display', 'block');
		$('#image_desc_title').html(image.desc_title);
		$('#image_address').src = 'imagensenviadas/' + image.address;

		if (image.comment)
		{
			$('#hascomment').css('display', 'inline');
			$('#image_comment').html(image.comment);
		}
	}
	else
	{
		$('#noimg').css('display', 'table');
	}

	// Video
	if (video.desc_url)
	{
		$('#tab-3-hidd').css('display', 'block');
		$('#video_desc_title').html(video.desc_title);
		$('#video_desc_url').src = 'http://www.youtube.com/v/' + video.desc_url;
		$('#video_fail').href = 'http://www.youtube.com/watch?v=' + video.desc_url;

		if (video.comment)
		{
			$('#hascommentvid').css('display', 'inline');
			$('#video_comment').html(video.comment);
		}
	}
	else
	{
		$('#novideo').css('display', 'inline');
	}

	// File
	if (file.address)
	{
		$('#tab-4-hidd').css('display', 'block');
		$('#file_desc_title').html(file.desc_title);
		$('#file_address').href = 'arquivos/' + file.address;

		if (file.comment)
		{
			$('#file_comment').html(file.comment);
			$('#file_comment').css('display', 'inline');
		}
	}
	else
	{
		$('#nofile').css('display', 'table');
	}

	google.maps.event.addListener(infowindowLoadMarker, 'domready', function()
	{
		$('#tabs').tabs();

		//-- Carousel -- //
		jQuery(document).ready(function()
		{
			jQuery('#mycarousel').jcarousel({visible: 1, start: nWikis}); //nwikis
		});
		//------------------//

		geraMetadados(codColaboracao);
	});

	infowindowLoadMarker.setContent(html);
	map.panTo(marker.getPosition());
	map.setZoom(16);
	infowindowLoadMarker.open(map, marker);

	google.maps.event.addListener(infowindowLoadMarker, 'domready', function()
	{
		var options =
		{
			target:        '#output1',
			beforeSubmit:  showRequest,
			success:       showResponse2
		};

		$('#frmFoto').ajaxForm(options);
	});
}

// Uses globals: infowindowLoadMarker, id_marcador_atual, listaMarcadores
// Calls: open_infowindows_especifico()
function wikiVGI(id, descricao, titulo)
{
	$.get('atualizadescricao.php', {id: id, descricao: descricao, usuario: code_user, titulo: titulo}, function(data)
	{
		if (descricao == '') $('#new_description').val(data);
		else if (titulo == '') $('#new_title').val(data);

		$('#new_description').attr('readonly', 'readonly');	//Coloca o readonly no textarea Descricao
		$('#new_title').attr('readonly', 'readonly');		//Coloca o readonly no textarea Titulo
		$('#new_title').attr('class', 'areatexto');			//Coloca a classe no textarea do titulo novamente

		if (infowindowLoadMarker) infowindowLoadMarker.close();
		alert('Alteração Wiki realizada com sucesso!!!');
		open_infowindows_especifico(id_marcador_atual, listaMarcadores[id_marcador_atual]);
	});
}

function Edicao()
{
	$('#edit_button').css('display', 'none');		// Desabilita Botao Editar
	$('#save_button').css('display', 'block');		// Exibe Botão Salvar
	$('#new_description').removeAttr('readonly');	// Remove o readonly do textarea Descricao e permite a edicao
	$('#new_title').removeAttr('readonly');			// Remove o readonly do textarea Titulo e permite a edicao
	$('#new_title').attr('class', '');				// Remove o class do textarea Titulo
	$('#colab_text').css('display', 'none');
	$('#new_description').css('display', 'block');
}

// Calls: wikiVGI()
function Salvar(codigo)
{
	$('#save_button').css('display', 'none');			// Desabilita Botao Salvar
	$('#edit_button').css('display', 'block');			// Exibe Botão Editar
	var new_title = $('#new_title').val();				// Pega valor do novo Titulo
	var new_description = $('#new_description').val();	// Pega valor da nova colaboração
	wikiVGI(codigo, new_description, new_title);		// Envia para o PHP valores para atualizar a colaboração
	$('#colab_text').css('display', 'block');
	$('#new_description').css('display', 'none');
}

// Uses globals: map
// Uses google's stuff
function remove_marker_click() { google.maps.event.clearListeners(map, 'click'); }

// dataHoraDaColaboracao???
function DataHora()
{
	$.get('dataHoraAtual.php', {}, function(data)
	{
		dataHoraDaColaboracao.html(data);
		setTimeout('DataHora()', 1000);
	});
}

// Uses globals: latlngMarcadorAtual, zoom
function atualizaLongLat()
{
	$.blockUI({ message: 'Enviando Colaboração...' });
	$('#latitudeAtual').val(latlngMarcadorAtual.lat());
	$('#longitudeAtual').val(latlngMarcadorAtual.lng());
	$('#zoom').val(zoom);
}

function enviaEmail() { $.get('email_apos_colaboracao.php', {}, function(data) {}); }

//  --------------------  JQUERY  --------------------//

// Pre-submit callback
// jqForm and options are not used, wth does it do?
function showRequest(formData, jqForm, options)
{
	var queryString = $.param(formData);
	return true;
}

// Post-submit callback
// USES PHP
// Uses globals: listaMarcadores
// Calls: enviaEmail(), open_infowindows_especifico(), fecharMarker(), load_marker()
function showResponse(responseText, statusText, xhr, $form)
{
	enviaEmail();
	$.unblockUI();
	if (responseText == '')
	{
		var nome_usuario = $('name_user').val();
		if (nome_usuario.substring(0, 7) == 'Anonimo')
			alert('Por ser um usuário anônimo, sua colaboração será analisada antes de divulgada. Caso deseje que a colaboração apareça no mapa instantaneamente, realize um registro ou faça login com sua conta do Facebook ou Google!');
		else alert('Colaboração Enviada com Sucesso !!!');
	}
	else alert(responseText);

	fecharMarker();
	load_marker();

	var id_atual = parseInt(responseText);
	if ((id_atual > 0) && (!isNaN(id_atual)))
		open_infowindows_especifico(id_atual, listaMarcadores[id_atual]);
}

// Post-submit callback
// Uses globals: listaMarcadores, id_marcador_atual, infowindowLoadMarker
// Calls: open_infowindows_especifico()
function showResponse2(responseText, statusText, xhr, $form)
{
	alert('Colaboração Atualizada com Sucesso !!!');
	if (infowindowLoadMarker) infowindowLoadMarker.close();
	open_infowindows_especifico(id_marcador_atual, listaMarcadores[id_marcador_atual]);
}

// Uses globals: infowindow, marcadorGlobal
function fecharMarker()
{
	setTimeout('infowindow.close();', 10);
	setTimeout('marcadorGlobal.setMap(null);', 10);
}

// Uses globals: geocoder
// Calls: updateMarkerAddress()
function geocodePosition(pos)
{
	geocoder.geocode({latLng: pos}, function(responses)
	{
		if (responses && responses.length > 0) updateMarkerAddress(responses[0].formatted_address);
		else updateMarkerAddress('Cannot determine address at this location.');
	});
}

function updateMarkerAddress(str) { $('#geocode').val(str); }


// RAW CODE AHEAD =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=


function marker_click()
{
	var html =	"<!DOCTYPE html><html><head><meta charset='utf-8'></head>"+
				"<body><div class='balao' style='width: 430px; height: 410px;'>"+

				"<form id='frmArq' action='phpsqlinfo_addrow.php' method='post' enctype='multipart/form-data' onsubmit='atualizaLongLat()' >"+

				"<div id='tabs'>" +
				"<ul>" +
				"<li><a href='#tab-1'><span>Dados</span></a></li>" +
				"<li><a href='#tab-2'><span>Imagem</span></a></li>" +
				"<li><a href='#tab-3'><span>Vídeos</span></a></li>" +
				"<li><a href='#tab-4'><span>Arquivo</span></a></li>" +
				"</ul>" +

				"<div id='tab-1' class='balao'>" +



				"<table style='width: 360px;'>" +
				"<tr><td>Data e Hora da Colaboração: </td><td id=dataHoraDaColaboracao ></td></tr>" +
				"</table>" +
				"<table style='width: 360px;'>" +
				"<tr>" +
				"<td>Categoria <b style= 'color:red;'>*</b></td>" +
				"<td> " +
				"	<select name='categoria' id='codCategoriaEvento' onchange='loadXMLDoc(this.value)' class='form'> " +
				"		<option> " +
				"		</option> " +
				"			<?php  $consulta = $connection->query('SELECT * FROM categoriaevento'); ?> " +
				"			<?php  while($row = $consulta->fetch_assoc()) { ?> " +
				"			<option value=<?php echo $row['codCategoriaEvento']; ?> />" +
				"			<?php  echo $row['desCategoriaEvento']; ?></option>" +
				"			<?php  } ?> " +
				"	</select> " +
				"</tr>" +

				"<tr>" +
				"<td>Tipo <b style= 'color:red;'>*</b></td>" +
				"<td> " +
				"<select name='subcategoria' id = 'codTipoEvento'  class='form'> " +
				"</select> " +
				"</td> " +
				"<tr>" +
				"<tr><td>Título <b style= 'color:red;'>*</b></td> <td><input class='form' type='text' id='desTituloAssunto' name='desTituloAssunto'/> </td> </tr>" +
				"<tr>"+
					"<td nowrap>Data Ocorrência &nbsp;</td>" +
					"<td>";

					// This needs to be single quote because of the writeScript function
    /*
        html +=	"<?php
						$myCalendar = new tc_calendar('date1', true);
						$myCalendar->setIcon('calendar/images/iconCalendar.gif');
						$myCalendar->setDate(date('d'), date('m'), date('Y'));
						$myCalendar->setPath('calendar/');
						$myCalendar->setYearInterval(1995, 2035);
						$myCalendar->dateAllow('1960-03-01', '2050-03-01');
						$myCalendar->writeScript();
					?>";
*/

        html +=	"</td>" +
				"</tr>" +
				"<tr><td>Hora Ocorrência &nbsp;</td> " +
				"<td>H: &nbsp;" +
				"<select name='hour' id='hour' >" +
					"<option value=''>" +
					"<?php for($i = 0; $i <= 23; ++$i) { ?> " +
						"<option value='<?php echo $i;?>'> <?php echo $i; ?>" +
					"<?php } ?>" +
				"</select>" +
				"&nbsp; &nbsp;" +
				"M: &nbsp;" +
				"<select name='min' id='min'>" +
					"<option value=''>" +
					"<?php for($i = 0; $i <= 59; ++$i) { ?>" +

						"<option value='<?php echo $i; ?>'> <?php echo $i; ?>" +
					"<?php } ?>" +
				"</select>" +
				"&nbsp; &nbsp;"+
				"S: &nbsp;" +
				"<select name='sec' id='sec' >" +
					"<option value=''>" +
					"<?php for($i = 0; $i <= 59; ++$i) { ?>" +
					"	<option value='<?php echo $i;?>'> <?php echo $i; ?>" +
					"<?php } ?>" +
				"</select></td></tr>" +
				"</table>" +

				"Obs.: Data e Hora da Ocorrência podem não ter o mesmo valor da Data e Hora da Colaboração." +

				"<br />"+

				"<table>" +
				"<tr><td class='font1'>Descrição da colaboração <b style='color:red;'>*</b></td></tr>"+
				"<tr><td><textarea rows='4' cols='25' class='form2' id='desColaboracao' name='desColaboracao' /></textarea> </td> </tr>" +
				"</table>" +

				"<table>" +
				"<tr><td align='center'><input type='button' class='RemoveButton' value='Deletar Marcador' onclick='fecharMarker()'/></td>"+
				"<td align='center'><input type='submit' class='SaveButton' value='Enviar Colaboração'  /></td></tr>" +
				"</table>"+

				'</div>'+

				"<input type='hidden' name='usuario_id' id='usuario_id' name='usuario_id' value = '" + code_user + "'/>" +
				"<input type='hidden' name='latitudeAtual' id='latitudeAtual' />" +
				"<input type='hidden' name='longitudeAtual' id='longitudeAtual' />" +
				"<input type='hidden' name='zoom' id='zoom' />" +

				"<div id='tab-2' class='balao'>" +
					"<div align='center'>" +
						"<table>" +
							"<tr><td>Enviar Imagem <b style= 'color:red;'>*</b></td> <td><input type='file' name='Imagem' id='Imagem' /></td></tr>" +
							"<tr><td>Título da Imagem <b style= 'color:red;'>*</b></td> <td><input class='form' type='text' name='desTituloImagem' id='desTituloImagem'/> </td> </tr>" +
						"</table>" +
						"<br />" +
						"<table>" +
							"<tr><td align = 'center'>Comentário da Imagem </td></tr>"+
							"<tr><td><textarea rows='4' cols='25' class='form2' name='comentImagem' id='comentImagem'></textarea> </td> </tr>" +
						"</table>" +

						"<br />" +

						"<table><tr><td><input type='submit' class='SaveButton' value='Enviar Dados' name='Enviar'></td></tr></table>" +
					"</div>" +
				"</div>"+

				"<div id='tab-3' class='balao'>"+
					"<div align='center'>" +
					  "<label>OBS.: Apenas Urls de Video do YouTube</label>"+
					  "<table>" +
					  "<tr><td>Título do Video <b style= 'color:red;'>*</b></td> <td><input class='form' type='text' name='desTituloVideo' id='desTituloVideo'/> </td> </tr>" +
					  "<tr><td>URL do Video <b style= 'color:red;'>*</b></td> <td><input class='form' type='text' name='desUrlVideo' id='desUrlVideo'/> </td> </tr>" +
					  "</table>" +

					  "<br />"+

					  "<table>" +
					  "<tr><td align = 'center'>Comentário do Vídeo</td></tr>"+
					  "<tr><td><textarea rows='4' cols='25' class='form2' name='comentVideo' id='comentVideo'></textarea> </td> </tr>" +
					  "</table>" +

					  "<br />"+

					  "<table><tr><td><input type='submit' class='SaveButton' value = 'Enviar Dados' class='sbtn'  name='Enviar'></td></tr></table>" +
					"</div>" +
				'</div>'+

				'<div id="tab-4" class="balao">' +
					"<div align='center'>" +
						"<table>" +
						"<tr><td>Enviar Arquivo <b style= 'color:red;'>*</b></td> <td><input type='file' name='arquivo' id='arquivo' /> </td> </tr>" +
						"<tr><td>Título do Arquivo <b style= 'color:red;'>*</b></td> <td><input class='form' type='text' name='desArquivo' id='desArquivo'/> </td> </tr>" +
						"</table>" +

						"<br />"+
						"<table>" +
						"<tr><td align = 'center'>Comentário do Arquivo</td></tr>"+
						"<tr><td><textarea rows='4' cols='25' class='form2' name='comentArq' id='comentArq'/></textarea> </td> </tr>" +
						"</table>" +

						"<br />"+

						"<table><tr><td><input type='submit' class='SaveButton' value = 'Enviar Dados' class='sbtn'  name='Enviar'></td></tr></table>" +
					"</div>" +
				"</div>" +
				"</div>" +
				"</form>" +
				"</div></body></html>";

	infowindow = new google.maps.InfoWindow({content: html});

	google.maps.event.addListener(infowindow, 'domready', function() { $("#tabs").tabs(); });

	google.maps.event.addListener(infowindow, 'domready', function()
	{
		var options =
		{
			target:        '#output1',
			beforeSubmit:  showRequest,
			success:       showResponse
		};

		// Bind formulário usando 'ajaxForm'
		$('#frmArq').ajaxForm(options);

		DataHora();
	});

	google.maps.event.addListener(map, "click", function(event)
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

		if (infowindow)	infowindow.close();
		if (infowindowLoadMarker) infowindowLoadMarker.close();
		if (marcadorGlobal)	marcadorGlobal.setMap(null);

		marcadorGlobal = marker;
		infowindow.open(map, marker);
		latlngMarcadorAtual = marker.getPosition();
		zoom = map.getZoom();

		google.maps.event.addListener(marker, "click", function()
		{
			if (infowindowLoadMarker) infowindowLoadMarker.close();
			infowindow.open(map, marker);
			latlngMarcadorAtual = marker.getPosition();
		});
	});
}