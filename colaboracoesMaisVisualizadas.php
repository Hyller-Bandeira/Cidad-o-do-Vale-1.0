<?php
	require 'phpsqlinfo_dbinfo.php';

    $resultado = $connection->query("SELECT c.codColaboracao, c.desTituloAssunto, c.desColaboracao, c.datahoraCriacao, e.qtdVisualizacao
                                    FROM estatistica as e
                                    INNER JOIN colaboracao as c ON e.codColaboracao = c.codColaboracao
                                    WHERE tipoStatus <> 'R'
                                    GROUP BY c.codColaboracao, c.desTituloAssunto, c.desColaboracao, c.datahoraCriacao
                                    ORDER BY e.qtdVisualizacao DESC, c.desTituloAssunto, c.desColaboracao, c.datahoraCriacao
                                    LIMIT 5");

//Se tem colaboracoes visualizadas
if ($resultado->num_rows > 0){

	echo("<label class='text'><b>Colaboraçoes mais vistas</b></label><br><br>
		<table class='hor-minimalist-b'>
			<thead>
				<tr>
					<th scope='col'>Título</th>
					<th scope='col'>Descrição</th>
					<th scope='col' style='text-align:center'>Visualizações</th>
				</tr>
			</thead><tbody>");

    while ($linha = $resultado->fetch_assoc())
    {
        $titulo = mb_substr($linha['desTituloAssunto'], 0, 18);
        $descricao = mb_substr($linha['desColaboracao'], 0, 28);
        $html_temp = "<tr onclick='enviar(".$linha['codColaboracao'].")' ><td>".$titulo;
        if (strlen($titulo) >= 15) {
            $html_temp .= "...";
        }

        $html_temp .= "</td><td>".$descricao;
        if (strlen($descricao) >= 26) {
            $html_temp .= "...";
        }

        $html_temp .= "</td><td style='text-align:center'>".$linha['qtdVisualizacao']."</td></tr>";
        echo ($html_temp);
    }
	echo("</tbody></table>");
}