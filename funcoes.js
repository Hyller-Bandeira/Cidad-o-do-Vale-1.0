'use strict';

function incrementaVisualizacao(codColaboracao)
{
	var xmlhttp = new XMLHttpRequest();
	xmlhttp.open('GET', 'incrementaVisualizacao.php?codColaboracao=' + codColaboracao, true);
	xmlhttp.send();
}

function load_marker_filtro(ids_filtros)
{
	limpa_markers();
	downloadUrl('phpsqlajax_genxml.php', function(data)
	{
		var xml = parseXml(data);
		var colaboracao = xml.documentElement.getElementsByTagName('marker');
        var pos = 0;
		for (var i = 0; i < colaboracao.length; ++i)
		{
			var codColaboracao = colaboracao[i].getAttribute('codColaboracao');
            var titulo = colaboracao[i].getAttribute('titulo');
			var tipoStatus = colaboracao[i].getAttribute('tipoStatus');
			var codTipoEvento_ID = colaboracao[i].getAttribute('codTipoEvento_ID');
            if (codTipoEvento_ID == '') {
                codTipoEvento_ID = colaboracao[i].getAttribute('codCategoriaEvento_ID');
            }
			var point = new google.maps.LatLng(parseFloat(colaboracao[i].getAttribute('numLatitude')), parseFloat(colaboracao[i].getAttribute('numLongitude')));

			//-------Código Para Filtrar--------//
			var string = ids_filtros.split(',');
			var IdsCategoria = '';
			var IdsTipo = '';
			for (var j = 0; j < string.length; ++j)
			{
				if (!isNaN(string[j]))
					IdsCategoria += string[j] + ',';
				else
				{
					var valorTipo = string[j].split('-');
					IdsTipo += valorTipo[1] + ',';
				}
			}
			IdsCategoria = IdsCategoria.slice(0,IdsCategoria.length - 1);
			IdsTipo = IdsTipo.slice(0,IdsTipo.length - 1);
			var IdsCategoria_array = IdsCategoria.split(',');
			var IdsTipo_array = IdsTipo.split(',');
			var a = IdsTipo_array.indexOf(codTipoEvento_ID);
            if (a == -1){
                a = IdsCategoria_array.indexOf(codTipoEvento_ID);
            }
            VGI_Data[pos] = point;
			if (a != -1)
			{
				var marker = createMarker(point, tipoStatus, codColaboracao, titulo);
				listaMarcadores[codColaboracao] = marker;
				listaCluster[pos] = marker;
				VGI_Data[pos] = point;
				pos++;
			}
		}
	});

    exibeMapCluster(map, listaCluster)
}

function exibeMapCluster(map, listaCluster){
//    return;
    var local_path = "imagens/"
    var mcOptions = {styles: [{
        height: 53,
        url: local_path+"m1.png",
        width: 53
    },
        {
            height: 56,
            url: local_path+"m2.png",
            width: 56
        },
        {
            height: 66,
            url: local_path+"m3.png",
            width: 66
        },
        {
            height: 78,
            url: local_path+"m4.png",
            width: 78
        },
        {
            height: 90,
            url:  local_path+"m5.png",
            width: 90
        }], maxZoom: 15
    }

    if (markerCluster) markerCluster.clearMarkers();
    markerCluster = new MarkerClusterer(map, listaCluster, mcOptions);
}

function load_marker()
{
	limpa_markers();
	downloadUrl('phpsqlajax_genxml.php', function(data)
	{
		var xml = parseXml(data);
		var colaboracao = xml.documentElement.getElementsByTagName('marker');
		for (var i = 0; i < colaboracao.length; ++i)
		{
			var codColaboracao = colaboracao[i].getAttribute('codColaboracao');
			var tipoStatus = colaboracao[i].getAttribute('tipoStatus');
            var titulo = colaboracao[i].getAttribute('titulo');
			var point = new google.maps.LatLng(parseFloat(colaboracao[i].getAttribute('numLatitude')), parseFloat(colaboracao[i].getAttribute('numLongitude')));
			VGI_Data[pos] = point;
			if (tipoStatus != 'R')
				var marker = createMarker(point, tipoStatus, codColaboracao, titulo);
			listaMarcadores[codColaboracao] = marker;
			listaCluster[pos] = marker;
			pos++;
		}
	});

    exibeMapCluster(map, listaCluster)
}

function createMarker(point, tipoStatus, codColaboracao, titulo)
{
	var marker ;
	if (tipoStatus == 'A')
		marker = new google.maps.Marker
		({
			position: point,
			map: map,
			shadow: shadow,
			icon: imageBlue,
			title: titulo
		});
	else
		marker = new google.maps.Marker
		({
			position: point,
			map: map,
			shadow: shadow,
			icon: imageRed,
			title: titulo
		});

	google.maps.event.addListener(marker, 'click', function()
	{
		if (infowindow) infowindow.close();
		if (infowindowLoadMarker) infowindowLoadMarker.close();

		incrementaVisualizacao(codColaboracao);
		id_marcador_atual = marker.getTitle();

		open_infowindows_especifico(codColaboracao, marker);
	});

	return marker;
}

