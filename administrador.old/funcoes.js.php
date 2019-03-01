<script type="text/javascript">
	function incrementaVisualizacao(codColaboracao){
		if(window.XMLHttpRequest){	// Código para IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// Código para IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}				
		xmlhttp.open("GET", "incrementaVisualizacao.php?codColaboracao=" + codColaboracao, true);				
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){
				results = xmlhttp.responseText;				
			}
		}
		xmlhttp.send(null);
	}
	
	function load_marker_filtro(ids_filtros){
		limpa_markers();	
		downloadUrl(base + "phpsqlajax_genxml.php", function(data){
			var xml = parseXml(data);
			var colaboracao = xml.documentElement.getElementsByTagName("marker");
			for (var i = 0; i < colaboracao.length; i++) {
				var codColaboracao = colaboracao[i].getAttribute("codColaboracao");			
				var tipoStatus = colaboracao[i].getAttribute("tipoStatus");
				var codTipoEvento_ID = colaboracao[i].getAttribute("codTipoEvento_ID");										
				var point = new google.maps.LatLng(parseFloat(colaboracao[i].getAttribute("numLatitude")), parseFloat(colaboracao[i].getAttribute("numLongitude")));			
						
				//-------Código Para Filtrar--------//
				var string = ids_filtros.split(",");					
				var IdsCategoria = "";
				var IdsTipo = "";
				
				for (var j = 0; j< string.length; j++){
					if (!isNaN(string[j]))
						IdsCategoria += string[j] + ",";
					else{
						var valorTipo = string[j].split("-");
						IdsTipo += valorTipo[1] + ",";
					}
				}			
				IdsCategoria = IdsCategoria.slice(0,IdsCategoria.length-1);
				IdsTipo = IdsTipo.slice(0,IdsTipo.length-1);			
				var IdsCategoria_array = IdsCategoria.split(",");
				var IdsTipo_array = IdsTipo.split(",");
				var a = IdsTipo_array.indexOf(codTipoEvento_ID);
				if (a!=-1){
					var marker = createMarker(point, tipoStatus, codColaboracao);
					listaMarcadores[codColaboracao] = marker;
					listaCluster[pos] = marker;
					VGI_Data[pos] = point;
					pos++;
				}			
			} 
		});
		if (markerCluster)
			markerCluster.clearMarkers();
		markerCluster = new MarkerClusterer(map, listaCluster, {
          maxZoom: 15});
	}
	
	function load_marker(){
		limpa_markers();
		downloadUrl(base + "phpsqlajax_genxml.php", function(data){		
		var xml = parseXml(data);
		var colaboracao = xml.documentElement.getElementsByTagName("marker"); 
		for (var i = 0; i < colaboracao.length; i++) {			
			var codColaboracao = colaboracao[i].getAttribute("codColaboracao");
			var tipoStatus = colaboracao[i].getAttribute("tipoStatus");										
			var point = new google.maps.LatLng(parseFloat(colaboracao[i].getAttribute("numLatitude")), parseFloat(colaboracao[i].getAttribute("numLongitude"))); 
			VGI_Data[pos] = point;			
			var marker = createMarker(point, tipoStatus, codColaboracao);
			listaMarcadores[codColaboracao] = marker;
			listaCluster[pos] = marker;
			pos++;
		} 
		});
		if (markerCluster)
			markerCluster.clearMarkers();
		markerCluster = new MarkerClusterer(map, listaCluster, {
          maxZoom: 15});
		
	}
	
	function createMarker(point, tipoStatus, codColaboracao) { 
		var marker ;		
		if (tipoStatus == 'A')
			marker = new google.maps.Marker({
				position: point,
				map: map,
				shadow: shadow,
				icon: imageBlue,
				title: codColaboracao
			}); 
		else
			marker = new google.maps.Marker({
				position: point,
				map: map,
				shadow: shadow,
				icon: imageRed,
				title: codColaboracao
			});
		
		google.maps.event.addListener(marker, 'click', function() {
			if (infowindow){
				infowindow.close();
			}
			if (infowindowLoadMarker){
				infowindowLoadMarker.close();
			}
			
			incrementaVisualizacao(codColaboracao);			
			id_marcador_atual = marker.getTitle();
			
			open_infowindows_especifico(codColaboracao, marker);
			
		});
				
		return marker;
	}

	function open_infowindows_especifico(k, marker){
	
		downloadUrl_a(base + "phpsqlajax_genxml_especifico.php?idColaboracao=" + k, function(data){
		var xml = parseXml(data);
		var i =0;
		var colaboracao = xml.documentElement.getElementsByTagName("marker"); 
		var codColaboracao = colaboracao[i].getAttribute("codColaboracao");	
		var codCategoriaEvento = colaboracao[i].getAttribute("codCategoriaEvento");
		var desTituloAssunto = colaboracao[i].getAttribute("desTituloAssunto");
		var dataOcorrencia = colaboracao[i].getAttribute("dataOcorrencia");
		var horaOcorrencia = colaboracao[i].getAttribute("horaOcorrencia");
		var desColaboracao = colaboracao[i].getAttribute("desColaboracao");
		var tipoStatus = colaboracao[i].getAttribute("tipoStatus");
		var codUsuario = colaboracao[i].getAttribute("codUsuario"); 
		var codTipoEvento = colaboracao[i].getAttribute("codTipoEvento");								
		var point = new google.maps.LatLng(parseFloat(colaboracao[i].getAttribute("numLatitude")), parseFloat(colaboracao[i].getAttribute("numLongitude")));
		var desTituloImagem = colaboracao[i].getAttribute("desTituloImagem");
		var comentarioImagem = colaboracao[i].getAttribute("comentarioImagem");	
		var endImagem = colaboracao[i].getAttribute("endImagem");
		var desTituloVideo = colaboracao[i].getAttribute("desTituloVideo");
		var desUrlVideo = colaboracao[i].getAttribute("desUrlVideo");
		var comentarioVideo = colaboracao[i].getAttribute("comentarioVideo");	
		var forum = colaboracao[i].getAttribute("forum");
		var notaMedia = colaboracao[i].getAttribute("notaMedia");
		var qtdVisualizacao = colaboracao[i].getAttribute("qtdVisualizacao");
		var qtdAvaliacao = colaboracao[i].getAttribute("qtdAvaliacao");	
		var endArquivo = colaboracao[i].getAttribute("endArquivo");
		var tituloArquivo = colaboracao[i].getAttribute("tituloArquivo");
		var comentarioArquivo = colaboracao[i].getAttribute("comentarioArquivo");
		var datahoraCriacao = colaboracao[i].getAttribute("datahoraCriacao");
		createInfoWindows( point, codCategoriaEvento, codTipoEvento, desTituloAssunto, dataOcorrencia, horaOcorrencia, desColaboracao, tipoStatus, codUsuario, codColaboracao, desTituloImagem, desTituloVideo, desUrlVideo, forum, notaMedia, qtdVisualizacao, qtdAvaliacao ,endArquivo, endImagem, comentarioImagem, comentarioArquivo, tituloArquivo, comentarioVideo, marker, datahoraCriacao);
		return;	
		});
	}
	
	function limpa_markers(){
		for( i = 0; i < listaMarcadores.length; i++ ){
			if (listaMarcadores[i])
				listaMarcadores[i].setMap(null);
		}		
		listaMarcadores = [];
		listaCluster = [];
		pos = 0;
	}
								
	function showAddress(address) {
		geocoder.geocode( { 'address': address}, function(results, status) {
			if (status == google.maps.GeocoderStatus.OK) {
				map.setCenter(results[0].geometry.location);
				map.setZoom(18);
			}else{
				alert("Geocodificação não foi bem sucedida pelo seguinte motivo: " + status);
			}
		});
	}
	
	function enviar(idColaboracao){
		if (infowindowLoadMarker)
			infowindowLoadMarker.close();
			
		incrementaVisualizacao(idColaboracao);
		id_marcador_atual = idColaboracao;
		open_infowindows_especifico(idColaboracao, listaMarcadores[idColaboracao]);
		window.location.hash="";
		window.location.hash="map_canvas";
		return true;
	}
	
	function toggleHeatmap() {
	  heatmap.setMap(heatmap.getMap() ? null : map);
	}

	function changeGradient() {
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
	  ]
	  heatmap.setOptions({
		gradient: heatmap.get('gradient') ? null : gradient
	  });
	}

	function changeRadius() {
	  heatmap.setOptions({radius: heatmap.get('radius') + 5});
	}
	
	function changeRadius2() {
	  heatmap.setOptions({radius: heatmap.get('radius') - 5});
	}

	function changeOpacity() {
	  heatmap.setOptions({opacity: heatmap.get('opacity') ? null : 0.2});
	}
	
	function geraMetadados(id){
		if(window.XMLHttpRequest){	// Código para IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else{	// Código para IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}				
		xmlhttp.open("GET", "gera_metadados.php?id=" + id, true);				
		xmlhttp.onreadystatechange=function(){
			if(xmlhttp.readyState==4 && xmlhttp.status==200){									
				results = xmlhttp.responseText;
				var metadados = document.getElementById("metadados");
				metadados.innerHTML = results;
			}
		}
		xmlhttp.send(null);
	}
	
</script>