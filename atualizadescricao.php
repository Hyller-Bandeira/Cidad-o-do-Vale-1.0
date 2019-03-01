<?php
	require 'phpsqlinfo_dbinfo.php';
    require 'filtro_gramatical.php';

    date_default_timezone_set('America/Sao_Paulo');
	$horacerta = date("Y/m/d - H:i:s");
	$contador=0;

	$codColaboracao = '';
    $desColaboracaoSemFiltro = '';
	$desColaboracao = '';
	$codUsuario = '';
    $desTituloAssuntoSemFiltro = '';
	$desTituloAssunto = '';

	if(isset($_GET["id"])) $codColaboracao = addslashes(trim($_GET["id"]));
	if(isset($_GET["descricao"])) $desColaboracaoSemFiltro = addslashes(trim($_GET["descricao"]));
	if(isset($_GET["usuario"])) $codUsuario = addslashes(trim($_GET["usuario"]));
	if(isset($_GET["titulo"])) $desTituloAssuntoSemFiltro = addslashes(trim($_GET["titulo"]));
	$datahoraCriacao = $horacerta;


    $consulta = $connection->query("SELECT *
                             FROM usuariosbloqueados
                             WHERE idUsuario = $codUsuario
                             ORDER BY inicioBloqueio DESC
                             ");
    $row = $consulta->fetch_array();

    if ($row['inicioBloqueio'] <= date('Y-m-d H:i:s',strtotime('-'.$row['tempoBloqueio'].' minutes'))) {//Nao esta bloqueado
        $desColaboracao = filtro($desColaboracaoSemFiltro, true);
        $desTituloAssunto = filtro($desTituloAssuntoSemFiltro, false);

        $consulta = $connection->query("SELECT desColaboracao FROM historicocolaboracoes WHERE codUsuario = '$codUsuario' and codColaboracao = '$codColaboracao' ORDER BY datahoraModificacao DESC" );
        $row = $consulta->fetch_assoc();
        $row = $row['desColaboracao'];

        if (!$consulta)
        {
            $contador = $contador + 1;
            die('Invalid query consulta: ' . $connection->error);
        }


        $consulta2 = $connection->query("SELECT desTitulo FROM historicocolaboracoes WHERE codUsuario = '$codUsuario' and codColaboracao = '$codColaboracao' ORDER BY datahoraModificacao DESC" );
        $row2 = $consulta2->fetch_assoc();
        $row2 = $row2['desTitulo'];

        if (!$consulta2)
        {
            $contador = $contador + 1;
            die('Invalid query consulta2: ' . $connection->error);
        }


        if (($row != $desColaboracao || $row2 != $desTituloAssunto) && $desColaboracao != "" && $desTituloAssunto != "")
        {
            $query1 = sprintf("INSERT INTO historicocolaboracoes " .
                     " ( id, codColaboracao, desTituloSemFiltro, desTitulo, desColaboracaoSemFiltro, desColaboracao, datahoraModificacao, codUsuario) " .
                     " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
                     $connection->real_escape_string($codColaboracao),
                     $connection->real_escape_string($desTituloAssuntoSemFiltro),
                     $connection->real_escape_string($desTituloAssunto),
                     $connection->real_escape_string($desColaboracaoSemFiltro),
                     $connection->real_escape_string($desColaboracao),
                     $connection->real_escape_string($datahoraCriacao),
                     $connection->real_escape_string($codUsuario));

            $result1 = $connection->query($query1);

            if (!$result1)
            {
                $contador=$contador+1;
                die('Invalid query 1: ' . $connection->error);
            }

            $query = "UPDATE colaboracao SET desTituloAssunto = '".$desTituloAssunto."', desColaboracao = '".$desColaboracao."', desTituloAssuntoSemFiltro = '".$desTituloAssuntoSemFiltro."', desColaboracaoSemFiltro = '".$desColaboracaoSemFiltro."' WHERE (codColaboracao = ".$codColaboracao.")";
            $atualiza = $connection->query($query);

            if (!$atualiza)
            {
                $contador = $contador + 1;
                die('Invalid query atualiza: ' . $connection->error);
            }

        }

        if ($contador == 0)
        {
            $result = $connection->query("UPDATE usuario SET pontos = pontos+1
                                   WHERE codUsuario = '$codUsuario' ");
            if (!$result) die('Update 2 errado: ' . $connection->error);
        }

        echo '#'.$codColaboracao;
    }else{
        $termino_bloqueio = date('d/m/Y à\s H:i:s', strtotime($row['inicioBloqueio'].'+'.$row['tempoBloqueio'].' minutes'));
        echo "Você não pode realizar esta edição, pois está bloqueado até dia ".$termino_bloqueio;

        $query1 = sprintf("INSERT INTO tentativainteracaobloqueado " .
                " ( codUsuario, descricaoTentativa, codColaboracao) " .
                " VALUES ('%s', '%s', '%s');",
            $connection->real_escape_string($codUsuario),
            $connection->real_escape_string('Tentou Editar'),
            $connection->real_escape_string($codColaboracao));

        $result1 = $connection->query($query1);
    }