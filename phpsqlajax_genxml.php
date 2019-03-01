<?php
require 'phpsqlinfo_dbinfo.php';

function parseToXML($htmlStr)
{
	$xmlStr=str_replace('<','&lt;',$htmlStr);
	$xmlStr=str_replace('>','&gt;',$xmlStr);
	$xmlStr=str_replace('"','&quot;',$xmlStr);
	$xmlStr=str_replace("'",'&#39;',$xmlStr);
	$xmlStr=str_replace("&",'&amp;',$xmlStr);
	return $xmlStr;
}

// Select all the rows in the colaboracao table
$query = "SELECT * FROM colaboracao WHERE tipoStatus != 'R'  
			and (colaboracao.numLongitude <= '-40.670829137390115' and colaboracao.numLongitude >= '-40.70962460858152'
			and colaboracao.numLatitude <= '-16.150872473536403' and colaboracao.numLatitude >= '-16.199755227624433') "
//            ."and desColaboracaoSemFiltro Like('%Jequitinhonha%')"
//            ."and codUsuario IN(216)"
//            ."and codTipoEvento IN(22)"
//            ."and codColaboracao IN(373,1057,1118)"
            ;
$result = $connection->query($query);
if (!$result)
{
	die('Consulta inválida: ' . $connection->error);
}

// Start XML file, echo parent node
echo '<colaboracao>';

// Iterate through the rows, printing XML nodes for each
while ($row = @$result->fetch_assoc())
{
	// ADD TO XML DOCUMENT NODE
	echo '<marker ';
	echo 'codColaboracao="' . parseToXML($row['codColaboracao']) . '" ';
	echo 'numLatitude="' . $row['numLatitude'] . '" ';
	echo 'numLongitude="' . $row['numLongitude'] . '" ';
	echo 'codTipoEvento_ID="' . $row['codTipoEvento'] . '" ';
	echo 'tipoStatus="' . parseToXML($row['tipoStatus']) . '" ';
    echo 'titulo="' . parseToXML($row['desTituloAssunto']) . '" ';
    echo 'codCategoriaEvento_ID="' . $row['codCategoriaEvento'] . '" ';
	echo '/>';
}

// End XML file
echo '</colaboracao>';