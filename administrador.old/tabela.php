<?php  header("Content-Type: text/html; charset=ISO-8859-1",true) ?>
<link href="table.css" rel="stylesheet" type="text/css">
<?php 						
		require 'class.eyemysqladap.inc.php';
		require 'class.eyedatagrid.inc.php';
		require("../phpsqlinfo_dbinfo.php");
		
		// Load the database adapter
		$db = new EyeMySQLAdap('localhost', $username, $password, $database);

		// Load the datagrid class
		$x = new EyeDataGrid($db);

		//if ($Estado_post)
		// Set the query
		$x->setQuery("*", "colaboracao", 'codColaboracao');
		//else
		//$x->setQuery("*", "colaboracao", 'codColaboracao');

		// Allows filters
		$x->allowFilters();

		// Change headers text
		$x->setColumnHeader('desTituloAssunto', 'T�tulo');
		$x->setColumnHeader('desColaboracao', 'Descri��o');
		$x->setColumnHeader('datahoraCriacao', 'Data e Hora da Criacao');
		$x->setColumnHeader('codCategoriaEvento', 'Categoria');
		$x->setColumnHeader('codTipoEvento', 'Tipo');
		$x->setColumnHeader('codUsuario', 'Email do Usu�rio');
		$x->setColumnHeader('dataOcorrencia', 'Data');
		$x->setColumnHeader('horaOcorrencia', 'Hora');
		$x->setColumnHeader('numLatitude', 'Latitude');
		$x->setColumnHeader('numLongitude', 'Longitude');
		$x->setColumnHeader('tipoStatus', 'Status');
		$x->setColumnHeader('desJustificativa', 'Justificativa');

		// Hide codColaboracao Column
		$x->hideColumn('codColaboracao');
		$x->hideColumn('desJustificativa');
		$x->hideColumn('numLatitude');
		$x->hideColumn('numLongitude');

		// Change column type
		//$x->setColumnType('FirstName', EyeDataGrid::TYPE_HREF, 'http://google.com/search?q=%FirstName%'); // Google Me!
		$x->setColumnType('dataOcorrencia', EyeDataGrid::TYPE_DATE, 'd / m / Y', true); // Change the date format
		$x->setColumnType('datahoraCriacao', EyeDataGrid::TYPE_DATE, 'd / m / Y - H:i:s', true); // Change the date format
		$x->setColumnType('tipoStatus', EyeDataGrid::TYPE_ARRAY, array('a' => 'Aprovado', 'A' => 'Aprovado', 'r' => 'Reprovado', 'R' => 'Reprovado', 'e' => 'Em Avalia��o', 'E' => 'Em Avalia��o')); // Convert db values to something better
				
		//--------------------------------------------------//
		
		$campo = array();
		$consultacategoriaevento = mysql_query("SELECT * FROM categoriaevento "  );
		
		while($rowcategoriaevento = mysql_fetch_assoc($consultacategoriaevento))
			$campo[$rowcategoriaevento['codCategoriaEvento']] = $rowcategoriaevento['desCategoriaEvento'] ;
		
		$x->setColumnType('codCategoriaEvento', EyeDataGrid::TYPE_ARRAY, $campo);
		
		//--------------------------------------------------//
		
		$campo2 = array();
		$consultacodTipoEvento = mysql_query("SELECT * FROM tipoevento "  );
		
		while($rowcodTipoEvento = mysql_fetch_assoc($consultacodTipoEvento))
			$campo2[$rowcodTipoEvento['codTipoEvento']] = $rowcodTipoEvento['desTipoEvento'] ;
		
		$x->setColumnType('codTipoEvento', EyeDataGrid::TYPE_ARRAY, $campo2);
		
		//--------------------------------------------------//
		
		$campo3 = array();
		$consultaUsuario = mysql_query("SELECT * FROM usuario "  );
		
		while($rowUsuario = mysql_fetch_assoc($consultaUsuario))
			$campo3[$rowUsuario['codUsuario']] = $rowUsuario['endEmail'] ;
		
		$x->setColumnType('codUsuario', EyeDataGrid::TYPE_ARRAY, $campo3);
		
		//--------------------------------------------------//
		
		//$x->setColumnType('Done', EyeDataGrid::TYPE_PERCENT, false, array('Back' => '#c3daf9', 'Fore' => 'black'));

		// Show reset grid control
		//$x->showReset();

		// Add custom control, order does matter
		$x->addCustomControl(EyeDataGrid::CUSCTRL_TEXT, "mostrarColaboracao(%codColaboracao%, %numLatitude%, %numLongitude%, %codUsuario%)", EyeDataGrid::TYPE_ONCLICK, 'Visualizar');

		// Add standard control
		//$x->addStandardControl(EyeDataGrid::STDCTRL_EDIT, "alert('Editing %NomLocal%, %Bairro% (ID: %_P%)')");
		//$x->addStandardControl(EyeDataGrid::STDCTRL_DELETE, "alert('Deleting %_P%')");


		// Add create control
		//$x->showCreateButton("alert('Code for creating a new person')", EyeDataGrid::TYPE_ONCLICK, 'Add New Person');

		// Show checkboxes
		//$x->showCheckboxes();

		// Show row numbers
		//$x->showRowNumber();

		// Apply a function to a row
		/*
		function returnSomething($NomLocal)
		{
			return strrev($NomLocal );
		}
		$x->setColumnType('NomLocal', EyeDataGrid::TYPE_FUNCTION, 'returnSomething', '%NomLocal%');
		*/
		
		if (EyeDataGrid::isAjaxUsed())
		{				
			$x->printTable();
			exit;
		}			
?>