function open_infowindows_especifico(k, marker)
{
	downloadUrl_a('phpsqlajax_genxml_especifico.php?idColaboracao=' + k, function(data)
	{
		var xml = parseXml(data);
		var i = 0;
		var colaboracao = xml.documentElement.getElementsByTagName('marker');
        var point = new google.maps.LatLng(parseFloat(colaboracao[i].getAttribute('numLatitude')), parseFloat(colaboracao[i].getAttribute('numLongitude')));

        var dados_colaboracao = {
            codColaboracao: colaboracao[i].getAttribute('codColaboracao'),
            codCategoriaEvento: colaboracao[i].getAttribute('codCategoriaEvento'),
            desTituloAssunto: colaboracao[i].getAttribute('desTituloAssunto'),
            dataHoraOcorrencia: colaboracao[i].getAttribute('dataHoraOcorrencia'),
            desColaboracao: colaboracao[i].getAttribute('desColaboracao'),
            tipoStatus: colaboracao[i].getAttribute('tipoStatus'),
            codUsuario: colaboracao[i].getAttribute('codUsuario'),
            codTipoEvento: colaboracao[i].getAttribute('codTipoEvento'),
            desTituloImagem: colaboracao[i].getAttribute('desTituloImagem'),
            comentarioImagem: colaboracao[i].getAttribute('comentarioImagem'),
            endImagem: colaboracao[i].getAttribute('endImagem'),
            apelidoImagem: colaboracao[i].getAttribute('apelidoImagem'),
            dataEnvioImagem: colaboracao[i].getAttribute('dataEnvioImagem'),
            desTituloVideo: colaboracao[i].getAttribute('desTituloVideo'),
            desUrlVideo: colaboracao[i].getAttribute('desUrlVideo'),
            comentarioVideo: colaboracao[i].getAttribute('comentarioVideo'),
            apelidoVideo: colaboracao[i].getAttribute('apelidoVideo'),
            dataEnvioVideo: colaboracao[i].getAttribute('dataEnvioVideo'),
            forum: colaboracao[i].getAttribute('forum'),
            notaMedia: colaboracao[i].getAttribute('notaMedia'),
            qtdVisualizacao: colaboracao[i].getAttribute('qtdVisualizacao'),
            qtdAvaliacao: colaboracao[i].getAttribute('qtdAvaliacao'),
            endArquivo: colaboracao[i].getAttribute('endArquivo'),
            tituloArquivo: colaboracao[i].getAttribute('tituloArquivo'),
            comentarioArquivo: colaboracao[i].getAttribute('comentarioArquivo'),
            apelidoArquivo: colaboracao[i].getAttribute('apelidoArquivo'),
            dataEnvioArquivo: colaboracao[i].getAttribute('dataEnvioArquivo'),
            datahoraCriacao: colaboracao[i].getAttribute('datahoraCriacao'),
            keywords: colaboracao[i].getAttribute('keywords'),
            desTituloHistorico: colaboracao[i].getAttribute('desTituloHistorico'),
            datahoraModificacaoHistorico: colaboracao[i].getAttribute('datahoraModificacaoHistorico'),
            apelidoUsuarioHistorico: colaboracao[i].getAttribute('apelidoUsuarioHistorico')
        };

		createInfoWindows(point, marker, dados_colaboracao);
		return;
	});
}

function limpa_markers()
{
	if (listaMarcadores !== null)
		for (var i = 0; i < listaMarcadores.length; ++i)
			if (listaMarcadores[i])
				listaMarcadores[i].setMap(null);
	listaMarcadores = [];
	listaCluster = [];
	pos = 0;
}

function showAddress(address)
{
	geocoder.geocode({ 'address': address}, function(results, status)
	{
		if (status == google.maps.GeocoderStatus.OK)
		{
			map.setCenter(results[0].geometry.location);
			map.setZoom(17);
		}
		else bootbox.alert('Endereço não encontrado!');
	});
}

function enviar(idColaboracao)
{
	if (infowindowLoadMarker) infowindowLoadMarker.close();

	incrementaVisualizacao(idColaboracao);
	id_marcador_atual = idColaboracao;

	open_infowindows_especifico(idColaboracao, listaMarcadores[idColaboracao]);
	window.location.hash = '';
	window.location.hash = 'map_canvas';
	return true;
}

function toggleHeatmap()
{
    heatmap.setMap(heatmap.getMap() ? null : map);

    if (heatmap.getMap()){
        $('#heatmap-on-off').html(' Ocultar Mapa de Calor');
        $('#liga-heatmap').removeClass('active');
        $('#opcoes-heatmap').show();
        $()
    } else {
        $('#heatmap-on-off').html(' Exibir Mapa de Calor');
        $('#liga-heatmap').addClass('active');
        $('#opcoes-heatmap').hide();
    }

}

