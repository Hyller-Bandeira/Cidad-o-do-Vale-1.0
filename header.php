<header>
	<div id="div_top">
        <div style="text-align: center;margin-bottom: -28px;">
            <!--<a href="http://www.ufv.br/" target="_blank" title="Universidade Federal de Viçosa">
                <img style="width: 28px;" src="imagens/ufv.gif">
                <span style="color: rgb(255, 255, 255); font-size: 11px;">Universidade Federal de Viçosa</span>
            </a>-->
        </div>
		<div id="div_centro_top" style="height:auto">
            <br/>
			<a href="inicio.php" onclick="ga('send', 'event', 'Clique', 'Link', 'Logo - Topo');"><img  src='imagens/logo.png' class='left' align="left" style='border-width: 0px; height: 100%'/></a>
            <?php if (!empty($_SESSION['user_'.$link_inicial]) && !empty($_SESSION['pass_'.$link_inicial])) :
                $nomes = explode(' ', $_SESSION['name_user_'.$link_inicial]);
            ?>
                <div class="row">
                    <div class="col-md-6" style="text-align: right; margin-top: 25px;">
                        <span class="text" style="color:#ffffff;"> Seja bem vindo, <a style="color: rgb(255, 152, 8); font-weight: bold;" href='user_profile.php?uid=<?php echo $_SESSION['code_user_'.$link_inicial]; ?>' title='Ver perfil'  onclick="ga('send', 'event', 'Clique', 'Link', 'Nome Boas Vindas');"><?php echo $nomes[0]; ?></a></span>
                    </div>
                    <div class="col-md-6" style="text-align: right; margin-top: 20px;">
                        <form name="form" action="sair.php" method="post">
                            <a href='user_profile.php?uid=<?php echo $_SESSION['code_user_'.$link_inicial]; ?>' title='Ver perfil'>
                                <button type="button" class="btn btn-warning active" onclick="ga('send', 'event', 'Clique', 'Botão', 'Ver Perfil');" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-user"></span> <strong> Ver Perfil</strong></button>
                            </a>
                            <button type="submit" class="btn btn-danger" style="margin-right: 20px; margin-left: 10px;" onclick="ga('send', 'event', 'Clique', 'Botão', 'Sair');" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-log-out"></span> <strong> Sair</strong></button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="row">
                    <div class="col-md-6" style="text-align: right; margin-top: 50px;">
                        <button type="button" class="btn btn-warning active" data-toggle="modal" data-target="#modal-login" onclick="ga('send', 'event', 'Clique', 'Botão', 'Entrar (Abrir Modal)');" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-log-in"></span> <strong> Entrar</strong></button>
                        <a href="registro.php"><button type="button" class="btn btn-warning active" onclick="ga('send', 'event', 'Clique', 'Botão', 'Cadastrar');" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-plus-sign"></span> <strong> Cadastrar</strong></button></a>
                    </div>
                </div>
            <?php endif; ?>
		</div>
	</div>

    <!-- Modal -->
    <div id="modal-login" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="ga('send', 'event', 'Clique', 'Fechar', 'Modal Login');">&times;</button>
                    <h3 class="modal-title">Acesse sua conta</h3>
                </div>
                <div class="modal-body">
                    <?php  if($login_facebook == '1' || $login_google == '1' || $login_anonimo == '1') : ?>
                        <?php
                            $num_login = 0;
                            if ($login_facebook == '1') {
                                $num_login++;
                            }
                            if ($login_google == '1') {
                                $num_login++;
                            }
                            if ($login_anonimo == '1') {
                                $num_login++;
                            }

                            require 'phpsqlinfo_dbinfo.php';
                            $resultado = $connection->query("SELECT * FROM usuario");
                            $count = $resultado->num_rows + 1;
                        ?>
                        <div class="row" style="margin: 0px 0px 10px;">
                            <div class="col-md-12" style="border-radius: 5px; padding: 5px; color: rgb(125, 125, 125); font-size: 14px; background-color: rgb(251, 251, 251);text-align: center;">
                                Entrar com:
                            </div>
                        </div>
                        <div class="row col-md-<?php echo 4*$num_login; ?>" style="padding: 0 0 10px 0; border-bottom: 1px solid rgb(217, 217, 217); margin: 0 auto;float:none;">
                            <?php  if($login_facebook == '1') : ?>
                                <div class="col-md-<?php echo 12/$num_login; ?>" style="margin: 10px 0px;">
                                    <a href="valida_face.php" alt="Entrar com Facebook" class="btn btn-block btn-social btn-facebook" onclick="ga('send', 'event', 'Clique', 'Botão', 'Login Facebook (Modal)');">
                                        <i class="fa fa-facebook"></i> Facebook
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php  if($login_google == '1') : ?>
                                <div class="col-md-<?php echo 12/$num_login; ?>" style="margin: 10px 0px;">
                                    <a href="valida_google.php" alt="Entrar com Google+" class="btn btn-block btn-social btn-google-plus" onclick="ga('send', 'event', 'Clique', 'Botão', 'Login Google+ (Modal)');">
                                        <i class="fa fa-google-plus"></i> Google+
                                    </a>
                                </div>
                            <?php endif; ?>
                            <?php  if($login_anonimo == '1') : ?>
                                <div class="col-md-<?php echo 12/$num_login; ?>" style="margin: 10px 0px;">
                                    <a href='autentica_outros.php?login=anonimo<?php echo $count;?>@anonimo.com.br&senha=anonimo123456&apelidoUsuario=Anonimo<?php echo $count;?>&faixaEtaria=26 - 64' alt='Entrar Anonimo' class="btn btn-block btn-social btn-github"  onclick="ga('send', 'event', 'Clique', 'Botão', 'Login Anônimo (Modal)');">
                                        <i class="fa fa-user fa"></i> Anônimo
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                    <div class="row" style="margin: 20px 0;">
                        <form name="form" action="autentica.php" method="post">
                            <div class="form-group col-md-12">
                                <label for="login"><small>Email/Apelido</small></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-envelope" aria-hidden="true"></i></span>
                                    <input type="text" class="form-control" id="login" name="login" required="required">
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="senha"><small>Senha</small></label>
                                <div class="input-group">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-lg" aria-hidden="true"></i></span>
                                    <input type="password" class="form-control" id="senha" name="senha" required="required">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <a href='recupera_senha.php'><span class="glyphicon glyphicon-info-sign" onclick="ga('send', 'event', 'Clique', 'Link', 'Esqueci minha senha (Modal)');"></span><small style="font-size: 70%;"> Esqueci minha senha</small></a>
                            </div>
                            <div class="col-md-6" style="text-align: right;">
                                <button type="submit" class="btn btn-success active"><span class="glyphicon glyphicon-log-in" onclick="ga('send', 'event', 'Clique', 'Botão', 'Entrar (Modal)');"></span> Entrar</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer" style="background-color: rgb(239, 239, 239);">
                    <div class="row" style="margin: 0px 0px 10px;">
                        <div class="col-md-12" style="border-radius: 5px; padding: 5px; color: rgb(107, 107, 107); font-size: 14px; text-align: center;">
                            Ainda não sou cadastrado. <strong><a href="registro.php"><button type="button" class="btn btn-warning active" onclick="ga('send', 'event', 'Clique', 'Botão', 'Quero me cadastrar (Modal)');" style="background-color:rgb(247, 68, 69)">Quero me cadastrar!</button></a></strong>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

	<div id="div_menu">
		<div class="centro buttons">
			<?php
				//MENU
				$resultado = $connection->query("SELECT * FROM menu WHERE statusItem = 0 ORDER BY ordemItem ASC");
				$numItens = $resultado->num_rows;
				$i = 1;
				$expaux = explode("/", $_SERVER['PHP_SELF']);
				$pagina = end($expaux);

				$nomePagina = "";
				$add_css = "";

				while($itemMenu = $resultado->fetch_array(MYSQLI_ASSOC))
				{
                    $logado = (!empty($_SESSION['user_'.$link_inicial]) && !empty($_SESSION['pass_'.$link_inicial]));
                    //Se nao estiver logado nao exibe item de menu Ranking
                    if ((!$logado && $itemMenu['nomeItem'] != 'Ranking') || $logado) {
                        $add_css = "button big";
                        if ($i == 1) $add_css .= " left";
                        else if ($i == $numItens)
                        {
                            $add_css .= " right";
                            ?> <div style='border-left: 1px solid white; display: inline; margin-left: -5px;'></div> <?php
                        }
                        else
                        {
                            // $add_css .= " middle";
                            ?> <div style='width: 0px; height: 100%; border-left: 1px solid white; display: inline; margin-left: -5px;'></div> <?php
                        }
                        if ($itemMenu['enderecoItem'] == $pagina) $add_css .= " ativo";
                        ?>
                        <a href="<?php echo $itemMenu['enderecoItem'];?>.php" id="<?php echo $itemMenu['nomeItem'];?>" name="<?php echo $itemMenu['nomeItem'];?>" class="<?php echo $add_css;?>"  onclick="ga('send', 'event', 'Clique', 'Menu', '<?php echo $itemMenu['nomeItem'];?>');"><?php echo $itemMenu['nomeItem'];?></a>
                        <?php
                        ++$i;
                    }
				}
			?>
		</div>
	</div>
</header>