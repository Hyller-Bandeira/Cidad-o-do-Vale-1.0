<?php
	session_start();
	header('content-type: text/html; charset=utf-8');
	require 'phpsqlinfo_dbinfo.php';
	require 'headtag.php';
	require 'dados_usuario.php';

    $id_usuario = (isset($_GET['uid']) ? $_GET['uid'] : '');

	if(!isset($_SESSION['user_'.$link_inicial]) && !isset($_SESSION['pass_'.$link_inicial])) :
		header("location: dados_historicos.php");
	else :
?>

<!DOCTYPE html>
<html>
	<?php
		createHead(array("title" => $nomePagina . $nome_site,
					"css" => array("jsor-jcarousel/skins/tango/skin.css"),
					"script" => array("src/jquery.min.js", "scripts/positioning.js")));
	?>
<body>
	<?php require 'header.php'; ?>

	<?php
		$data = user_data($id_usuario,$connection);
	?>
    <div class="div_centro row" style="min-height: 400px;">
        <div id='info-pessoal' class='font8' style='display: inline-block;float:left;width:45%;'>
            <h3>Informações Pessoais</h3>
            <hr />
            <div class="linha-info">
                <label>Apelido: <span id='user_name'><?php echo $data->nickname; ?></span></label>
            </div>
            <div class="linha-info">
                <label>Faixa etária: <span id='user_agerange'><?php echo $data->agerange; ?></span></label>
            </div>

            <?php if (!empty($data->rankpos)) :?>
            <div class="linha-info">
                <label>Posição no ranking: <span id='user_rankpos'><?php echo $data->rankpos; ?>º lugar</span></label>
            </div>
            <?php endif; ?>

            <div class="linha-info">
                <label>Classe do usuário: <span id='user_classf'><?php echo $data->classf; ?></span></label>
            </div>

            <div class="linha-info">
                <label>Número de colaborações realizadas: <span id='user_numcolab'><?php echo $data->numcolab; ?>
                        <?php if ($data->numcolab > 1) : ?> (<a href="historico_colaboracoes_usuario.php?id=<?php echo $_SESSION['code_user_'.$link_inicial];?>" target="_blank"  onclick="ga('send', 'event', 'Clique', 'Link', 'Ver todas colaborações (<?php echo $data->nickname; ?>)');">ver todas</a>)</span></label> <?php endif; ?>
            </div>

            <div class="linha-info">
                <label>Data do cadastro: <span id='user_regdate'><?php echo date('d/m/Y H:m', strtotime($data->regdate)); ?></span></label>
            </div>
        </div>
        <div id='selos-conquista' class='font8' style='display: inline-block;float:right;width:45%;'>
            <h3>Selos de conquistas</h3>
            <hr />

            <?php //Selos de 1, 2 e 3 colocados no ranking ?>
            <?php if(!empty($data->rankpos) && $data->rankpos <= 3): ?>
                <?php if ( isActiveSelo($data->rankpos+20, $connection) ) ://ids 21, 22 e 23 - verifica se esta ativo ?>
                    <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Posição no ranking de usuários - <?php echo $data->rankpos;?>º Lugar');"><img class="img-selo" src="images/selos/posicaoRanking<?php echo $data->rankpos;?>.png" title="Posição no ranking de usuários - <?php echo $data->rankpos;?>º Lugar"></a>
                <?php endif; ?>
            <?php endif; ?>

            <?php //Selo moderador ?>
            <?php if ( ($data->tipo_usuario == 'A' || $data->tipo_usuario == 'M') && isActiveSelo(8, $connection) ) : ?>
                <a href="selos.php"><img class="img-selo" src="images/selos/usuarioModerador.png" title="Usuário moderador ou administrador" onclick="ga('send', 'event', 'Clique', 'Selo', 'Usuário moderador ou administrador');"></a>
            <?php endif; ?>

            <?php //Selos de quantidade de colaborações realizadas?>
            <?php if ($data->numcolab >= $num_minimo_colaboracoes1 && $data->numcolab < $num_minimo_colaboracoes2 && isActiveSelo(4, $connection)) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Número de colaborações 1');"><img class="img-selo" src="images/selos/numeroDeColaboracoes1.png" title="<?php echo $data->numcolab.' colaboraç'.($data->numcolab == 1 ? 'ão' : 'ões');?>"></a>
            <?php elseif ($data->numcolab >= $num_minimo_colaboracoes2 && $data->numcolab < $num_minimo_colaboracoes3 && isActiveSelo(5, $connection)) : ?>
                    <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Número de colaborações 2');"><img class="img-selo" src="images/selos/numeroDeColaboracoes2.png" title="<?php echo $data->numcolab.' colaboraç'.($data->numcolab == 1 ? 'ão' : 'ões');?>"></a>
            <?php elseif ($data->numcolab >= $num_minimo_colaboracoes3 && $data->numcolab < $num_minimo_colaboracoes4 && isActiveSelo(6, $connection)) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Número de colaborações 3');"><img class="img-selo" src="images/selos/numeroDeColaboracoes3.png" title="<?php echo $data->numcolab.' colaboraç'.($data->numcolab == 1 ? 'ão' : 'ões');?>"></a>
            <?php elseif ($data->numcolab >= $num_minimo_colaboracoes4 && isActiveSelo(7, $connection)) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Número de colaborações 4');"><img class="img-selo" src="images/selos/numeroDeColaboracoes4.png" title="<?php echo $data->numcolab.' colaboraç'.($data->numcolab == 1 ? 'ão' : 'ões');?>"></a>
            <?php endif; ?>

            <?php //Selo usuario veterano para quem tem mais de x meses de cadastro ?>
            <?php
                $data_inicial = $data->regdate;
                $data_final = date('Y-m-d');

                // Calcula a diferença em segundos entre as datas
                $diferenca = strtotime($data_final) - strtotime($data_inicial);

                //Calcula a diferença em dias
                $dias = floor($diferenca / (60 * 60 * 24));
                if ($dias >= $tempo_minimo_usuario_veterano && isActiveSelo(3, $connection)) : ?> <!-- x meses de cadastro -->
                    <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Usuário Veterano');"><img class="img-selo" src="images/selos/usuarioVeterano.png" title="Possui mais de <?php echo $tempo_minimo_usuario_veterano/30; ?> meses de cadastro"></a>
                <?php endif; ?>

            <?php //Selos diploma?>
            <?php if (leuTutorial($id_usuario, $connection, $tempo_minimo_leitura_tutorial, $num_minimo_pagina_tutorial)): ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Usuário Consultou o Tutorial');"><img class="img-selo" src="images/selos/diploma.png" title="Usuário consultou o tutorial"></a>
            <?php endif; ?>

            <?php //Selos da classe do usuario?>
            <?php if ($data->classf == 'Colaborador Malicioso' && isActiveSelo(9, $connection)): ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Colaborador Malicioso');"><img class="img-selo" src="images/selos/colabordorMalicioso.png" title="Colaborador Malicioso"></a>

            <?php elseif ($data->classf == 'Colaborador Básico' && isActiveSelo(10, $connection)) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Colaborador Básico');"><img class="img-selo" src="images/selos/colaboradorBasico.png" title="Colaborador Básico"></a>

            <?php elseif ($data->classf == 'Colaborador Legal' && isActiveSelo(11, $connection)) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Colaborador Legal');"><img class="img-selo" src="images/selos/colaboradorLegal.png" title="Colaborador Legal"></a>

            <?php elseif ($data->classf == 'Colaborador Master' && isActiveSelo(12, $connection)) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Colaborador Master');"><img class="img-selo" src="images/selos/colaboradorMaster.png" title="Colaborador Master"></a>

            <?php elseif ($data->classf == 'Colaborador Experiente' && isActiveSelo(13, $connection)) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Colaborador Experiente');"><img class="img-selo" src="images/selos/colaboradorExperiente.png" title="Colaborador Experiente"></a>

            <?php elseif ($data->classf == 'Colaborador Especial' && isActiveSelo(14, $connection)) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Colaborador Especial');"><img class="img-selo" src="images/selos/colaboradorEspecial.png" title="Colaborador Especial"></a>
            <?php endif; ?>

            <?php //Selo usuario avaliador ?>
            <?php if ( $data->num_avaliacao >=  $num_minimo_avaliacoes && isActiveSelo(15, $connection) ) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Usuário Avaliador');"><img class="img-selo" src="images/selos/usuarioAvaliador.png" title="<?php echo $data->num_avaliacao.' avaliaç'.($data->num_avaliacao == 1 ? 'ão' : 'ões');?>"></a>
            <?php endif; ?>

            <?php //Selo usuario editor ?>
            <?php if ( $data->num_edicao >=  $num_minimo_edicoes && isActiveSelo(16, $connection) ) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Usuário Editor');"><img class="img-selo" src="images/selos/usuarioEditor.png" title="<?php echo $data->num_edicao.' ediç'.($data->num_edicao == 1 ? 'ão' : 'ões');?>"></a>
            <?php endif; ?>

            <?php //Selo usuario comunicativo ?>
            <?php if ( $data->num_comentario >=  $num_minimo_comentarios && isActiveSelo(17, $connection) ) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Usuário Comunicativo');"><img class="img-selo" src="images/selos/usuarioComunicativo.png" title="<?php echo $data->num_comentario.' comentário'.($data->num_comentario == 1 ? '' : 's');?>"></a>
            <?php endif; ?>

            <?php //Selo usuario multimidia ?>
            <?php if ( $data->num_multimidia >=  $num_minimo_multimidias && isActiveSelo(20, $connection) ) : ?>
                <a href="selos.php" onclick="ga('send', 'event', 'Clique', 'Selo', 'Usuário Multimídia');"><img class="img-selo" src="images/selos/usuarioMultimidia.png" title="<?php echo $data->num_multimidia.' envio'.($data->num_multimidia == 1 ? '' : 's').' de image'.($data->num_multimidia == 1 ? 'm' : 'ns').' , vídeo'.($data->num_multimidia == 1 ? '' : 's').' ou arquivo'.($data->num_multimidia == 1 ? '' : 's');?>"></a>
            <?php endif; ?>

            <br />
        </div>
        <?php if ($data->numcolab > 0) : ?>
            <br /><br />
            <div id="ultimas_colaboracoes" name="ultimas_colaboracoes"  class='font8' style='width:100%;float:left;margin-top:20px;'>
                <h3>Últimas colaborações</h3>
                <hr />
                <?php create_colab_table($connection, $link_inicial); ?>
            </div>
        <?php endif; ?>
    </div>
    <?php include 'partials/rodape.php'; ?>

</body>
</html>
<?php
	endif;
?>