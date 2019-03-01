<?php require 'phpsqlinfo_dbinfo.php'; ?>
	<input type="hidden" name="longitude_inicial" id="longitude_inicial" value="<?php  echo $longitude_inicial; ?>">
	<input type="hidden" name="latitude_inicial" id="latitude_inicial" value="<?php  echo $latitude_inicial; ?>">
	<input type="hidden" name="zoom_inicial" id="zoom_inicial" value="<?php  echo $zoom_inicial; ?>">
	<input type="hidden" name="tipoMapa_inicial" id="tipoMapa_inicial" value="<?php  echo $tipoMapa_inicial; ?>">

<script type="text/javascript" src="funcoes.js"></script>
<script type="text/javascript">
	google.load('visualization', '1', {'packages':['corechart']});

	var NorthEast_lng ;
	var NorthEast_lat ;
	var SouthWest_lng ;
	var SouthWest_lat ;

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
	var listaMarcadores=[];
	var listaCluster=[];
	var pos = 0;
	var infowindowLoadMarker;
	var pointarray, heatmap;
	var VGI_Data = [];
	var id_marcador_atual;
	var markerCluster;
	var infowindow;

	function geraGrafico(tipo, grafico, doisGraficos, primeiraVez, tipo2)
	{
		if(tipo)
		{
			$.get("gera_grafico.php", { NorthEast_lng: NorthEast_lng, NorthEast_lat: NorthEast_lat, SouthWest_lng: SouthWest_lng, SouthWest_lat: SouthWest_lat, tipo: tipo },
				function(data)
				{
					if (grafico == 1) $('#texto1').html('Tipos de Colaborações de ' + $('#escolha' + tipo).html());
					else $('#texto2').html('Tipos de Colaborações de ' + $('#escolha' + tipo).html());
					geraMatrizDados(data, grafico, doisGraficos, primeiraVez, tipo2);
				});
		}
		else bootbox.alert("Escolha um tipo.");
	}

	function geraMatrizDados (results, grafico, doisGraficos, primeiraVez, tipo2)
	{
		var temp_array_1 = new Array ();
		var temp_array_2 = new Array ();
		var matriz = new Array ();

		temp_array_1 = results.split(",-,");

		var temp_element = temp_array_1.pop();

		for (var i = 0; i < temp_array_1.length; i++)
		{
			temp_array_2 = temp_array_1[i].split(",*,");
			matriz[i] = new Array(2);
			matriz[i][0] = temp_array_2[0];
			matriz[i][1] = Number(temp_array_2[1]);
		}

		drawChart(matriz, grafico, doisGraficos, primeiraVez, tipo2);
	}

	function drawChart (matriz, grafico, doisGraficos, primeiraVez, tipo2)
	{
		var data = new google.visualization.DataTable();
		data.addColumn('string', 'Nome');
		data.addColumn('number', 'Quantidade');
		data.addRows(matriz);

		var chart = new google.visualization.PieChart(document.getElementById('chart_div'+grafico));
		chart.draw(data, {width: 495, height: 150});

		if (doisGraficos)
		{
			if (primeiraVez) geraGrafico(5,2);
			else geraGrafico (tipo2, 2);
		}
	}

	function criarGrafico(tipo1, tipo2, grafico)
	{
		if (tipo1 || tipo2)
		{
			if (grafico == 1) geraGrafico (tipo1, 1);
			else if (grafico == 2) geraGrafico (tipo2, 2);
			else geraGrafico (tipo1, 1, 1, 0, tipo2);
		}
		else geraGrafico(4,1,1,1);
	}

	function initialize()
	{
        map = initMap();

		google.maps.event.addListener(map,'idle',function()
		{
			bounds = map.getBounds();

			NorthEast_lng = bounds.getNorthEast().lng();
			NorthEast_lat = bounds.getNorthEast().lat();
			SouthWest_lng = bounds.getSouthWest().lng();
			SouthWest_lat = bounds.getSouthWest().lat();

			criarGrafico(document.getElementById('categoria_atual').value, document.getElementById('categoria_atual_2').value, 0);
		});

		load_marker();

		geocoder = new google.maps.Geocoder();

		var input = document.getElementById('geocode');
		var options = {
		types: ['geocode'],
		componentRestrictions: {country: 'br'}
		};

		autocomplete = new google.maps.places.Autocomplete(input, options);

		autocomplete.bindTo('bounds', map);
		pointArray = new google.maps.MVCArray(VGI_Data);

		heatmap = new google.maps.visualization.HeatmapLayer({
			data: pointArray,
			radius: 20
		});
		
		google.maps.event.addListener(map, 'zoom_changed', function () {
			exibeMapCluster(map, listaCluster)
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
    }
</script>