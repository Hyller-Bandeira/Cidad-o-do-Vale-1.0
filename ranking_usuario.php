<?php
    require 'phpsqlinfo_dbinfo.php';
	session_start();
	header('content-type: text/html; charset=utf-8');
	require 'headtag.php';

    $itens_por_pagina = 15;
    $pagina_atual = (!empty($_GET['pagina']) ? intval($_GET['pagina']) : 0);

    $consulta_comum = "SELECT codUsuario, apelidoUsuario, nomeClasse, pontos
                        FROM usuario
                        INNER JOIN classesdeusuarios ON codClasse = classeUsuario
                        WHERE apelidoUsuario NOT LIKE '%Anonimo%' AND tipoUsuario != 'A'
                        ORDER BY pontos DESC, dataCadastro";

    $consulta = $connection->query($consulta_comum . " LIMIT ".$itens_por_pagina." OFFSET ".$itens_por_pagina*$pagina_atual."");

    $row = $consulta->fetch_assoc();
    $num = $consulta->num_rows;

    $todos = $connection->query($consulta_comum);
    $num_total = $todos->num_rows;

    $num_paginas = ceil($num_total/$itens_por_pagina);

    if ($pagina_atual > $num_paginas) {
        $pagina_atual = 0;
    }

    $info_usuario = '';
    $posicao_usuario = 1;
    while($usuario = $todos->fetch_assoc()){
        if ($usuario['codUsuario'] == $_SESSION['code_user_'.$link_inicial]) {
            $info_usuario = $usuario;
            break;
        }
        $posicao_usuario++;
    }

?>

<!DOCTYPE html>
<html>
	<?php
		createHead(
			array("title" => $nomePagina . $nome_site,
			"required" => array("src/class.eyedatagrid.inc.php")));
	?>

