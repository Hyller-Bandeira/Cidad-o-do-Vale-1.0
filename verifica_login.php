<?php
	require 'phpsqlinfo_dbinfo.php';

	$Email_post = '';
	$Senha_post = '';

	if(isset($_POST["Email"])) $Email_post = $_POST["Email"];
	if(isset($_POST["Senha"])) $Senha_post = $_POST["Senha"];

	$teste = 0;
	$query = "SELECT * FROM usuario WHERE 1";
	$result = $connection->query($query);
	if (!$result) { die('Invalid query: ' . $connection->error); }

	/* Enquanto houver dados na tabela para serem mostrados sera executado tudo que esta dentro do while */
	while($escrever = $result->fetch_array())
	{
		if ($Email_post == $escrever['Email'])
		{
			$teste = 1;
			if ($Senha_post == $escrever['Senha'])
			{
				echo "Login Efetuado com Sucesso";
				break;
			}
			else
			{
				echo "Email ou Senha errada";
				break;
			}
		}
	}

	if ($teste == 0)
	{
		echo "Email ou Senha errada";
	}
?>

<form name="form" action="registro" method="post">
    <p style="margin-left: 300">

		<input class="button" type="submit" value="Voltar"/>
	</p>
</form>