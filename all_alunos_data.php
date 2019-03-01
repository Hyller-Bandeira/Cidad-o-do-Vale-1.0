<?php require 'phpsqlinfo_dbinfo.php'; ?>

<!DOCTYPE html>
<html>
	<head>
		<title><?php echo $nomePagina . $nome_site; ?> - ClickOnMap</title>
		<meta charset='utf-8'/>
		<link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
	</head>

	<body>
		<div align = 'center'>
			<h1>Tabela com Todas as Colaborações</h1>
			<hr>
			<b>Para Imprimir ou Salvar como PDF, segure Ctrl e aperte P (Crtl+P)</b>
			<hr>
			<br>
		</div>
		<div>
			<?php
			    session_start();
				/**
					* Gera uma tabela HTML com os registros do resultado de uma consulta SQL
					* @author Rafael Wendel Pinheiro
					* @param ResultSet $rs resultado de uma consulta sql
					* @param Array $headers Array com os cabeçalhos da tabela
					* @return void
				*/

				/* Conecta com o banco de dados */
				require 'phpsqlinfo_dbinfo.php';

				/* Executa a query */
				$rs = $connection->query("SELECT codColaboracao, desTituloAssunto, desColaboracao, datahoraCriacao, codCategoriaEvento, codTipoEvento, dataHoraOcorrencia, numLatitude, numLongitude, tipoStatus, desJustificativa, zoom
				                          FROM colaboracao ORDER BY codColaboracao");
				$headers = array('ID',
				'Titulo',
				'Descrição',
				'Data e Hora da Criacao',
				'Categoria do Evento',
				'Tipo do Evento',
				'Data e Hora da Ocorrencia',
				'Latitude',
				'Longitude',
				'Status',
				'Justificativa',
                'Ordem'); //Respeite a ordem do select (id, nome, cpf)

				/* Chama a função */
				geraTabela($rs, $headers, $connection, $link_inicial);
			?>


			<?php
				function geraTabela($rs, $headers, $connection, $link_inicial)
				{
					$s = "<table id='tabela' class='tabela' cellspacing='2' cellpadding='2' border='2'  style='width: 90%; text-align:center;' align='center'>";
					$s .= "<tr class='titulo'>";
					foreach ($headers as $header)
					{
						$s .=  "<th class='titulocelula'>$header</th>";
					}

					$s .= "</tr>";
					while ($row = $rs->fetch_object())
					{
						$s .= "<tr  class='linha'>";
						$x = 0;
						foreach ($row as $data)
						{
							if ($x == 4)
							{
								$query = "SELECT desCategoriaEvento FROM categoriaevento WHERE codCategoriaEvento = '$data' " ;
								$result = $connection->query($query);
								$row = @$result->fetch_assoc();
								$temp = $row['desCategoriaEvento'];
								$s .=  "<td  class='linhacelula'>$temp</td>";
							}
							else if ($x == 5)
							{
								$query = "SELECT desTipoEvento FROM tipoevento WHERE codTipoEvento = '$data' " ;
								$result = $connection->query($query);
								$row = @$result->fetch_assoc();
								$temp = $row['desTipoEvento'];
								$s .= "<td class='linhacelula'>$temp</td>";
							}
							//else if ($x == 6) $temp = '';
                            else if ($x == 3 || $x == 6)
                            {
                                $s .= "<td class='linhacelula'>".date('d/m/Y H:i:s', strtotime($data))."</td>";
                            }
							else if ($x == 9)
							{
								if ($data == "e" or $data == "E")
									$s .= "<td class='linhacelula'>Em Avaliação</td>";
								else
									$s .= "<td class='linhacelula'>Aprovada</td>";
							}
							else if ($x == 12 || $x == 13) continue;
							else $s .= "<td class='linhacelula' style='max-width:400px; overflow: auto;'>$data</td>";
							$x = $x+1;
						}

						$x = 0;
						$s .= "</tr>";
					}

					$s .= "</table>";
					echo $s;
					$_SESSION['tabela_'.$link_inicial] = $s;
				}
			?>
		</div>
	</body>
</html>

