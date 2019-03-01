<?php
require 'phpsqlinfo_dbinfo.php';
require 'atualiza_classe.php';
require 'filtro_gramatical.php';

ini_set('display_errors',1);
error_reporting(E_ALL);

$codColaboracao = '';
$pFoto = '';
$imagem_nome = '';
$desTituloImagemSemFiltro = '';
$desTituloImagem = '';
$comentarioImagemSemFiltro = '';
$comentarioImagem = '';
$desTituloVideoSemFiltro = '';
$desTituloVideo = '';
$desUrlVideo = '';
$comentarioVideoSemFiltro = '';
$comentarioVideo = '';
$codUsuario = '';
$arquivo = '';
$arquivo_nome = '';
$desArquivoSemFiltro = '';
$desArquivo = '';
$comentarioArquivoSemFiltro = '';
$comentarioArquivo = '';

if(isset($_POST["codColaboracao"])) $codColaboracao = $_POST["codColaboracao"];
if(isset($_FILES["Imagem"]["tmp_name"])) $pFoto = $_FILES["Imagem"]["tmp_name"];
if(isset($_FILES["Imagem"]["name"])) $imagem_nome = $_FILES["Imagem"]["name"];

if(isset($_POST['desTituloImagem'])){
    $desTituloImagemSemFiltro = $_POST['desTituloImagem'];
    $desTituloImagem = ($_POST['desTituloImagem'] != '' ? filtro($_POST['desTituloImagem'], false) : '');
}

if(isset($_POST['comentImagem'])){
    $comentarioImagemSemFiltro = $_POST['comentImagem'];
    $comentarioImagem = ($_POST['comentImagem'] != '' ? filtro($_POST['comentImagem'], true) : '');
}

if(isset($_POST['desTituloVideo'])){
    $desTituloVideoSemFiltro = $_POST['desTituloVideo'];
    $desTituloVideo = ($_POST['desTituloVideo'] != '' ? filtro($_POST['desTituloVideo'], false) : '');
}

if(isset($_POST['comentVideo'])){
    $comentarioVideoSemFiltro = $_POST['comentVideo'];
    $comentarioVideo = ($_POST['comentVideo'] != '' ? filtro($_POST['comentVideo'], true) : '');
}

if(isset($_POST["desUrlVideo"])) $desUrlVideo = $_POST["desUrlVideo"];
if(isset($_POST["usuario_id"])) $codUsuario = $_POST["usuario_id"];
if(isset($_FILES["arquivo"]["tmp_name"])) $arquivo = $_FILES["arquivo"]["tmp_name"];
if(isset($_FILES["arquivo"]["name"])) $arquivo_nome = $_FILES["arquivo"]["name"];

if(isset($_POST['desArquivo'])){
    $desArquivoSemFiltro = $_POST['desArquivo'];
    $desArquivo = ($_POST['desArquivo'] != '' ? filtro($_POST['desArquivo'], false) : '');
}

if(isset($_POST['comentArq'])){
    $comentarioArquivoSemFiltro = $_POST['comentArq'];
    $comentarioArquivo = ($_POST['comentArq'] != '' ? filtro($_POST['comentArq'], true) : '');
}

