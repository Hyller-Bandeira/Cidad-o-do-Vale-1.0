<?php
	require 'phpsqlinfo_dbinfo.php';

	function atualizaClasse($codUsuario, $connection)
	{
		$consulta = $connection->query("SELECT * FROM usuario WHERE codUsuario = '$codUsuario'  " );

		if($row = $consulta->fetch_assoc())
		{
			$resultado = $row['pontos'];
			if ($resultado < 0) updateClassUsuario(1, $codUsuario, $connection);
			else if ( $resultado >= 0 && $resultado < 100) updateClassUsuario(2, $codUsuario, $connection);
			else if ( $resultado >= 100 && $resultado < 249) updateClassUsuario(3, $codUsuario, $connection);
			else if ( $resultado >= 250 && $resultado < 449) updateClassUsuario(4, $codUsuario, $connection);
			else if ( $resultado >= 500 && $resultado < 799) updateClassUsuario(5, $codUsuario, $connection);
			else updateClassUsuario(6, $codUsuario, $connection);
		}
	}

	function updateClassUsuario($valor, $codUsuario, $connection)
	{
		$result = $connection->query("UPDATE usuario SET classeUsuario = '$valor'
							   WHERE codUsuario = '$codUsuario' ");
		if (!$result) die('Update errado: ' . $connection->error);
	}