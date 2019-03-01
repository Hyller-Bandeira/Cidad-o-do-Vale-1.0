<?php require 'phpsqlinfo_dbinfo.php'; ?>
	<input type="hidden" name="longitude_inicial" id="longitude_inicial" value="<?php echo $longitude_inicial; ?>">
	<input type="hidden" name="latitude_inicial" id="latitude_inicial" value="<?php echo $latitude_inicial; ?>">
	<input type="hidden" name="zoom_inicial" id="zoom_inicial" value="<?php echo $zoom_inicial; ?>">
	<input type="hidden" name="tipoMapa_inicial" id="tipoMapa_inicial" value="<?php echo $tipoMapa_inicial; ?>">

<script type="text/javascript" src="funcoes.js"></script>
<script type="text/javascript">
//    var imageRed = new google.maps.MarkerImage('',
    var imageRed = new google.maps.MarkerImage('http://labs.google.com/ridefinder/images/mm_20_red.png',
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

	var map;
	var geocoder = null;
	var listaMarcadores = [];
	var listaCluster = [];
	var pos = 0;
	var infowindowLoadMarker;
	var pointarray, heatmap;
	var VGI_Data = [];
	var id_marcador_atual;
	var markerCluster;
	var infowindow;


	function initialize()
	{
		map = initMap();

		<?php
		$ids_filtros = '';
		if (isset($_POST["ids_filtros"])) $ids_filtros = $_POST["ids_filtros"];

		if($ids_filtros)
		{?>
			var ids_filtros = "<?php echo $ids_filtros;?>";
			load_marker_filtro(ids_filtros);

		<?php
		}
		else {?> load_marker(); <?php }?>

		geocoder = new google.maps.Geocoder();

        if ($('#geocode').length > 0) {
            var input = document.getElementById('geocode');
            var options =
            {
                types: ['geocode'],
                componentRestrictions: { country: 'br' }
            };

            autocomplete = new google.maps.places.Autocomplete(input, options);

            autocomplete.bindTo('bounds', map);
        }

		pointArray = new google.maps.MVCArray(VGI_Data);

		heatmap = new google.maps.visualization.HeatmapLayer({ data: pointArray, radius: getNewRadius() });

        google.maps.event.addListener(map, 'zoom_changed', function () {
            exibeMapCluster(map, listaCluster);
            heatmap.setOptions({radius: getNewRadius()});
        });

	} // final do inicializar

	function initialize2(id, lat, log, zoom)
	{
		var latlng = new google.maps.LatLng(lat, log);
		var myOptions =
		{
			zoom: zoom,
			center: latlng,
			mapTypeId: google.maps.MapTypeId.SATELLITE,
			scrollwheel: false
		};
		map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);

		var point = new google.maps.LatLng(parseFloat(lat), parseFloat(log));

		createMarker(point, 'E', id, id)

		geocoder = new google.maps.Geocoder();

		var input = document.getElementById('geocode');
		var options =
		{
			types: ['geocode'],
			componentRestrictions: { country: 'br' }
		};

		autocomplete = new google.maps.places.Autocomplete(input, options);

		autocomplete.bindTo('bounds', map);

		pointArray = new google.maps.MVCArray(VGI_Data);

		heatmap = new google.maps.visualization.HeatmapLayer(
		{
			data: pointArray,
			radius: getNewRadius()
		});


	} // final do inicializar

    function createInfoWindows(point, marker, dados_colaboracao)
    {
        dados_colaboracao.pode_editar = false;
        $.post('partials/colaboracao_view.php', dados_colaboracao, function(resposta){
            infowindowLoadMarker = new google.maps.InfoWindow({content: resposta, maxWidth: 1500});

            google.maps.event.addListener(infowindowLoadMarker, 'domready', function()
            {
                $("#tabs").tabs();

                geraMetadados($('#codColaboracao').val());

                $('#infowindowview').parent().css('overflow', 'hidden');
                $('div.gm-style-iw').children().css('overflow', 'hidden');
            });

            map.panTo(marker.getPosition());
            map.setZoom(14);
            infowindowLoadMarker.open(map, marker);
        });
    }

</script>