$consulta = $connection->query("SELECT *
                         FROM usuariosbloqueados
                         WHERE idUsuario = $codUsuario
                         ORDER BY inicioBloqueio DESC
                         ");
$row = $consulta->fetch_array();

$codColaboracaoAtualizada = '';
$mensagem_bloqueio = '';

if($pFoto && $desTituloImagem)
{
    if ($row['inicioBloqueio'] <= date('Y-m-d H:i:s',strtotime('-'.$row['tempoBloqueio'].' minutes'))) {//Nao esta bloqueado
        $result = 0;
        $target_path = $destination_image . basename($imagem_nome);

        $nome = substr($imagem_nome, 0, strrpos($imagem_nome, "."));
        $extensao = strtolower(end(explode(".", $imagem_nome)));
        $nomeMaisExtensao = "$nome" . '.' . "$extensao";

        $i = 0;
        while (file_exists($target_path))
        {
            ++$i;
            $nomeMaisExtensao = "$nome" . "$i" . '.' . "$extensao";
            $target_path = $destination_image . basename($nomeMaisExtensao);
        }

        $pertence = 0;
        $query_ja_inserido = sprintf("SELECT codColaboracao FROM multimidia");
        $result_ja_inserido = $connection->query($query_ja_inserido);
        while($escrever = $result_ja_inserido->fetch_array())
        {
            if ($codColaboracao == $escrever['codColaboracao'])
            {
                $pertence = 1;
                break;
            }
        }

        if($pertence == 0)
        {
//            die("ASDASD");
            //print_r($target_path."\n");
            //print_r(getcwd());
            //exit;
            if(move_uploaded_file($pFoto, $target_path))
//            if(move_uploaded_file($pFoto, getcwd().'/IMG.png'))
            {
                $result = 1;

                $query = sprintf("INSERT INTO multimidia " .
                        " (codMultimidia, desTituloImagemSemFiltro, desTituloImagem, comentarioImagemSemFiltro, comentarioImagem ,endImagem, codColaboracao, codUsuario)" .
                        " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
                    $connection->real_escape_string($desTituloImagemSemFiltro),
                    $connection->real_escape_string($desTituloImagem),
                    $connection->real_escape_string($comentarioImagemSemFiltro),
                    $connection->real_escape_string($comentarioImagem),
                    $connection->real_escape_string($nomeMaisExtensao),
                    $connection->real_escape_string($codColaboracao),
                    $connection->real_escape_string($codUsuario));

                $result = $connection->query($query);

                if (!$result)
                {
                    error_log('Invalid query 5: ' . $connection->error);
                    die('Invalid query 5: ' . $connection->error);
                }
                else
                {
                    $result = $connection->query("UPDATE usuario SET pontos = pontos+2
                                           WHERE codUsuario = '$codUsuario' ");
                    if (!$result)
                    {
                        error_log('Update 2 errado: ' . $connection->error);
                        die('Update 2 errado: ' . $connection->error);
                    }
                    else atualizaClasse($codUsuario, $connection);

                    $codColaboracaoAtualizada = $codColaboracao;
                }
            }
            else
            {
                error_log("Erro no Upload");
                echo "Erro no Upload";
            }
        }
        else
        {
            error_log("Já foi inserido imagem nesta colaboração");
            echo "Já foi inserido imagem nesta colaboração";
        }
    } else {
        $termino_bloqueio = date('d/m/Y à\s H:i:s', strtotime($row['inicioBloqueio'].'+'.$row['tempoBloqueio'].' minutes'));
        $mensagem_bloqueio = "Você não pode enviar a imagem, pois está bloqueado até dia ".$termino_bloqueio;

        $query1 = sprintf("INSERT INTO tentativainteracaobloqueado " .
                " ( codUsuario, descricaoTentativa, codColaboracao) " .
                " VALUES ('%s', '%s', '%s');",
            $connection->real_escape_string($codUsuario),
            $connection->real_escape_string('Tentou Enviar Imagem'),
            $connection->real_escape_string($codColaboracao));

        $result1 = $connection->query($query1);
    }
}

if($desUrlVideo && $desTituloVideo)
{
    if ($row['inicioBloqueio'] <= date('Y-m-d H:i:s',strtotime('-'.$row['tempoBloqueio'].' minutes'))) {//Nao esta bloqueado
        $pertence = 0; // testa se a colaboração já tem imagem

        // Deixar somente o id do video na url
        parse_str( parse_url( $desUrlVideo, PHP_URL_QUERY ), $my_array_of_vars );
        $desUrlVideo = $my_array_of_vars['v'];

        $query_ja_inserido = sprintf("SELECT codColaboracao FROM videos") ;
        $result_ja_inserido = $connection->query($query_ja_inserido);
        while($escrever=$result_ja_inserido->fetch_array())
        {
            if ($codColaboracao == $escrever['codColaboracao'])
            {
                $pertence = 1;
                break;
            }
        }

        if ($pertence == 0)
        {
            $query = sprintf("INSERT INTO videos " .
                    " ( codVideo, desTituloVideoSemFiltro, desTituloVideo, desUrlVideo, comentarioVideoSemFiltro, comentarioVideo, codColaboracao, codUsuario)" .
                    " VALUES (NULL, '%s', '%s', '%s','%s', '%s','%s','%s');",
                $connection->real_escape_string($desTituloVideoSemFiltro),
                $connection->real_escape_string($desTituloVideo),
                $connection->real_escape_string($desUrlVideo) ,
                $connection->real_escape_string($comentarioVideoSemFiltro) ,
                $connection->real_escape_string($comentarioVideo) ,
                $connection->real_escape_string($codColaboracao),
                $connection->real_escape_string($codUsuario));

            $result = $connection->query($query);

            if (!$result) { die('Invalid query 4: ' . $connection->error); }
            else
            {
                $result = $connection->query("UPDATE usuario SET pontos = pontos + 2 WHERE codUsuario = '$codUsuario' ");
                if (!$result) { die('Update 2 errado: ' . $connection->error); }
                else atualizaClasse($codUsuario,$connection);

                $codColaboracaoAtualizada = $codColaboracao;
            }
        }
        else echo "ja foi inserido video nesta colaboração";
    } else {
        $termino_bloqueio = date('d/m/Y à\s H:i:s', strtotime($row['inicioBloqueio'].'+'.$row['tempoBloqueio'].' minutes'));
        if ($mensagem_bloqueio != '') {
            $mensagem_bloqueio = "Você não pode realizar esta ação, pois está bloqueado até dia ".$termino_bloqueio;
        } else {
            $mensagem_bloqueio = "Você não pode enviar o vídeo, pois está bloqueado até dia ".$termino_bloqueio;
        }

        $query1 = sprintf("INSERT INTO tentativainteracaobloqueado " .
                " ( codUsuario, descricaoTentativa, codColaboracao) " .
                " VALUES ('%s', '%s', '%s');",
            $connection->real_escape_string($codUsuario),
            $connection->real_escape_string('Tentou Enviar Vídeo'),
            $connection->real_escape_string($codColaboracao));

        $result1 = $connection->query($query1);
    }
}

if($arquivo && $desArquivo)
{
    if ($row['inicioBloqueio'] <= date('Y-m-d H:i:s',strtotime('-'.$row['tempoBloqueio'].' minutes'))) {//Nao esta bloqueado
        $result = 0;
        $target_path = $destination_path . basename($arquivo_nome);
        $nome = strtolower(substr($arquivo_nome,0,strrpos($arquivo_nome,".")));
        $extensao = strtolower(end(explode(".", $arquivo_nome)));
        $nomeMaisExtensao = "$nome" . '.' . "$extensao";

        $i = 0;
        while (file_exists($target_path))
        {
            ++$i;
            $nomeMaisExtensao = "$nome" . "$i" . '.' . "$extensao";
            $target_path = $destination_path . basename($nomeMaisExtensao);
        }

        $pertence = 0;
        $query_ja_inserido = sprintf("SELECT codColaboracao FROM arquivos");
        $result_ja_inserido = $connection->query($query_ja_inserido);
        while($escrever = $result_ja_inserido->fetch_array())
        {
            if ($codColaboracao == $escrever['codColaboracao'])
            {
                $pertence = 1;
                break;
            }
        }

        if($pertence == 0)
        {
            if(@move_uploaded_file($arquivo, $target_path))
            {
                $result = 1;
                $query = sprintf("INSERT INTO arquivos " .
                        " ( codArquivo, desArquivoSemFiltro, desArquivo, comentarioArquivoSemFiltro, comentarioArquivo ,endArquivo, codColaboracao, codUsuario)" .
                        " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
                    $connection->real_escape_string($desArquivoSemFiltro),
                    $connection->real_escape_string($desArquivo),
                    $connection->real_escape_string($comentarioArquivoSemFiltro),
                    $connection->real_escape_string($comentarioArquivo),
                    $connection->real_escape_string($nomeMaisExtensao),
                    $connection->real_escape_string($codColaboracao),
                    $connection->real_escape_string($codUsuario));

                $result = $connection->query($query);
                if (!$result) { die('Invalid query 5: ' . $connection->error); }
                else
                {
                    $result = $connection->query("UPDATE usuario SET pontos = pontos + 2 WHERE codUsuario = '$codUsuario' ");
                    if (!$result) { die('Update 2 errado: ' . $connection->error); }
                    else atualizaClasse($codUsuario,$connection);

                    $codColaboracaoAtualizada = $codColaboracao;
                }

            }
            else echo "Erro no Upload";
        }
        else echo "ja foi inserido arquivos nesta colaboração" ;
    } else {
        $termino_bloqueio = date('d/m/Y à\s H:i:s', strtotime($row['inicioBloqueio'].'+'.$row['tempoBloqueio'].' minutes'));
        if ($mensagem_bloqueio != '') {
            $mensagem_bloqueio = "Você não pode realizar esta ação, pois está bloqueado até dia ".$termino_bloqueio;
        } else {
            $mensagem_bloqueio = "Você não pode enviar o arquivo, pois está bloqueado até dia ".$termino_bloqueio;
        }

        $query1 = sprintf("INSERT INTO tentativainteracaobloqueado " .
                " ( codUsuario, descricaoTentativa, codColaboracao) " .
                " VALUES ('%s', '%s', '%s');",
            $connection->real_escape_string($codUsuario),
            $connection->real_escape_string('Tentou Enviar Arquivo'),
            $connection->real_escape_string($codColaboracao));

        $result1 = $connection->query($query1);
    }
}

if ($codColaboracaoAtualizada != ''){
    echo '#'.$codColaboracaoAtualizada;
} else if ($mensagem_bloqueio != '') {
    echo $mensagem_bloqueio;
}