function changeGradient()
{
  var gradient = [
	'rgba(0, 255, 255, 0)',
	'rgba(0, 255, 255, 1)',
	'rgba(0, 191, 255, 1)',
	'rgba(0, 127, 255, 1)',
	'rgba(0, 63, 255, 1)',
	'rgba(0, 0, 255, 1)',
	'rgba(0, 0, 223, 1)',
	'rgba(0, 0, 191, 1)',
	'rgba(0, 0, 159, 1)',
	'rgba(0, 0, 127, 1)',
	'rgba(63, 0, 91, 1)',
	'rgba(127, 0, 63, 1)',
	'rgba(191, 0, 31, 1)',
	'rgba(255, 0, 0, 1)'
  ];
  heatmap.setOptions({ gradient: heatmap.get('gradient') ? null : gradient });
}
// Bloco para conversão do raio de metros para pixels --BEGIN--
//Mercator --BEGIN--
function bound(value, opt_min, opt_max) {
    if (opt_min !== null) value = Math.max(value, opt_min);
    if (opt_max !== null) value = Math.min(value, opt_max);
    return value;
}

function degreesToRadians(deg) {
    return deg * (Math.PI / 180);
}

function radiansToDegrees(rad) {
    return rad / (Math.PI / 180);
}

function MercatorProjection() {
    this.pixelOrigin_ = new google.maps.Point(256 / 2,
    256 / 2);
    this.pixelsPerLonDegree_ = 256 / 360;
    this.pixelsPerLonRadian_ = 256 / (2 * Math.PI);
}

MercatorProjection.prototype.fromLatLngToPoint = function (latLng, opt_point) {
    var me = this;
    var point = opt_point || new google.maps.Point(0, 0);
    var origin = me.pixelOrigin_;

    point.x = origin.x + latLng.lng() * me.pixelsPerLonDegree_;

    // NOTE(appleton): Truncating to 0.9999 effectively limits latitude to
    // 89.189.  This is about a third of a tile past the edge of the world
    // tile.
    var siny = bound(Math.sin(degreesToRadians(latLng.lat())), - 0.9999, 0.9999);
    point.y = origin.y + 0.5 * Math.log((1 + siny) / (1 - siny)) * -me.pixelsPerLonRadian_;
    return point;
};

MercatorProjection.prototype.fromPointToLatLng = function (point) {
    var me = this;
    var origin = me.pixelOrigin_;
    var lng = (point.x - origin.x) / me.pixelsPerLonDegree_;
    var latRadians = (point.y - origin.y) / -me.pixelsPerLonRadian_;
    var lat = radiansToDegrees(2 * Math.atan(Math.exp(latRadians)) - Math.PI / 2);
    return new google.maps.LatLng(lat, lng);
};
//Mercator --END--

function getNewRadius() {
    var numTiles = 1 << map.getZoom();
    var center = map.getCenter();
    var moved = google.maps.geometry.spherical.computeOffset(center, 10000, 90); /*1000 meters to the right*/
    var projection = new MercatorProjection();
    var initCoord = projection.fromLatLngToPoint(center);
    var endCoord = projection.fromLatLngToPoint(moved);
    var initPoint = new google.maps.Point(
        initCoord.x * numTiles,
        initCoord.y * numTiles);
    var endPoint = new google.maps.Point(
        endCoord.x * numTiles,
        endCoord.y * numTiles);
    var pixelsPerMeter = (Math.abs(initPoint.x-endPoint.x))/10000.0;
    var totalPixelSize = Math.floor(RaioEmMetros*pixelsPerMeter);
    console.log(totalPixelSize);
    return totalPixelSize;
}
// Bloco para conversão do raio de metros para pixels --END--

var RaioEmMetros = 150; // Raio inicial em metrosd

function changeRadiusAdd() { RaioEmMetros+=10; heatmap.setOptions({ radius: getNewRadius()}); }

function changeRadiusSub() { RaioEmMetros-=10; heatmap.setOptions({ radius: getNewRadius() }); }

function changeOpacity() { heatmap.setOptions({opacity: heatmap.get('opacity') ? null : 0.2}); }

function geraMetadados(id)
{
	var xmlhttp = new XMLHttpRequest();

	xmlhttp.open('GET', 'gera_metadados.php?id=' + id, true);
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200)
		{
			$('#metadados').html(xmlhttp.responseText);
		}
	};

	xmlhttp.send(null);
}

function setDescricaoModal(descricao)
{
    $('#descricao-completa').html(descricao);
    $('#modal-descricao-completa').modal();
}

function abreTutorial()
{
    $('#tutorial-usuario').load('tutorial.php', {pagina:0}, function(){});
    $('#tutorial-usuario').modal('show');
    $('.popover').zIndex(1040);
}

function tutorialPagina(pagina)
{
    $('#tutorial-usuario').load('tutorial.php', {pagina: pagina}, function(){});
}