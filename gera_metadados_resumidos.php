<?php
require 'phpsqlinfo_dbinfo.php';

$ids = '';
if(isset($_GET["id"])) $ids = $_GET["id"];//Código da colaboração recebida pela função

$listaCodColaboracao = explode("-", $ids);
$resultado = "";

echo "<colaboracao>";

for ($i = 0; $i < count($listaCodColaboracao); ++$i)
{
    //Tabela: COLABORACAO: Consulta para pegar todos os dados da colaboração
    $consulta = $connection->query("SELECT codColaboracao, desTituloAssunto, datahoraCriacao, desTipoEvento, desCategoriaEvento
							 FROM  colaboracao
							 INNER JOIN categoriaevento ON (categoriaevento.codCategoriaEvento = colaboracao.codCategoriaEvento)
							 LEFT JOIN tipoevento ON (tipoevento.codTipoEvento = colaboracao.codTipoEvento)
							 WHERE codColaboracao = '$listaCodColaboracao[$i]' ");

    if (!$consulta)
    {
        die('Invalid query: ' . $connection->error);
    }

    while ($linha = $consulta->fetch_assoc())
    {
        echo '<marker ';
        echo 'codColaboracao = "' . $linha['codColaboracao'] . '" ';
        echo 'desTituloAssunto = "' . $linha['desTituloAssunto'] . '" ';
        echo 'desCategoriaEvento = "' . $linha['desCategoriaEvento'] . '" ';
        if (!empty($linha['desCategoriaEvento'])) {
            echo 'desTipoEvento = "' . $linha['desTipoEvento'] . '" ';
        }

        echo 'datahoraCriacao = "' . date('d/m/Y - H:i:s', strtotime($linha['datahoraCriacao'])) . '" ';
        echo '/>';
    }
}
echo '</colaboracao>';