<body>

	<?php require 'header.php'; ?>

    <?php
		if(!isset($_SESSION['user_'.$link_inicial]) && !isset($_SESSION['pass_'.$link_inicial]))
		{
			echo "<script>window.location='registro'; bootbox.alert('Para visualizar o ranking você deve possuir um cadastro e estar logado no sistema!');</script>";
		}
		else
		{
	?>

	<div class="div_centro" style="min-height: 600px;">

        <div class="row">
            <?php if(strlen(substr($_SESSION['user_'.$link_inicial],0, 7) == 'anonimo')) : ?>
            <div class="alert alert-warning col-lg-12 text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                Usuários <strong>anônimos</strong> não são exibidos no ranking!
            </div>
            <?php endif; ?>

  			<div class="col-lg-12">
  				<?php if($num > 0) : ?>
                    <table class="table table-striped table-bordered table-hover table-responsive">
                        <thead>
                            <tr class="text-center" style="background-color: rgb(236, 236, 236);">
                                <td><strong>Posição</strong></td>
                                <td><strong>Apelido</strong></td>
                                <td><strong>Tipo de Colaborador</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = ($itens_por_pagina*$pagina_atual)+1;
                            do{ ?>
                                <tr class="text-center">
                                    <td><?php echo $i; ?></td>
                                    <td><a href="user_profile.php?uid=<?php echo $row['apelidoUsuario']; ?>" title="Ver perfil" onclick="ga('send', 'event', 'Clique', 'Link', 'Ranking - Perfil de Usuário');"><?php echo $row['apelidoUsuario']; ?></a></td>
                                    <td><?php echo $row['nomeClasse']; ?></td>
                                </tr>
                            <?php
                            $i++;
                            } while($row = $consulta->fetch_assoc()); ?>
                        </tbody>
                    </table>
                    <?php if ($num_total > $itens_por_pagina) :?>
                        <nav class="text-center">
                          <ul class="pagination">
                            <li>
                              <a href="ranking_usuario.php?pagina=0" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                              </a>
                            </li>
                            <?php for($i=0; $i<$num_paginas; $i++): ?>
                                <li class="<?php echo ($pagina_atual == $i) ? 'active' : ''; ?>" ><a href="ranking_usuario.php?pagina=<?php echo $i; ?>"><?php echo $i+1; ?></a></li>
                            <?php endfor; ?>
                            <li>
                              <a href="ranking_usuario.php?pagina=<?php echo $num_paginas-1; ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                              </a>
                            </li>
                          </ul>
                        </nav>
                    <?php endif; ?>
                <?php endif; ?>
  			</div>
  		</div>

        <div class="row">
            <div class="col-lg-12">
                <?php if($info_usuario != '') : ?>
                    <table class="table table-bordered table-hover table-responsive">
                        <thead>
                        <tr class="text-center" style="background-color: rgb(236, 236, 236);">
                            <td><strong>Sua Posição</strong></td>
                            <td><strong>Seu Apelido</strong></td>
                            <td><strong>Sua Pontuação</strong></td>
                        </tr>
                        </thead>
                        <tbody>
                            <tr class="text-center">
                                <td><?php echo $posicao_usuario; ?></td>
                                <td><?php echo $info_usuario['apelidoUsuario']; ?></td>
                                <td><?php echo $info_usuario['pontos']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>


        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-6 text-center">
                <button type="button" class="btn btn-warning active" data-toggle="modal" data-target="#tabela-niveis" onclick="ga('send', 'event', 'Clique', 'Botão', 'Tabela de Níveis');"><strong>Tabela de Níveis</strong></button>
            </div>
            <div class="col-md-6 text-center">
                <button type="button" class="btn btn-warning active" data-toggle="modal" data-target="#tabela-pontos" onclick="ga('send', 'event', 'Clique', 'Botão', 'Tabela de Pontos');"><strong>Tabela de Pontos</strong></button>
            </div>
        </div>
	</div>
    <?php include 'partials/rodape.php'; ?>

    <?php
            $consulta = $connection->query("SELECT *
                                            FROM classesdeusuarios
                                            ORDER BY ordemClasse");
    ?>

    <!-- Modal -->
    <div id="tabela-niveis" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="ga('send', 'event', 'Clique', 'Fechar', 'Modal Tabela de Níveis');">&times;</button>
                    <h4 class="modal-title">Tabela de Níveis</h4>
                </div>
                <div class="modal-body">
                    <table class="table table-striped table-hover table-responsive">
                        <tbody>
                        <?php while($row = $consulta->fetch_assoc()) :?>
                            <tr class="text-center">
                                <td><?php echo $row['nomeClasse']; ?></td>
                                <td><?php echo $row['desClasse']; ?></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="ga('send', 'event', 'Clique', 'Botão', 'Fechar - Modal Tabela de Níveis');">Fechar</button>
                </div>
            </div>

        </div>
    </div>


    <!-- Modal -->
    <div id="tabela-pontos" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" onclick="ga('send', 'event', 'Clique', 'Fechar', 'Modal Tabela de Pontos');">&times;</button>
                    <h4 class="modal-title">Tabela de Pontos</h4>
                </div>
                <div class="modal-body" style="max-height: 400px;">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-hover table-responsive">
                                <tbody>
                                    <tr>
                                        <td class="text-left" style="padding: 10px;"><span style="padding: 0 20px;font-size: 130%;" class="glyphicon glyphicon-user"></span> Cadastrou-se no site</td>
                                        <td class="text-center" style="color: green; font-weight: bold; padding: 10px 0;">+5 pontos</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" style="padding: 10px;"><span style="padding: 0 20px;font-size: 130%;" class="glyphicon glyphicon-map-marker"></span> Realizou colaboração</td>
                                        <td class="text-center" style="color: green; font-weight: bold; padding: 10px 0;">+10 pontos</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" style="padding: 10px;"><span style="padding: 0 20px;font-size: 130%;" class="glyphicon glyphicon-comment"></span> Realizou comentário</td>
                                        <td class="text-center" style="color: green; font-weight: bold; padding: 10px 0;">+10 pontos</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" style="padding: 10px;"><span style="padding: 0 20px;font-size: 130%;" class="glyphicon glyphicon-check"></span> Avaliou colaboração</td>
                                        <td class="text-center" style="color: green; font-weight: bold; padding: 10px 0;">+01 ponto</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" style="padding: 10px;"><span style="padding: 0 20px;font-size: 130%;" class="glyphicon glyphicon-cloud-upload"></span> Enviou arquivo ou imagem</td>
                                        <td class="text-center" style="color: green; font-weight: bold; padding: 10px 0;">+05 pontos</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" style="padding: 10px;"><span style="padding: 0 20px;font-size: 130%;" class="glyphicon glyphicon-edit"></span> Contribui com edição</td>
                                        <td class="text-center" style="color: green; font-weight: bold; padding: 10px 0;">+01 ponto</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" style="padding: 10px;"><span style="padding: 0 20px;font-size: 130%;" class="glyphicon glyphicon-remove"></span> Colaboração rejeitada</td>
                                        <td class="text-center" style="color: red; font-weight: bold; padding: 10px 0;">-15 pontos</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" style="padding: 10px;"><span style="padding: 0 20px;font-size: 130%;" class="fa fa-thumbs-down"></span> Colaboração maliciossa</td>
                                        <td class="text-center" style="color: red; font-weight: bold; padding: 10px 0;">-50 pontos</td>
                                    </tr>
                                    <tr>
                                        <td class="text-left" style="padding: 10px;"><span style="padding: 0 20px;font-size: 130%;" class="fa fa-ban"></span> Colaboração criminosa</td>
                                        <td class="text-center" style="color: red; font-weight: bold; padding: 10px 0;">BANIDO</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal" onclick="ga('send', 'event', 'Clique', 'Botão', 'Fechar - Modal Tabela de Pontos');">Fechar</button>
                </div>
            </div>

        </div>
    </div>


</body>
</html>
<?php
		}