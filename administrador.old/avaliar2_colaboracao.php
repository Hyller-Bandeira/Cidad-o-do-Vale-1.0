<?php  header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<?php 
	session_start();
	if(!isset($_SESSION['user']) && !isset($_SESSION['pass'])){
		header("location: naologado_admin.html");
	}
	else{
		
		?>
		<link href="table.css" rel="stylesheet" type="text/css">		
	
		<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
		<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false&libraries=places,visualization"></script>
		<script type="text/javascript" src="../src/jquery-ui-1.10.3.custom/js/jquery-1.9.1.js"></script>
			<script type="text/javascript" src="../src/jquery-ui-1.10.3.custom/js/jquery-ui-1.10.3.custom.min.js"></script>
					
			<script type="text/javascript" src="../jsor-jcarousel/lib/jquery.jcarousel.min.js"></script>
			<link rel="stylesheet" type="text/css" href="../jsor-jcarousel/skins/tango/skin.css" />
			
			<script type="text/javascript" src="../src/jquery.blockUI.js"></script>		
			<script type="text/javascript" src="../links.js"></script>
			<script SRC="../src/util.js"></script>
			<script SRC="../src/markerclusterer_packed.js"></script>

			<script type="text/javascript">
				//Variáveis Globais//
				var latlng;
				
				function mostrarColaboracao(id, latitude, longitude, codUsuario){
					//location.hash= "#map_canvas";
					//window.location=window.location;
					if (latitude && longitude){
						document.getElementById("latitude").value = latitude ;
						document.getElementById("longitude").value = longitude ;
						document.getElementById("codColaboracao").value = id ;
						document.form_avaliar.codUsuario.value = codUsuario ;						
					}
					enviar(id);
				}				
			</script>	
		<?php 
		require("../index.js.php");
		?>
		
		<div  align="center" style='width: 100%; overflow: auto; position:relative;'  >		
		<hr><h1>Avalição das Colaborações</h1><hr>
		<input type='button' value='V o l t a r' onclick='voltar()' style="width: 100px; height: 28px;  font-size: 12pt"/>
		<hr><br>
		<h3> Tabela de Colaborações dos Usuários </h3>
		<?php 		
		require 'class.eyedatagrid.inc.php';
		// Print the table
		EyeDataGrid::useAjaxTable('tabela.php');
		
		?>
		
		</div>
		
		<div align = 'center'>
			<HR>
			<body onload="initialize()" style="margin: 0;" class="corposite">   
				<div id="map_canvas" style="width: 80%; height: 500px"></div>	
			</body>
			<HR>
		</div>
		
		<div  align="center" >
			<form name="form1" >
				<p >
					<label>Latidude: </label>					
					&nbsp;					
					<input id = 'latitude' name="latitude"  type="text" size="20" value = '' />					
					&nbsp;					
					<label>Longitude: </label>					
					&nbsp;					
					<input id = 'longitude' name="longitude"  type="text" size="20" value = '' />					
					&nbsp;
					<input type="button"  value="VISUALIZAR" onClick="controle(form1)" style="width: 120px; height: 28px;  font-size: 12pt">
				</p>
			</form>
		</div>
	
			
				
				<div  align="center"  >
				
				
				<form name="form_avaliar" action="avaliar.php" method="post">
					<p>
						<input id = 'codUsuario' name='codUsuario'  type='hidden' size='10' value = '' />
						<label>Colaboracao*</label>
						<input name="codColaboracao" id = 'codColaboracao' value = ''  type="text" size="10" />
						&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
						<label>Status*</label>
						<select name="tipoStatus">
							<option value="A">Aprovado</option>
							<option value="R">Reprovado</option>
						</select>
						<br />
						<br />
						<br />
						<label>Justificativa*</label>
						<br />
						<textarea name="desJustificativa" id = 'desJustificativa' value = '' rows="10" cols="70"></textarea>	
						<br />
						(*)Campos obrigatórios
						<br /><br />	
						<input class="button" type="submit" value="A v a l i a r" style="width: 150px; height: 50px;  font-size: 16pt">
					</p>
				</form>

				<script type="text/javascript"> 
				/*				
					function enviar2(latitude, longitude,codigo,codUsuario){
							map.clearOverlays();	
							if (latitude && longitude){
								var latlng = new GLatLng(latitude, longitude);
								map.addOverlay(new GMarker(latlng));
							}														
							document.getElementById("latitude").value = latitude ;
							document.getElementById("longitude").value = longitude ;
							document.getElementById("codColaboracao").value = codigo ;
							document.form_avaliar.codUsuario.value = codUsuario ;

							if(window.XMLHttpRequest){	// codigo para IE7+, Firefox, Chrome, Opera, Safari
								xmlhttp=new XMLHttpRequest();
							}
							else{	// codigo para IE6, IE5
								xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
							}				
							xmlhttp.open("GET", "justificativa.php?codCategoriaEvento=" + codigo, true);				
							xmlhttp.onreadystatechange=function(){
								if(xmlhttp.readyState==4 && xmlhttp.status==200){									
									
									results = xmlhttp.responseText;
									//alert (results);
									document.getElementById("desJustificativa").value = results ;			
								}
							}
							xmlhttp.send(null);
					}
					
					function voltar(){		
						window.location.href="http://www.ide.ufv.br:8008/CidadaoVicosa/administrador/admin_tool.php";
					}
					*/								
				</script> 
			</div>		
		</html>
		<?php 
	};
?>