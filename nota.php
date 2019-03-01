<?php
require 'phpsqlinfo_dbinfo.php';

$nota = '';
$codUsuario = '';
$codColaboracao = '';

if(isset($_GET["nota"])) $nota = addslashes(trim($_GET["nota"]));
if(isset($_GET["codUsuario"])) $codUsuario = addslashes(trim($_GET["codUsuario"]));
if(isset($_GET["codColaboracao"])) $codColaboracao = addslashes(trim($_GET["codColaboracao"]));

$consulta = $connection->query("SELECT *
                         FROM usuariosbloqueados
                         WHERE idUsuario = $codUsuario
                         ORDER BY inicioBloqueio DESC
                         ");
$row = $consulta->fetch_array();

if ($row['inicioBloqueio'] <= date('Y-m-d H:i:s',strtotime('-'.$row['tempoBloqueio'].' minutes'))) {//Nao esta bloqueado
    $consulta = $connection->query("SELECT * FROM avaliacao WHERE codColaboracao = '$codColaboracao' AND codUsuario = '$codUsuario' " );
    if (!$consulta)
    {
        die('Consulta 1 errada: ' . $connection->error);
    }

    // Se o usuário ainda não avaliou a colaboração
    if (!($row = $consulta->fetch_assoc()))
    {
        $consulta2 = $connection->query("SELECT * FROM estatistica WHERE codColaboracao = '$codColaboracao' " );
        if (!$consulta2)
        {
            die('Consulta 2 errada: ' . $connection->error);
        }

        if($row2 = $consulta2->fetch_assoc())
        {

            $consulta3 = $connection->query("SELECT * FROM usuario WHERE codUsuario = '$codUsuario' " );
            if (!$consulta3)
            {
                die('Consulta 3 errada: ' . $connection->error);
            }

            $row = $consulta3->fetch_assoc();
            $PesoNota = $row['pontos'];

            $qtdAvaliacao = ($row2['qtdAvaliacao'] + 1) ;
            $pesoTotal = $row2['pesoTotal'];
            $notaMedia = $row2['notaMedia'];
            $notaMedia_antiga = $notaMedia;
            $notaMedia = (($notaMedia*$pesoTotal)+($nota*$PesoNota))/($pesoTotal+$PesoNota);
            $pesoTotal = $pesoTotal +  $PesoNota;

            $result = $connection->query("UPDATE estatistica SET qtdAvaliacao = '$qtdAvaliacao', notaMedia = '$notaMedia', pesoTotal = '$pesoTotal'
                                   WHERE codColaboracao = '$codColaboracao' ");
            if (!$result)
            {
                die('Update 1 errado: ' . $connection->error);
            }

            $consulta4 = $connection->query("SELECT codUsuario FROM colaboracao WHERE codColaboracao = '$codColaboracao'" );
            if (!$consulta4)
            {
                die('Consulta 4 errada: ' . $connection->error);
            }

            $codUsuarioColaboracao = $consulta4->fetch_assoc();
            $codUsuarioColaboracao_temp = $codUsuarioColaboracao['codUsuario'];

            $consulta5 = $connection->query("SELECT pontos FROM usuario WHERE codUsuario = '$codUsuarioColaboracao_temp'" );
            if (!$consulta5)
            {
                die('Consulta 5 errada: ' . $connection->error);
            }

            $pontos_usuario_colaboracao = $consulta5->fetch_assoc();
            $pontos_atualizado = ($pontos_usuario_colaboracao['pontos'] - ($notaMedia_antiga * ($qtdAvaliacao-1))) + ($notaMedia*$qtdAvaliacao);

            $result = $connection->query("UPDATE usuario SET pontos = '$pontos_atualizado'
                                   WHERE codUsuario = '$codUsuarioColaboracao_temp' ");
            if (!$result)
            {
                die('Update 2 errado: ' . $connection->error);
            }

            $query3 = sprintf("INSERT INTO avaliacao (codColaboracao, codUsuario) VALUES ('%s', '%s');",
                      $connection->real_escape_string($codColaboracao), $connection->real_escape_string($codUsuario));

            $result3 = $connection->query($query3);
            if (!$result3)
            {
                die('Insert 1 errado: ' . $connection->error);
            }

            echo '#'.$codColaboracao;

            //+1 ponto para o usuário que avaliou
            $result = $connection->query("UPDATE usuario SET pontos = pontos + 1 WHERE codUsuario = '$codUsuario' ");
            if (!$result)
            {
                die('Update 2 errado: ' . $connection->error);
            }
        }
    }
    else {
        echo "Você já avaliou essa colaboração";
    }
}else{
    $termino_bloqueio = date('d/m/Y à\s H:i:s', strtotime($row['inicioBloqueio'].'+'.$row['tempoBloqueio'].' minutes'));
    echo "Você não pode realizar avaliações, pois está bloqueado até dia ".$termino_bloqueio;

    $query1 = sprintf("INSERT INTO tentativainteracaobloqueado " .
            " ( codUsuario, descricaoTentativa, codColaboracao) " .
            " VALUES ('%s', '%s', '%s');",
        $connection->real_escape_string($codUsuario),
        $connection->real_escape_string('Tentou Avaliar'),
        $connection->real_escape_string($codColaboracao));

    $result1 = $connection->query($query1);
}