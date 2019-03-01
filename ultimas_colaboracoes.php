<?php
require 'phpsqlinfo_dbinfo.php';
$query = "SELECT desTituloAssunto, desColaboracao, datahoraCriacao,codColaboracao
		  FROM colaboracao
		  WHERE tipoStatus != 'R'
		  ORDER BY datahoraCriacao DESC
		  LIMIT 5";
$result = $connection->query($query);

//Se tem colaboracoes
if ($result->num_rows > 0){

    echo("<label class='text'><b>Últimas colaborações</b></label><br><br>
            <table class='hor-minimalist-b'>
                <thead>
                    <tr>
                        <th scope='col'>Título</th>
                        <th scope='col'>Descrição</th>
                        <th scope='col' style='text-align:center'>Data</th>
                    </tr>
                </thead><tbody>");

    $temp_0 = array();
    while ($row = $result->fetch_array(MYSQLI_NUM))
    {
        $titulo = mb_substr($row[0], 0, 18);
        $descricao = mb_substr($row[1], 0, 28);
        $html_temp = "<tr onclick='enviar(".$row[3].")' ><td>".$titulo;
        if (strlen($titulo) >= 15) {
            $html_temp .= "...";
        }

        $html_temp .= "</td><td>".$descricao;
        if (strlen($descricao) >= 26) {
            $html_temp .= "...";
        }

        $html_temp .= "</td><td style='text-align:center'>" . date('d/m/Y', strtotime($row[2])) . "</td></tr>";
        echo ($html_temp);
    }
    echo("</tbody></table>");
}