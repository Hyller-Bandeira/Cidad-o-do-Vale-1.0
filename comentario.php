<?php
    require 'phpsqlinfo_dbinfo.php';
    require 'atualiza_classe.php';
    require 'filtro_gramatical.php';
    date_default_timezone_set('America/Sao_Paulo');

    //RECEBE PARÂMETRO
    $desComentarioSemFiltro = '';
    $desComentario = '';
    $codUsuario = '';
    $codColaboracao = '';

    if(!empty($_POST["desComentario"])) $desComentarioSemFiltro = $_POST["desComentario"];
    if(!empty($_POST["usuario_id"])) $codUsuario = $_POST["usuario_id"];
    if(!empty($_POST["codColaboracao"])) $codColaboracao = $_POST["codColaboracao"];
    $desComentario = filtro($desComentarioSemFiltro, true);

    $horacerta = date("Y-m-d H:i:s");
    $contador=0;

    $consulta = $connection->query("SELECT *
                             FROM usuariosbloqueados
                             WHERE idUsuario = $codUsuario
                             ORDER BY inicioBloqueio DESC
                             ");
    $row = $consulta->fetch_array();

    if ($row['inicioBloqueio'] <= date('Y-m-d H:i:s',strtotime('-'.$row['tempoBloqueio'].' minutes'))) {//Nao esta bloqueado
        $consulta = $connection->query("SELECT * FROM colaboracao WHERE codColaboracao = '$codColaboracao' ");
        $row = $consulta->fetch_assoc();
        //echo $row['codTipoEvento'];
        if (!$consulta) {
            $contador=$contador+1;
            die('Invalid query 1: ' . $connection->error);
        }


        if ($desComentario and $codUsuario  and $horacerta){
            // Insert new row with user data
            $query = sprintf("INSERT INTO comentario " .
                             " ( desComentarioSemFiltro, desComentario, datahoraCriacao, codColaboracao, codUsuario ) " .
                             " VALUES ('%s', '%s', '%s', '%s', '%s');",
                             $connection->real_escape_string($desComentarioSemFiltro),
                             $connection->real_escape_string($desComentario),
                             $connection->real_escape_string($horacerta),
                             $connection->real_escape_string($codColaboracao),
                             $connection->real_escape_string($codUsuario)
                     );

            $result = $connection->query($query);

            if (!$result)
            {
                $contador = $contador + 1;
                die('Invalid query 1: ' . $connection->error);
            }
        }

        // +Pontos por comentar a colaboração
        if ($contador == 0)
        {
            $result = $connection->query("UPDATE usuario SET pontos = pontos+3
                                   WHERE codUsuario = '$codUsuario' ");
            if (!$result) die('Update 2 errado: ' . $connection->error);
            else atualizaClasse($codUsuario, $connection);
        }

        echo '#'.$codColaboracao;
    }else{
        $termino_bloqueio = date('d/m/Y à\s H:i:s', strtotime($row['inicioBloqueio'].'+'.$row['tempoBloqueio'].' minutes'));
        echo "Você não pode realizar comentários, pois está bloqueado até dia ".$termino_bloqueio;

        $query1 = sprintf("INSERT INTO tentativainteracaobloqueado " .
                " ( codUsuario, descricaoTentativa, codColaboracao) " .
                " VALUES ('%s', '%s', '%s');",
            $connection->real_escape_string($codUsuario),
            $connection->real_escape_string('Tentou Comentar'),
            $connection->real_escape_string($codColaboracao));

        $result1 = $connection->query($query1);
    }
?>