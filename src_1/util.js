    function bindInfoWindow(marker, map, infoWindow, html) {
      google.maps.event.addListener(marker, 'click', function() {
        infoWindow.setContent(html);
        infoWindow.open(map, marker);
      });
    }

    function downloadUrl(url, callback) {
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
	
      request.onreadystatechange = function() {
	          if (request.readyState == 4) {
          request.onreadystatechange = doNothing;
          callback(request.responseText, request.status);
		  $.unblockUI();
        }
      };

      request.open('GET', url, false);
      request.send(null);
    }
	
	 function downloadUrl_a(url, callback) {
	  
	  $(document).ready(function(){
		$.blockUI({ message: 'Carregando Colaboração' });
		// $(document).ajaxStop($.unblockUI);
	  });
	 
      var request = window.ActiveXObject ?
          new ActiveXObject('Microsoft.XMLHTTP') :
          new XMLHttpRequest;
	
      request.onreadystatechange = function() { 
	        if (request.readyState == 4) {
				request.onreadystatechange = doNothing;
				$.unblockUI();
				callback(request.responseText, request.status);
			}
      };

      request.open('GET', url, true);
      request.send(null);
    }

    function parseXml(str) {
      if (window.ActiveXObject) {
        var doc = new ActiveXObject('Microsoft.XMLDOM');
        doc.loadXML(str);
        return doc;
      } else if (window.DOMParser) {
        return (new DOMParser).parseFromString(str, 'text/xml');
      }
    }

    function doNothing() {}