<?php
    header('content-type: text/html; charset=utf-8');
    require 'phpsqlinfo_dbinfo.php';
    date_default_timezone_set('America/Sao_Paulo');

    //A função que retorna a diferença entre hora inicial e hora final
    function difDeHoras($hIni, $hFinal)
    {
        // Separa á hora dos minutos
        $hIni = explode(':', $hIni);
        $hFinal = explode(':', $hFinal);

        // Converte a hora e minuto para segundos
        $hIni = (60 * 60 * $hIni[0]) + (60 * $hIni[1]);
        $hFinal = (60 * 60 * $hFinal[0]) + (60 * $hFinal[1]);

        // Verifica se a hora final é maior que a inicial
        if(!($hIni < $hFinal)) {
            return false;
        }

        // Calcula diferença de horas
        $difDeHora = $hFinal - $hIni;

        return floor($difDeHora/60);
    }

    $codUsuario = (!empty($_POST['user_id']) ? $_POST['user_id'] : '');

    $consulta = $connection->query("SELECT *
                             FROM colaboracao
                             WHERE codUsuario = $codUsuario
                             AND datahoraCriacao >= '".date('Y-m-d H:i:s',strtotime('-'.$intervalo_entre_numero_colaboracoes_consecutivas.' minutes'))."'");

    if ($consulta->num_rows == $numero_colaboracoes_consecutivas-1) {
        $query = sprintf("INSERT INTO usuariosbloqueados " .
                " ( idUsuario, 	tempoBloqueio) " .
                " VALUES ('%s', '%s');",
            $connection->real_escape_string($codUsuario),
            $connection->real_escape_string(0));//Usuario quase bloqueado

        $result = $connection->query($query);

        if (!$result) die('Invalid query: ' . $connection->error);

        $maior_data = '0000-00-00 00:00:00';
        $menor_data = date('Y-m-d H:i:s') ;

        while($linha = $consulta->fetch_assoc()){
            if ($linha['datahoraCriacao'] > $maior_data) {
                $maior_data = $linha['datahoraCriacao'];
            }

            if ($linha['datahoraCriacao'] <= $menor_data) {
                $menor_data = $linha['datahoraCriacao'];
            }
        }

        //Essa operação me retorna a diferença entre hora inicial e hora final
        $diferencatempo = difDeHoras( $menor_data, $maior_data  );

        $tempo_restante = $intervalo_entre_numero_colaboracoes_consecutivas - $diferencatempo;

        echo 'Caso você realize mais uma colaboração em menos de '.$tempo_restante.' minutos, você será bloqueado por '. $tempo_de_bloqueio/60 .' horas!';
    } else if ($consulta->num_rows == $numero_colaboracoes_consecutivas) {
        $query3 = sprintf("INSERT INTO usuariosbloqueados " .
                " ( idUsuario, 	tempoBloqueio) " .
                " VALUES ('%s', '%s');",
            $connection->real_escape_string($codUsuario),
            $connection->real_escape_string($tempo_de_bloqueio));

        $result3 = $connection->query($query3);

        if (!$result3) die('Invalid query 3: ' . $connection->error);

        echo "Você realizou ".$numero_colaboracoes_consecutivas." colaborações em menos de ".$intervalo_entre_numero_colaboracoes_consecutivas." minutos. Por isto, você está impedido de realizar colaborações nas próximas ". $tempo_de_bloqueio/60 ." horas!";
    }
?>