<?php
header('content-type: text/html; charset=utf-8');
require 'phpsqlinfo_dbinfo.php';

$idColaboracao = '';
if(isset($_GET['idColaboracao'])) $idColaboracao = $_GET['idColaboracao'];

function parseToXML($htmlStr)
{
	$xmlStr = str_replace('<', '&lt;', $htmlStr);
	$xmlStr = str_replace('>', '&gt;', $xmlStr);
	$xmlStr = str_replace('"', '&quot;', $xmlStr);
	$xmlStr = str_replace("'", '&#39;', $xmlStr);
	$xmlStr = str_replace("&", '&amp;', $xmlStr);
	return $xmlStr;
}

if ($idColaboracao)
{
	// Select all the rows in the colaboracao table
	$query = "SELECT * FROM colaboracao WHERE codColaboracao = $idColaboracao";
	$result = $connection->query($query);
	if (!$result)
	{
		die('Invalid query: ' . $connection->error);
	}

	ob_start();
	// Start XML file, echo parent node
	echo '<colaboracao>';

	// Iterate through the rows, printing XML nodes for each
	while ($row = @$result->fetch_assoc())
	{
		// ADD TO XML DOCUMENT NODE
		echo '<marker ';
		echo 'codColaboracao="' . parseToXML($row['codColaboracao']) . '" ';
		echo 'desTituloAssunto="' . parseToXML($row['desTituloAssunto']) . '" ';
		echo 'numLatitude="' . $row['numLatitude'] . '" ';
		echo 'numLongitude="' . $row['numLongitude'] . '" ';

		// --------------------------------------------------------------------------------//

		$temp2 = parseToXML($row['codCategoriaEvento']);
		$query5 = "SELECT * FROM categoriaevento WHERE codCategoriaEvento = '$temp2'";
		$result5 = $connection->query($query5);
		$row5 = @$result5->fetch_assoc();
		echo 'codCategoriaEvento="' . parseToXML($row5['desCategoriaEvento']) . '" ';

		// --------------------------------------------------------------------------------//

		$temp2 = parseToXML($row['codTipoEvento']);
		$query5 = "SELECT * FROM tipoevento WHERE codTipoEvento = '$temp2'";
		$result5 = $connection->query($query5);
		$row5 = @$result5->fetch_assoc();

		echo 'codTipoEvento_ID="' . $temp2 . '" ';
		echo 'codTipoEvento="' . parseToXML($row5['desTipoEvento']) . '" ';

		// --------------------------------------------------------------------------------//

        if ($row['dataHoraOcorrencia'] != '0000-00-00 00:00:00')
            $dataHoraOcorrenciaFormatoCerto = date('d/m/Y - H:i:s', strtotime($row['dataHoraOcorrencia']));
		else
			$dataHoraOcorrenciaFormatoCerto='';

		// Escreve todas as colaborações separadas pelo caracter '¥' //
		$texto_desColaboracao = 'desColaboracao="';
        $texto_desTitulo = 'desTituloHistorico="';
        $texto_datahoraModificacao = 'datahoraModificacaoHistorico="';
        $texto_apelidoUsuario = 'apelidoUsuarioHistorico="';

		$consulta = $connection->query("SELECT *
		                                FROM historicocolaboracoes h
		                                INNER JOIN usuario u ON h.codUsuario = u.codUsuario
		                                WHERE h.codColaboracao='$idColaboracao'
		                                ORDER BY h.id ASC");
		while ($row2 = $consulta->fetch_assoc())
		{
            $texto_desColaboracao .= parseToXML($row2['desColaboracao']) . '¥';
            $texto_desTitulo .= parseToXML($row2['desTitulo']) . '¥';
            $texto_datahoraModificacao .= parseToXML($row2['datahoraModificacao']) . '¥';
            $texto_apelidoUsuario .= parseToXML($row2['apelidoUsuario']) . '¥';
		}

		echo $texto_desColaboracao.'" ';
        echo $texto_desTitulo.'" ';
        echo $texto_datahoraModificacao.'" ';
        echo $texto_apelidoUsuario.'" ';

		//-------------------------------------------------------//

		$datahoraCriacaoFormatoCerto = date('d/m/Y - H:i:s', strtotime($row['datahoraCriacao']));
		echo 'datahoraCriacao="' . parseToXML($datahoraCriacaoFormatoCerto) . '" ';
		echo 'dataHoraOcorrencia="' . parseToXML($dataHoraOcorrenciaFormatoCerto) . '" ';
		echo 'desJustificativa="' . parseToXML($row['desJustificativa']) . '" ';
		echo 'tipoStatus="' . parseToXML($row['tipoStatus']) . '" ';
		echo 'codUsuario="' . $row['codUsuario'] . '" ';

        //-------Keywords--------//
        $palavras = '';
        $consulta_aux = $connection->query("SELECT *
                                            FROM palavraschavecolaboracoes
                                            INNER JOIN palavraschave ON palavraschavecolaboracoes.codPalavraChave = palavraschave.codPalavraChave
                                            WHERE codColaboracao = '$idColaboracao'");
        while ($row_aux = $consulta_aux->fetch_assoc())
        {
            $palavras .= $row_aux['descPalavraChave'].'; ';
        }
        if (strlen($palavras) > 2) {
            $palavras = substr($palavras, 0, strlen($palavras)-2);//Remove ultimo ;
        }
        echo 'keywords="'.$palavras.'" ';


		//-------multimidia--------//

		$codColaboracao = $row['codColaboracao'];
		$consulta = $connection->query("SELECT *
		                                FROM multimidia m
		                                INNER JOIN usuario u ON u.codUsuario = m.codUsuario
		                                WHERE m.codColaboracao = '$codColaboracao'");
		$row2 = $consulta->fetch_assoc();
		echo 'endImagem="' . parseToXML($row2['endImagem']) . '" ';
		echo 'desTituloImagem="' . parseToXML($row2['desTituloImagem']) . '" ';
		echo 'comentarioImagem="' . parseToXML($row2['comentarioImagem']) . '" ';
        echo 'apelidoImagem="' . parseToXML($row2['apelidoUsuario']) . '" ';
        echo 'dataEnvioImagem="' . parseToXML($row2['dataEnvioImagem']) . '" ';

		//-------------------------//

		$codColaboracao = $row['codColaboracao'];
		$consulta = $connection->query("SELECT *
		                                FROM videos v
		                                INNER JOIN usuario u ON u.codUsuario = v.codUsuario
		                                WHERE codColaboracao = '$codColaboracao'");
		$row2 = $consulta->fetch_assoc();
		echo 'desTituloVideo="' . parseToXML($row2['desTituloVideo']) . '" ';
		echo 'desUrlVideo="' . parseToXML($row2['desUrlVideo']) . '" ';
		echo 'comentarioVideo="' . parseToXML($row2['comentarioVideo']) . '" ';
        echo 'apelidoVideo="' . parseToXML($row2['apelidoUsuario']) . '" ';
        echo 'dataEnvioVideo="' . parseToXML($row2['dataEnvioVideo']) . '" ';

		//-------------------------//

		$codColaboracao = $row['codColaboracao'];
		$consulta3 = $connection->query("SELECT * FROM estatistica WHERE codColaboracao = '$codColaboracao'");
		$row3 = $consulta3->fetch_assoc();
		echo 'notaMedia="' . $row3['notaMedia'] . '" ';
		echo 'qtdVisualizacao="' . $row3['qtdVisualizacao'] . '" ';
		echo 'qtdAvaliacao="' . $row3['qtdAvaliacao'] . '" ';

		//-------------------------//

		$codColaboracao = $row['codColaboracao'];
		$consulta4 = $connection->query("SELECT *
		                                 FROM arquivos a
		                                 INNER JOIN usuario u ON u.codUsuario = a.codUsuario
		                                 WHERE codColaboracao = '$codColaboracao'");
		$row4 = $consulta4->fetch_assoc();
		echo 'endArquivo="' . parseToXML($row4['endArquivo']) . '" ';
		echo 'tituloArquivo="' . parseToXML($row4['desArquivo']) . '" ';
		echo 'comentarioArquivo="' . parseToXML($row4['comentarioArquivo']) . '" ';
        echo 'apelidoArquivo="' . parseToXML($row4['apelidoUsuario']) . '" ';
        echo 'dataEnvioArquivo="' . parseToXML($row4['dataEnvioArquivo']) . '" ';

		//-------------------------//

		$rr = 'forum="' ;

		$consulta = $connection->query("SELECT * FROM comentario WHERE codColaboracao = '$codColaboracao' ORDER BY codComentario DESC");

        if ($consulta->num_rows > 0){
            $rr .= '&lt;div align=&#39;center&#39; &gt;';

            while($row = $consulta->fetch_assoc())
            {
                $codigoDoUsuario = $row["codUsuario"];
                $consultaNomeUsuario = $connection->query("SELECT apelidoUsuario FROM usuario WHERE codUsuario = '$codigoDoUsuario'");
                $rowNomeUsuario = $consultaNomeUsuario->fetch_assoc();
                $rr .= "&lt;fieldset width=&#39;400px&#39; style= &#39;text-align:center; &#39;  &gt;";
                $rr .= "&lt;span&gt;&lt;a href='user_profile.php?uid=".$codigoDoUsuario."' style='color: rgb(255, 158, 0); font-weight: bold;' &gt;" . $rowNomeUsuario['apelidoUsuario']."&lt;/a&gt;" ;
                $rr .= " - ";
                $rr .= date('d/m/Y', strtotime($row["datahoraCriacao"]));
                $rr .= " às ";
                $rr .= date('H:i:s', strtotime($row["datahoraCriacao"]));
                $rr .= "&lt;/span&gt;";
                $rr .= "&lt;p style = &#39; width: 480px; word-wrap: break-word; border-top: 1px solid rgb(218, 218, 218); text-align: center; margin-top: 10px; border-bottom: 1px solid rgb(218, 218, 218); &#39; &gt;";
                $rr .= $row["desComentario"];
                $rr .= "&lt;/p&gt;";
                $rr .= "&lt;/fieldset&gt;";
                $rr .= "&lt;br&gt;";
            }

            $rr .= '&lt;/div&gt;';
        }
		$rr .= '"';
		echo $rr;

		echo '/>';
	}

	// End XML file
	echo '</colaboracao>';
	error_log(ob_get_flush());
}
?>