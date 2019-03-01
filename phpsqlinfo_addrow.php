<?php
header('content-type: text/html; charset=utf-8');

require 'phpsqlinfo_dbinfo.php';
require 'atualiza_classe.php';
require 'filtro_gramatical.php';

date_default_timezone_set('America/Sao_Paulo');

$horacerta = date("Y/m/d - H:i:s");
// Get the client ip address
$ip = '';
if (isset($_SERVER['HTTP_CLIENT_IP']))
    $ip = $_SERVER['HTTP_CLIENT_IP'];
else if(isset($_SERVER['HTTP_X_FORWARDED_FOR']))
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if(isset($_SERVER['HTTP_X_FORWARDED']))
    $ip = $_SERVER['HTTP_X_FORWARDED'];
else if(isset($_SERVER['HTTP_FORWARDED_FOR']))
    $ip = $_SERVER['HTTP_FORWARDED_FOR'];
else if(isset($_SERVER['HTTP_FORWARDED']))
    $ip = $_SERVER['HTTP_FORWARDED'];
else if(isset($_SERVER['REMOTE_ADDR']))
    $ip = $_SERVER['REMOTE_ADDR'];
else
    $ip = 'Desconhecido';

$desTituloAssunto = '';
$desTituloAssuntoSemFiltro = '';
$desColaboracaoSemFiltro = '';
$desColaboracao = '';
$codCategoriaEvento = '';
$codTipoEvento = '';
$codUsuario = '';
$dataHoraOcorrencia = '';
$numLatitude = '';
$numLongitude = '';
$zoom = '';
$keywords = '';

if(isset($_POST['desTituloAssunto'])){
    $desTituloAssuntoSemFiltro = $_POST['desTituloAssunto'];
    $desTituloAssunto = ($_POST['desTituloAssunto'] != '' ? filtro($_POST['desTituloAssunto'], false) : '');
}
if(isset($_POST['desColaboracao'])){
    $desColaboracaoSemFiltro = $_POST['desColaboracao'];
    $desColaboracao = ($_POST['desColaboracao'] != '' ? filtro($_POST['desColaboracao'], true) : '');
}

if(!empty($_POST['categoria'])) $codCategoriaEvento = $_POST['categoria'];
if(!empty($_POST['subcategoria'])) $codTipoEvento = $_POST['subcategoria'];
if(!empty($_POST['usuario_id'])) $codUsuario = $_POST['usuario_id'];
if(!empty($_POST['dataHoraOcorrencia'])) $dataHoraOcorrencia = date('Y/m/d - H:i:s', strtotime(str_replace('/', '-', str_replace('-', '', $_POST['dataHoraOcorrencia']))));
if(!empty($_POST['latitudeAtual'])) $numLatitude = $_POST['latitudeAtual'];
if(!empty($_POST['longitudeAtual'])) $numLongitude = $_POST['longitudeAtual'];
if(!empty($_POST['zoom'])) $zoom = $_POST['zoom'];
if(!empty($_POST['keywords'])) $keywords = $_POST['keywords'];

if ($dataHoraOcorrencia == '') {
    $dataHoraOcorrencia = '0000-00-00';
}

$pFoto = '';
$imagem_nome = '';
$desTituloImagem = '';
$desTituloImagemSemFiltro = '';
$comentarioImagem = '';
$comentarioImagemSemFiltro = '';
$desTituloVideo = '';
$desTituloVideoSemFiltro = '';
$desUrlVideo = '';
$comentarioVideo = '';
$comentarioVideoSemFiltro = '';
$usuario_id = '';
$arquivo = '';
$arquivo_nome = '';
$desArquivo = '';
$desArquivoSemFiltro = '';
$comentarioArquivo = '';
$comentarioArquivoSemFiltro = '';

if(!empty($_FILES["Imagem"]["tmp_name"])) $pFoto = $_FILES["Imagem"]["tmp_name"];
if(!empty($_FILES["Imagem"]["name"])) $imagem_nome = $_FILES["Imagem"]["name"];

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

