function initMap()
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
		scrollwheel: true,
        streetViewControlOptions: {
        	position: google.maps.ControlPosition.TOP_RIGHT
        },
		zoomControlOptions: {
            style: google.maps.ZoomControlStyle.SMALL,
            position: google.maps.ControlPosition.TOP_RIGHT
        }
	};
	if (tipoMapa_inicial == 'SATELLITE') myOptions['mapTypeId'] = google.maps.MapTypeId.SATELLITE;
	else if (tipoMapa_inicial == 'TERRAIN') myOptions['mapTypeId'] = google.maps.MapTypeId.TERRAIN;
	else if (tipoMapa_inicial == 'HYBRID') myOptions['mapTypeId'] = google.maps.MapTypeId.HYBRID;
	else myOptions['mapTypeId'] = google.maps.MapTypeId.ROADMAP;

	return new google.maps.Map(document.getElementById('map_canvas'), myOptions);
}