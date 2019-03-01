<?php
    session_start();
    header('content-type: text/html; charset=utf-8');
    require("../phpsqlinfo_dbinfo.php");
    require("cabecalho.php");
	if(!empty($_SESSION['user_admin_'.$link_inicial]) && !empty($_SESSION['pass_admin_'.$link_inicial]))
	{
		header("location: admin_tool.php");
	}
	else
	{
?>
			<div id="content-box">
				<div id="element-box" class="login">
					<div class="m wbg">
						<h1>Login - ClickOnMap</h1>
								
						<div id="section-box">
							<div class="m">
								<form action="autentica_admin.php" method="post" id="form-login">
									<fieldset class="loginform">
									<label id="mod-login-username-lbl" for="mod-login-username">Email</label>
									<input name="login" id="mod-login-username" type="text" class="inputbox" size="15">

									<label id="mod-login-password-lbl" for="mod-login-password">Senha</label>
									<input name="senha" id="mod-login-password" type="password" class="inputbox" size="15">

									<div class="button-holder">
										<div class="button1">
											<div class="next">
												<a href="#" onclick="document.getElementById('form-login').submit();">Entrar</a>
											</div>
										</div>
									</div>
								</form>
								
							</div>
						</div>
					
						<p>Faça o Login para ter acesso à área administrativa do site.</p>
						<p><a href="../index.php">Ir para o site.</a></p>
						<div id="lock"></div>
					</div>
				</div>	
			</div>
<?php
		require("rodape.php");
	}