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

$valor3 = '';
if(isset($_GET['valor3'])) $valor3 = $_GET['valor3'];

// Select all the rows in the colaboracao table
$query = "SELECT * FROM colaboracao WHERE 1";
$result = $connection->query($query);
if (!$result)
{
    die('Invalid query: ' . $connection->error);
}

// Start XML file, echo parent node
echo '<colaboracao>';

// Iterate through the rows, printing XML nodes for each
while ($row = @$result->fetch_assoc())
{
	// ADD TO XML DOCUMENT NODE
	echo '<marker ';

	$rr = 'forum="' ;
	$rr .= '&lt;div align=&#39;center&#39; &gt;';

	$consulta = $connection->query("SELECT * FROM comentario WHERE codColaboracao = '$valor3' ORDER BY codComentario DESC ");
	while($row = $consulta->fetch_assoc())
	{
        $codigoDoUsuario = $row["codUsuario"];
        $consultaNomeUsuario = $connection->query("SELECT apelidoUsuario FROM usuario WHERE codUsuario = '$codigoDoUsuario'");
        $rowNomeUsuario = $consultaNomeUsuario->fetch_assoc();
        $rr .= "&lt;fieldset width=&#39;400px&#39; style= &#39;text-align:center; &#39;  &gt;";
        $rr .= "&lt;span&gt;&lt;a href='user_profile.php?uid=".$codigoDoUsuario."' style='color: rgb(255, 158, 0); font-weight: bold;' &gt;" . $rowNomeUsuario['apelidoUsuario']."&lt;/a&gt;" ;
        $rr .= " - ";
        $rr .= date('d/m/Y', strtotime($row["datahoraCriacao"]));
        $rr .= " às ";
        $rr .= date('H:i:s', strtotime($row["datahoraCriacao"]));
        $rr .= "&lt;/span&gt;";
        $rr .= "&lt;p style = &#39; width: 480px; word-wrap: break-word; border-top: 1px solid rgb(218, 218, 218); text-align: center; margin-top: 10px; border-bottom: 1px solid rgb(218, 218, 218); &#39; &gt;";
        $rr .= $row["desComentario"];
        $rr .= "&lt;/p&gt;";
        $rr .= "&lt;/fieldset&gt;";
        $rr .= "&lt;br&gt;";
	}

	$rr .= '&lt;/div&gt;';
	$rr .= '"';

	echo $rr;
	echo '/>';
}

// End XML file
echo '</colaboracao>';