<?php
function user_data($id_usuario, $connection)
{
	$query = "SELECT codUsuario, nomPessoa, tipoUsuario, pontos, faixaEtaria, classeUsuario, dataCadastro, apelidoUsuario, tipoUsuario
			  FROM usuario
			  WHERE codUsuario='" . $id_usuario . "' OR apelidoUsuario='" . $id_usuario . "'";
	$result = $connection->query($query);
	if (!$result) { die('Invalid query: ' . $connection->error); }

	$arr = $result->fetch_array(MYSQLI_ASSOC);
	$nickname = $arr['apelidoUsuario'];
    $tipo_usuario = $arr['tipoUsuario'];
    if (substr($arr['nomPessoa'], 0, 7) == 'Anonimo'){
	    $agerange = ' - ';
    } else {
        $agerange = $arr['faixaEtaria'];
    }
	$regdate = $arr['dataCadastro'];
    $id_usuario = $arr['codUsuario'];

	$classcod = $arr['classeUsuario'];
	$query = "SELECT nomeClasse FROM classesdeusuarios WHERE codClasse=" . $classcod;
	$result = $connection->query($query);
	if (!$result) { die('Invalid query: ' . $connection->error); }

	$arr = $result->fetch_array(MYSQLI_ASSOC);
	$classf = $arr['nomeClasse'];

    $consulta_comum = "SELECT codUsuario, apelidoUsuario, nomeClasse, pontos
                        FROM usuario
                        INNER JOIN classesdeusuarios ON codClasse = classeUsuario
                        WHERE apelidoUsuario NOT LIKE '%Anonimo%' AND tipoUsuario != 'A'
                        ORDER BY pontos DESC, dataCadastro";

    $todos = $connection->query($consulta_comum);

    $posicao_usuario = 1;
    $rankpos = '';
    while($usuario = $todos->fetch_assoc()){
        if ($usuario['codUsuario'] == $id_usuario || $usuario['apelidoUsuario'] == $id_usuario) {
            $rankpos = $posicao_usuario;
            break;
        }
        $posicao_usuario++;
    }

	$query = "SELECT u.codUsuario, COUNT(h.codColaboracao) AS ncolab
			  FROM colaboracao h INNER JOIN usuario u ON h.codUsuario = u.codUsuario
			  GROUP BY h.codUsuario";
	$result = $connection->query($query);
	if (!$result) { die('Invalid query: ' . $connection->error); }
    $numcolab = 0;
	while ($row = $result->fetch_array(MYSQLI_NUM))
	{
		if ($row[0] == $id_usuario)
		{
			$numcolab = $row[1];
			break;
		}
	}

    $avaliacoes = $connection->query("SELECT codUsuario
                                      FROM avaliacao
                                      WHERE codUsuario=" . $id_usuario . "");

    $edicoes = $connection->query("SELECT codUsuario
                                      FROM historicocolaboracoes
                                      WHERE codUsuario=" . $id_usuario . "");

    $comentarios = $connection->query("SELECT codUsuario
                                      FROM comentario
                                      WHERE codUsuario=" . $id_usuario . "");

    $multimidias = $connection->query("SELECT codUsuario
                                      FROM arquivos
                                      UNION
                                      SELECT codUsuario
                                      FROM multimidia
                                      UNION
                                      SELECT codUsuario
                                      FROM videos
                                      WHERE codUsuario=" . $id_usuario . "");

	return (object)array ('nickname' => $nickname, 'agerange' => $agerange, 'rankpos' => $rankpos,
				  'classf' => $classf, 'numcolab' => $numcolab, 'regdate' => $regdate,
                  'tipo_usuario' => $tipo_usuario, 'num_avaliacao' => $avaliacoes->num_rows, 'num_edicao' => $edicoes->num_rows,
                  'num_comentario' => $comentarios->num_rows, 'num_multimidia' => $multimidias->num_rows);
}

function create_colab_table($connection, $link_inicial)
{
	//require 'phpsqlinfo_dbinfo.php';
	$userid = $_GET["uid"];

    //Se userid for apelido substitui por codUsuario
    $query = "SELECT *
			  FROM usuario
			  WHERE codUsuario='" . $userid . "' OR apelidoUsuario='" . $userid . "'";
    $result = $connection->query($query);
    $row = $result->fetch_array(MYSQLI_ASSOC);
    $userid = $row['codUsuario'];

	$query = "SELECT desTituloAssunto, desColaboracao, datahoraCriacao,codColaboracao
			  FROM colaboracao
			  WHERE tipoStatus <> 'R' AND codUsuario = " . $userid . "
			  ORDER BY datahoraCriacao DESC
			  LIMIT 0 , 5";

	$result = $connection->query($query);

	echo("<a href='historico_colaboracoes_usuario.php?id=". $_SESSION["code_user_".$link_inicial] ."' target='_blank' style='text-decoration:none;'>
			<table class='hor-minimalist-b' style='width:100%;'>
				<thead>
					<tr>
						<th scope='col'>Título</th>
						<th scope='col'>Descrição</th>
						<th scope='col'>Data</th>
					</tr>
				</thead><tbody>");

	$temp_0 = array();
	while ($row = $result->fetch_array(MYSQLI_NUM))
	{
		$html_temp = "<tr><td>" . substr($row[0], 0, 16);
		$temp_0 = $row[0];
		if (count($temp_0) == 15) $html_temp .= "...";
		else $html_temp .= "";

		$html_temp .= "</td><td>".substr($row[1], 0, 26);
		$temp_1 = $row[1];
		if (count($temp_0) == 25) $html_temp .= "...";
		else $html_temp .= "";

		$html_temp .= "</td><td>" . date('d/m/Y', strtotime($row[2])) . "</td></tr>";
		echo ($html_temp);
	}
	echo("</tbody></table></a><br><br>");
}

//Verifica se selo esta ativo
function isActiveSelo($idSelo, $connection)
{
    $query = "SELECT seloAtivo
			  FROM selosconquistas
			  WHERE idSelo=" . $idSelo . "  ";

    $result = $connection->query($query);
    $row = $result->fetch_array(MYSQLI_NUM);
    return $row[0];
}

//Verifica se usuario leu tutorial
function leuTutorial($id_usuario, $connection, $tempo_minimo_leitura_tutorial, $num_minimo_pagina_tutorial)
{
    $query = "SELECT paginaTutorial, MAX(dataVisualizacao) as dataVisualizacao
              FROM usuariotutorial
			  WHERE codUsuario=" . $id_usuario . " OR apelidoUsuario = " . $id_usuario . "
			  GROUP BY paginaTutorial
			  ORDER BY dataVisualizacao ASC";

    $result = $connection->query($query);

    if (!$result) {
        return false;
    }

    if ($result->num_rows < $num_minimo_pagina_tutorial)
        return false;

    $menor_data = $result->fetch_array();
    $maior_data = $menor_data;

    while ($row = $result->fetch_array()){
        $maior_data = $row;
    }

    // Calcula a diferença em segundos entre as datas
    $diferenca = strtotime($maior_data['dataVisualizacao']) - strtotime($menor_data['dataVisualizacao']);

    if ($diferenca < $tempo_minimo_leitura_tutorial) {
        return false;
    }

    return true;
}