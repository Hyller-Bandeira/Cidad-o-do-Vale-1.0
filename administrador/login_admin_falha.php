<?php
require("../phpsqlinfo_dbinfo.php");
require('cabecalho.php');

session_start();
	if(isset($_SESSION['user_admin_'.$link_inicial]) && isset($_SESSION['pass_admin_'.$link_inicial])){
		header("location: admin_tool.php");
	}else{
?>
			<div id="content-box">
				<div id="conteudo" style="margin-top: 50px;">
					<center>
						<span style="color: #cf9036;"><font size="4px">Login não efetuado!</font></span>
						<br>
						<span style="color: #cf9036;"><font size="4px">Email ou senha inválidos</font></span>
						<br><br><br>
						<a href="index.php"><img src="images/voltar.png" width="120px"></a>
					</center><br>
				</div>
			</div>
<?php  			require 'rodape.php';
} ?>