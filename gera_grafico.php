<?php
require 'phpsqlinfo_dbinfo.php';

$NorthEast_lng = '';
$NorthEast_lat = '';
$SouthWest_lng = '';
$SouthWest_lat = '';
$tipo = '';

if(isset($_GET['NorthEast_lng'])) $NorthEast_lng = $_GET['NorthEast_lng'];
if(isset($_GET['NorthEast_lat'])) $NorthEast_lat = $_GET['NorthEast_lat'];
if(isset($_GET['SouthWest_lng'])) $SouthWest_lng = $_GET['SouthWest_lng'];
if(isset($_GET['SouthWest_lat'])) $SouthWest_lat = $_GET['SouthWest_lat'];
if(isset($_GET['tipo'])) $tipo = $_GET['tipo'];

if($tipo)
{
	$query = sprintf("SELECT tipoevento.desTipoEvento, colaboracao.numLatitude, colaboracao.numLongitude, COUNT(colaboracao.codTipoEvento), categoriaevento.desCategoriaEvento, COUNT(colaboracao.codCategoriaEvento)
					  FROM colaboracao
					  LEFT JOIN tipoevento ON colaboracao.codTipoEvento = tipoevento.codTipoEvento
					  INNER JOIN categoriaevento ON colaboracao.codCategoriaEvento = categoriaevento.codCategoriaEvento
					  WHERE colaboracao.codCategoriaEvento = '$tipo'
					  and colaboracao.numLongitude <= '$NorthEast_lng' and colaboracao.numLongitude >= '$SouthWest_lng'
					  and colaboracao.numLatitude <= '$NorthEast_lat' and colaboracao.numLatitude >= '$SouthWest_lat'
					  GROUP BY tipoevento.desTipoEvento");

}

$result = $connection->query($query);
$code = '';

while ($row = $result->fetch_array(MYSQLI_NUM)) {
    if ($row[0] == '') {
        $row[0] = $row[4];
        if ($row[3] == 0) {
            $row[3] = $row[5];
        }
    }

    $code .= $row[0] . ",*," . $row[3] . ",-,";
}

$result->free();
echo $code;