<?php
    require 'phpsqlinfo_dbinfo.php';
    session_start();
    $pagina = (!empty($_POST['pagina']) ? $_POST['pagina'] : 0);

    require 'partials/tutorial_de_uso/config.php';

    if ($pagina >= count($titulos_conteudos)) {
       $pagina = 0;
    }
?>
<div class="modal-dialog  modal-lg">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" style="background-color:rgb(247, 68, 69)">&times;</button>
            <h4 class="modal-title"><?php echo $titulos_conteudos[$pagina]['titulo']; ?></h4>
        </div>
        <div id='conteudo-tutorial' class="modal-body" style="height: 400px; overflow-y: auto;">
            <?php include $titulos_conteudos[$pagina]['conteudo']; ?>
        </div>
        <div id='rodape-tutorial' class="modal-footer">
            <?php if ($pagina == 0) : ?>
                <button type="button" class="btn btn-default" data-dismiss="modal" style="color: #fff; background-color:rgb(247, 68, 69)">Fechar</button>
            <?php else : ?>
                <div class="col-md-4 text-left">
                    <?php if ($pagina > 1) :?>
                        <button type="button" class="btn btn-warning active" onclick="tutorialPagina(<?php echo $pagina-1;?>)" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-chevron-left"></span> <?php echo $titulos_conteudos[$pagina-1]['titulo']; ?></button>
                     <?php endif; ?>
                </div>

                <div class="col-md-4 text-center">
                    <button type="button" class="btn btn-warning active" onclick="tutorialPagina(0)" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-th-list"></span> Sumário</button>
                </div>
                <?php if ($pagina+1 < count($titulos_conteudos)) : ?>
                    <div class="col-md-4 text-right">
                        <button type="button" class="btn btn-warning active" onclick="tutorialPagina(<?php echo $pagina+1;?>)" style="background-color:rgb(247, 68, 69)"><?php echo $titulos_conteudos[$pagina+1]['titulo']; ?> <span class="glyphicon glyphicon-chevron-right"></span></button>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php
    $codigo_usuario = (!empty($_SESSION['code_user_'.$link_inicial]) ? $_SESSION['code_user_'.$link_inicial] : null);

    $query = sprintf("INSERT INTO usuariotutorial (codUsuario, paginaTutorial, 	tituloPagina) VALUES ('%s', '%s', '%s');",
        $connection->real_escape_string($codigo_usuario),
        $connection->real_escape_string($pagina),
        $connection->real_escape_string($titulos_conteudos[$pagina]['titulo']));

    $result = $connection->query($query);
?>