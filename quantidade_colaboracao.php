<?php
    header('content-type: text/html; charset=utf-8');
    require 'phpsqlinfo_dbinfo.php';

    $codUsuario = $_POST['user_id'];

    $consulta = $connection->query("SELECT *
                                 FROM colaboracao
                                 WHERE codUsuario = $codUsuario");

    echo $consulta->num_rows;
?>