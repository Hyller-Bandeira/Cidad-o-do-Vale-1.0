function bindInfoWindow(marker, map, infoWindow, html)
{
	google.maps.event.addListener(marker, 'click', function()
	{
		infoWindow.setContent(html);
		infoWindow.open(map, marker);
	});
}

function downloadUrl(url, callback)
{
	var request = new XMLHttpRequest();

	request.onreadystatechange = function()
	{
		if (request.readyState == 4)
		{
			request.onreadystatechange = function() {};
			callback(request.responseText, request.status);
			$.unblockUI();
		}
	};

	request.open('GET', url, false); // Using the last argument as 'false' shows a warning, it's deprecated
	request.send(null);
}

function downloadUrl_a(url, callback)
{
	$(document).ready(function()
	{
		$.blockUI({ message: 'Carregando colaboração...' });
	});

	var request = new XMLHttpRequest();

	request.onreadystatechange = function()
	{
		if (request.readyState == 4)
		{
			request.onreadystatechange = function() {};
			$.unblockUI();
			callback(request.responseText, request.status);
		}
	};

	request.open('GET', url);
	request.send(null);
}

function parseXml(str)
{
	return (new DOMParser).parseFromString(str, 'text/xml');
}