if(!empty($_POST["desUrlVideo"])) $desUrlVideo = $_POST["desUrlVideo"];
if(!empty($_POST["usuario_id"])) $usuario_id  = $_POST["usuario_id"];
if(!empty($_FILES["arquivo"]["tmp_name"])) $arquivo = $_FILES["arquivo"]["tmp_name"];
if(!empty($_FILES["arquivo"]["name"])) $arquivo_nome = $_FILES["arquivo"]["name"];

if(isset($_POST['desArquivo'])){
    $desArquivoSemFiltro = $_POST['desArquivo'];
    $desArquivo = ($_POST['desArquivo'] != '' ? filtro($_POST['desArquivo'], false) : '');
}

if(isset($_POST['comentArq'])){
    $comentarioArquivoSemFiltro = $_POST['comentArq'];
    $comentarioArquivo = ($_POST['comentArq'] != '' ? filtro($_POST['comentArq'], true) : '');
}

$datahoraCriacao = $horacerta;
$anonimo = false;

$consulta_email = $connection->query("SELECT * FROM usuario WHERE codUsuario = '$codUsuario '");
$linha_consulta = $consulta_email->fetch_assoc();

if((substr($linha_consulta["endEmail"], -14, -7) == 'anonimo'))
    $tipoStatus = "R";
else $tipoStatus = "E";

$desJustificativa = "";

