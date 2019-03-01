<?php
require 'phpsqlinfo_dbinfo.php';
date_default_timezone_set('UTC');

$search = '';
$norte = '';
$sul = '';
$leste = '';
$oeste = '';
$dataInicio = '';
$dataFim = '';
$categoria_atual = '';
$tipo_atual = '';

if(isset($_GET["search"])) $search = addslashes(trim($_GET["search"]));
$search = str_replace(" ","%",$search);
if(isset($_GET["norte"])) $norte = addslashes(trim($_GET["norte"]));
if(isset($_GET["sul"])) $sul = addslashes(trim($_GET["sul"]));
if(isset($_GET["leste"])) $leste = addslashes(trim($_GET["leste"]));
if(isset($_GET["oeste"])) $oeste = addslashes(trim($_GET["oeste"]));

if(isset($_GET["dataInicio"])) $dataInicio = addslashes(trim($_GET["dataInicio"]));
if(isset($_GET["dataFim"])) $dataFim = addslashes(trim($_GET["dataFim"]));

if(isset($_GET["categoria_atual"])) $categoria_atual = addslashes(trim($_GET["categoria_atual"]));
if(isset($_GET["tipo_atual"])) $tipo_atual = addslashes(trim($_GET["tipo_atual"]));

if( $dataInicio == '')
	$dataInicio = '01/01/2015';

if( $dataFim == '')
	$dataFim = date('d/m/Y H:i:s');

$dataInicioArray = explode ("/", $dataInicio );
$dataFimArray = explode ("/", $dataFim );

$dataInicio = $dataInicioArray[2] . '/' . $dataInicioArray[1] . '/' . $dataInicioArray[0];
$dataFim = $dataFimArray[2] . '/' . $dataFimArray[1] . '/' . $dataFimArray[0];

if ($dataInicio == $dataFim)
	$dataFim .= " 23:59:59";

$dataInicio	= date('Y-m-d H:i:s', strtotime($dataInicio));
$dataFim = date('Y-m-d H:i:s', strtotime($dataFim));

$condicaoTotal='';
if (is_numeric($norte) and is_numeric($sul) and is_numeric($leste) and is_numeric($oeste))
{
	$condicaoTotal = "colaboracao.numLongitude <= '$leste' and colaboracao.numLongitude >= '$oeste'
					  and colaboracao.numLatitude <= '$norte' and colaboracao.numLatitude >= '$sul' and ";
}

if ($dataInicio != '1970-01-01 00:00:00' and $dataFim != '1970-01-01 00:00:00')
{
	$condicaoTotal .= "colaboracao.datahoraCriacao <= '$dataFim' and colaboracao.datahoraCriacao >= '$dataInicio' and ";
}

if ($categoria_atual)
{
	$condicaoTotal .= " colaboracao.codCategoriaEvento = '$categoria_atual' and ";
}

if ($tipo_atual)
{
	$condicaoTotal .= " colaboracao.codTipoEvento = '$tipo_atual' and ";
}

if ($condicaoTotal)
{
	$condicaoTotal = substr($condicaoTotal, 0, -4);
}

if ($condicaoTotal == '') { $condicaoTotal = 1; }

$consulta = $connection->query("SHOW TABLES");
$tabelas = array('colaboracao','arquivos','avaliacao','comentario','estatistica','historicocolaboracoes','multimidia','videos');

// !!!QUEBRAR O SEARCH EM VARIOS STRINGS COM %%%
$sql = "SELECT DISTINCT colaboracao.codColaboracao
        FROM colaboracao
		INNER JOIN categoriaevento ON colaboracao.codCategoriaEvento = categoriaevento.codCategoriaEvento
		LEFT JOIN tipoevento ON colaboracao.codTipoEvento = tipoevento.codTipoEvento
		INNER JOIN palavraschavecolaboracoes ON palavraschavecolaboracoes.codColaboracao = colaboracao.codColaboracao
		INNER JOIN palavraschave ON palavraschave.codPalavraChave = palavraschavecolaboracoes.codPalavraChave
		WHERE ((descPalavraChave LIKE '%$search%') or (desCategoriaEvento LIKE '%$search%') or (desTipoEvento LIKE '%$search%')) and ($condicaoTotal) UNION ";

for ($i = 0; $i < 8; ++$i)
{
	$consulta2 = $connection->query("SHOW COLUMNS FROM $tabelas[$i]");
	while ($colunas = $consulta2->fetch_array())
	{
		$sql .=	"SELECT $tabelas[$i].codColaboracao FROM " . $tabelas[$i];
		if ($tabelas[$i] != 'colaboracao')
			$sql .=	" INNER JOIN colaboracao ON (colaboracao.codColaboracao = $tabelas[$i].codColaboracao) ";
		$sql .=	" WHERE ( " . $tabelas[$i] . "." . $colunas[0] . " LIKE '%" . $search . "%' ) and ($condicaoTotal) UNION ";
	}
}

$sql = substr($sql, 0, -6);
die($sql);
$consulta3 = $connection->query($sql);
$resposta = '';
while ($row = $consulta3->fetch_array()) { $resposta .= $row[0] . "-"; }

echo substr($resposta, 0, -1);