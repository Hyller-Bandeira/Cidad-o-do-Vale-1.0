<?php
require 'phpsqlinfo_dbinfo.php';

$categoria = "";
if(isset($_GET["id"])) $categoria = $_GET["id"];

if ($categoria != '') {
    $consulta = $connection->query("SELECT * FROM tipoevento WHERE codCategoriaEvento=" . $categoria);
    $resultado = "";
    while($row = $consulta->fetch_assoc())
        $resultado .= $row['desTipoEvento'] . "|" . $row['codTipoEvento'] . ",";

    echo substr($resultado, 0, -1);
} else {
    echo '';
}