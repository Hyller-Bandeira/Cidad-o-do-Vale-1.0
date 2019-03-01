<?php
require 'phpsqlinfo_dbinfo.php';
if ($_POST['func'] == "seen") echo hasSeen($connection);
else if ($_POST['func'] == "ignore") echo setNotShow($connection);
else echo 0;

function hasSeen($connection)
{
    require 'phpsqlinfo_dbinfo.php';
    $consulta1 = $connection->query("SELECT codColaboracao FROM colaboracao WHERE codUsuario=" . $_POST['user']);
    $consulta2 = $connection->query("SELECT viuSistemaAjuda FROM usuario WHERE codUsuario=" . $_POST['user']." AND viuSistemaAjuda = 1");

    $result = ($consulta1->num_rows > 0 || $consulta2->num_rows != 0);
    return $result;
}

function setNotShow($connection)
{
    require 'phpsqlinfo_dbinfo.php';
    $connection->query("UPDATE usuario SET viuSistemaAjuda=1 WHERE codUsuario=" . $_POST['user']);
}