$consulta = $connection->query("SELECT *
                         FROM usuariosbloqueados
                         WHERE idUsuario = $codUsuario
                         ORDER BY inicioBloqueio DESC
                         ");
$row = $consulta->fetch_array();

if ($row['inicioBloqueio'] <= date('Y-m-d H:i:s',strtotime('-'.$row['tempoBloqueio'].' minutes'))) {//Nao esta bloqueado
    $testaPontoUnico = 0;
    $consulta = $connection->query("SELECT * FROM  colaboracao WHERE numLatitude = '$numLatitude' AND numLongitude = '$numLongitude' ");
    if ($row2 = $consulta->fetch_assoc())
        $testaPontoUnico = 1;

    if ($desTituloAssunto !='' and $desColaboracaoSemFiltro !='' and $desColaboracao !=''  and $datahoraCriacao  !='' and $codCategoriaEvento !='' and $codUsuario  !='' and $numLatitude  !='' and $numLongitude  !='' and $zoom  !='' and ($testaPontoUnico == 0))
    {
        if ($codTipoEvento == '') {
            $query = sprintf("INSERT INTO colaboracao " .
                    " ( codColaboracao, desTituloAssuntoSemFiltro, desTituloAssunto, desColaboracaoSemFiltro, desColaboracao, datahoraCriacao, codCategoriaEvento, codUsuario, dataHoraOcorrencia, numLatitude, numLongitude, tipoStatus, zoom, desJustificativa, ip) " .
                    " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
                $connection->real_escape_string($desTituloAssuntoSemFiltro),
                $connection->real_escape_string($desTituloAssunto),
                $connection->real_escape_string($desColaboracaoSemFiltro),
                $connection->real_escape_string($desColaboracao),
                $connection->real_escape_string($datahoraCriacao),
                $connection->real_escape_string($codCategoriaEvento),
                $connection->real_escape_string($codUsuario),
                $connection->real_escape_string($dataHoraOcorrencia),
                $connection->real_escape_string($numLatitude),
                $connection->real_escape_string($numLongitude),
                $connection->real_escape_string($tipoStatus),
                $connection->real_escape_string($zoom),
                $connection->real_escape_string($desJustificativa),
                $connection->real_escape_string($ip));
        } else {
            $query = sprintf("INSERT INTO colaboracao " .
                    " ( codColaboracao, desTituloAssuntoSemFiltro, desTituloAssunto, desColaboracaoSemFiltro, desColaboracao, datahoraCriacao, codCategoriaEvento, codTipoEvento, codUsuario, dataHoraOcorrencia, numLatitude, numLongitude, tipoStatus, zoom, desJustificativa, ip) " .
                    " VALUES (NULL, '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s');",
                $connection->real_escape_string($desTituloAssuntoSemFiltro),
                $connection->real_escape_string($desTituloAssunto),
                $connection->real_escape_string($desColaboracaoSemFiltro),
                $connection->real_escape_string($desColaboracao),
                $connection->real_escape_string($datahoraCriacao),
                $connection->real_escape_string($codCategoriaEvento),
                $connection->real_escape_string($codTipoEvento),
                $connection->real_escape_string($codUsuario),
                $connection->real_escape_string($dataHoraOcorrencia),
                $connection->real_escape_string($numLatitude),
                $connection->real_escape_string($numLongitude),
                $connection->real_escape_string($tipoStatus),
                $connection->real_escape_string($zoom),
                $connection->real_escape_string($desJustificativa),
                $connection->real_escape_string($ip));
        }

        $result = $connection->query($query);

        $codColaboracao = $connection->insert_id;

        if (!$result) die('Inserir colaboracao: ' . $connection->error);
        else ganhaPontos(10, $codUsuario, $connection);
        //echo $codColaboracao;

        /*Keywords*/
        $palavras_chave = explode(';', $keywords);
        foreach ($palavras_chave as $palavra){
            if ($palavra != '') {
                $query = sprintf("INSERT INTO palavraschave ( descPalavraChave) VALUES ('%s');", $connection->real_escape_string($palavra));
                $result2 = $connection->query($query);

                $codigo_palavra = $connection->insert_id;

                $query = sprintf("INSERT INTO palavraschavecolaboracoes ( codPalavraChave,codColaboracao ) VALUES ('%s', '%s');",
                    $codigo_palavra,
                    $codColaboracao);

                $result2 = $connection->query($query);
            }
        }

        //Insere na Tabela de histoprico das colaborações a primeira colaboração
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

        if (!$result1) die('Invalid query 1: ' . $connection->error);

        // Insere na tabela estatistica a colaboracao
        $qtdVisualizacao = 0;
        $qtdAvaliacao = 0 ;
        $notaMedia = 0;
        $pesoTotal = 0;

        $query2 = sprintf("INSERT INTO estatistica " .
                " (codColaboracao, qtdVisualizacao, qtdAvaliacao, pesoTotal, notaMedia) " .
                " VALUES ('%s', '%s', '%s', '%s', '%s');",
            $connection->real_escape_string($codColaboracao),
            $connection->real_escape_string($qtdVisualizacao),
            $connection->real_escape_string($qtdAvaliacao),
            $connection->real_escape_string($pesoTotal),
            $connection->real_escape_string($notaMedia));

        $result2 = $connection->query($query2);

        if (!$result2) die('Invalid query 2: ' . $connection->error);
    }
    else echo "Colaboração não enviada. Preencha os campos obrigatórios!";



    /*MultiMídia*/

    if($pFoto && $desTituloImagem)
    {
        $result = 0;

        $target_path = $destination_image . basename($imagem_nome);

        $i = 0;

        $nome = substr($imagem_nome, 0, strrpos($imagem_nome, "."));
        $extensao = end(explode(".", $imagem_nome));
        $nomeMaisExtensao = "$nome" . '.' . "$extensao";

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
            if(move_uploaded_file($pFoto, $target_path))
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
                    die('Invalid query 5: ' . $connection->error);
                }
                else
                {
                    ganhaPontos(5, $codUsuario, $connection);
                }
            }
            else
            {
                echo "Erro no Upload";
            }
        }
        else
        {
            echo "Ja foi inserido imagem nesta colaboração";
        }
    }
    //else echo "NOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPENOPE";

    if($desUrlVideo && $desTituloVideo){

        $pertence = 0; // testa se a colaboração já tem imagem

        // Deixar somente o id do video na url
        parse_str( parse_url( $desUrlVideo, PHP_URL_QUERY ), $my_array_of_vars );
        $desUrlVideo = $my_array_of_vars['v'];

        $query_ultimo = sprintf("SELECT codColaboracao, codUsuario FROM colaboracao WHERE codUsuario = '$usuario_id' ORDER BY codColaboracao DESC LIMIT 1") ;
        $result_ultimo = $connection->query($query_ultimo);
        $escrever=$result_ultimo->fetch_array();
        if ($escrever){

            $codColaboracao = $escrever['codColaboracao'];

            $query_ja_inserido = sprintf("SELECT codColaboracao FROM videos") ;
            $result_ja_inserido = $connection->query($query_ja_inserido);
            while($escrever=$result_ja_inserido->fetch_array()){
                if ($codColaboracao == $escrever['codColaboracao']){
                    $pertence = 1;
                    break;
                }
            }

            if ( ($pertence == 0 ) ){
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

                if (!$result) {
                    die('Invalid query 4: ' . $connection->error);
                }
                else{
                    ganhaPontos(5, $codUsuario, $connection);
                }
            }

            else{
                echo "Ja foi inserido video nesta colaboração" ;
            }
        }
        else{
            echo "Primeiro devemos salvar os dados" ;
        }
    }

    if($arquivo && $desArquivo){

        $result = 0;
        $target_path = $destination_path . basename($arquivo_nome);
        $i = 0;
        $nome = strtolower(substr($arquivo_nome,0,strrpos($arquivo_nome,".")));
        $extensao = strtolower(end(explode(".", $arquivo_nome)));
        $nomeMaisExtensao = "$nome" . '.' . "$extensao";

        while (file_exists($target_path)){
            $i++;
            $nomeMaisExtensao = "$nome" . "$i" . '.' . "$extensao";
            $target_path = $destination_path . basename($nomeMaisExtensao);
        }

        $query_ultimo = sprintf("SELECT codColaboracao, codUsuario FROM colaboracao WHERE codUsuario = '$usuario_id' ORDER BY codColaboracao DESC LIMIT 1") ;
        $result_ultimo = $connection->query($query_ultimo);
        $escrever=$result_ultimo->fetch_array();
        $codColaboracao = $escrever['codColaboracao'];

        $pertence = 0;
        $query_ja_inserido = sprintf("SELECT codColaboracao FROM arquivos") ;
        $result_ja_inserido = $connection->query($query_ja_inserido);
        while($escrever=$result_ja_inserido->fetch_array()){
            if ($codColaboracao == $escrever['codColaboracao']){
                $pertence = 1;
                break;
            }
        }
        if($pertence == 0){
            if(@move_uploaded_file($arquivo, $target_path)) {
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
                    $connection->real_escape_string($usuario_id));

                $result = $connection->query($query);

                if (!$result) {
                    die('Invalid query 5: ' . $connection->error);
                }
                else{
                    ganhaPontos(5, $codUsuario, $connection);
                }
            }
            else{
                echo "Erro no Upload";
            }
        }
        else{
            echo "ja foi inserido arquivos nesta colaboração" ;
        }
    }
    echo '#'.$codColaboracao;
}else{
    $termino_bloqueio = date('d/m/Y à\s H:i:s', strtotime($row['inicioBloqueio'].'+'.$row['tempoBloqueio'].' minutes'));
    echo "Você não pode realizar colaborações, pois está bloqueado até dia ".$termino_bloqueio;

    $query1 = sprintf("INSERT INTO tentativainteracaobloqueado " .
            " ( codUsuario, descricaoTentativa, codColaboracao) " .
            " VALUES ('%s', '%s', 'NULL');",
        $connection->real_escape_string($codUsuario),
        $connection->real_escape_string('Tentou Colaborar'));

    $result1 = $connection->query($query1);
}
function ganhaPontos($pontos, $codUsuario, $connection){
    $result = $connection->query("UPDATE usuario SET pontos = pontos+'$pontos'
								WHERE codUsuario = '$codUsuario' ");
    if (!$result) {
        die('Update 2 errado: ' . $connection->error);
    }
    else atualizaClasse($codUsuario, $connection);
}

?>