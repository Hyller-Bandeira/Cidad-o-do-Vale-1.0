<?php
    session_start();
    require '../phpsqlinfo_dbinfo.php';

    $codColaboracao = (!empty($_POST['codColaboracao']) ? $_POST['codColaboracao'] : '');
    $codCategoriaEvento = (!empty($_POST['codCategoriaEvento']) ? $_POST['codCategoriaEvento'] : '');
    $desTituloAssunto = (!empty($_POST['desTituloAssunto']) ? $_POST['desTituloAssunto'] : '');
    $dataHoraOcorrencia = (!empty($_POST['dataHoraOcorrencia']) ? $_POST['dataHoraOcorrencia'] : '');
    $desColaboracao = (!empty($_POST['desColaboracao']) ? $_POST['desColaboracao'] : '');
    $tipoStatus = (!empty($_POST['tipoStatus']) ? $_POST['tipoStatus'] : '');
    $codUsuario = (!empty($_POST['codUsuario']) ? $_POST['codUsuario'] : '');
    $codTipoEvento = (!empty($_POST['codTipoEvento']) ? $_POST['codTipoEvento'] : '');
    $desTituloImagem = (!empty($_POST['desTituloImagem']) ? $_POST['desTituloImagem'] : '');
    $comentarioImagem = (!empty($_POST['comentarioImagem']) ? $_POST['comentarioImagem'] : '');
    $endImagem = (!empty($_POST['endImagem']) ? $_POST['endImagem'] : '');
    $apelidoImagem = (!empty($_POST['apelidoImagem']) ? $_POST['apelidoImagem'] : '');
    $dataEnvioImagem = (!empty($_POST['dataEnvioImagem']) ? $_POST['dataEnvioImagem'] : '');
    $desTituloVideo = (!empty($_POST['desTituloVideo']) ? $_POST['desTituloVideo'] : '');
    $desUrlVideo = (!empty($_POST['desUrlVideo']) ? $_POST['desUrlVideo'] : '');
    $comentarioVideo = (!empty($_POST['comentarioVideo']) ? $_POST['comentarioVideo'] : '');
    $apelidoVideo = (!empty($_POST['apelidoVideo']) ? $_POST['apelidoVideo'] : '');
    $dataEnvioVideo = (!empty($_POST['dataEnvioVideo']) ? $_POST['dataEnvioVideo'] : '');
    $forum = (!empty($_POST['forum']) ? $_POST['forum'] : '');
    $notaMedia = (!empty($_POST['notaMedia']) ? $_POST['notaMedia'] : '0.00');
    $qtdVisualizacao = (!empty($_POST['qtdVisualizacao']) ? $_POST['qtdVisualizacao'] : '0');
    $qtdAvaliacao = (!empty($_POST['qtdAvaliacao']) ? $_POST['qtdAvaliacao'] : '0');
    $endArquivo = (!empty($_POST['endArquivo']) ? $_POST['endArquivo'] : '');
    $tituloArquivo = (!empty($_POST['tituloArquivo']) ? $_POST['tituloArquivo'] : '');
    $comentarioArquivo = (!empty($_POST['comentarioArquivo']) ? $_POST['comentarioArquivo'] : '');
    $apelidoArquivo = (!empty($_POST['apelidoArquivo']) ? $_POST['apelidoArquivo'] : '');
    $dataEnvioArquivo = (!empty($_POST['dataEnvioArquivo']) ? $_POST['dataEnvioArquivo'] : '');
    $datahoraCriacao = (!empty($_POST['datahoraCriacao']) ? $_POST['datahoraCriacao'] : '');
    $keywords = (!empty($_POST['keywords']) ? $_POST['keywords'] : '');
    $desTituloHistorico = (!empty($_POST['desTituloHistorico']) ? $_POST['desTituloHistorico'] : '');
    $datahoraModificacaoHistorico = (!empty($_POST['datahoraModificacaoHistorico']) ? $_POST['datahoraModificacaoHistorico'] : '');
    $apelidoUsuarioHistorico = (!empty($_POST['apelidoUsuarioHistorico']) ? $_POST['apelidoUsuarioHistorico'] : '');
    $pode_editar = (!empty($_POST['pode_editar']) ? $_POST['pode_editar'] : 'false');
    $ja_avaliou = (!empty($_POST['ja_avaliou']) ? $_POST['ja_avaliou'] : 'true');

    $status = $tipoStatus;
    if ($tipoStatus == 'E') {
        $status = 'Em Avaliação';
    } else if ($tipoStatus == 'A') {
        $status = 'Colaboração Aprovada';
    }

    $historicos = array();

    $descricoes = explode('¥', $desColaboracao);
    foreach ($descricoes as $i => $descricao) {
        if ($i == count($descricoes)-1) break;
        $historicos[$i] = new stdClass();
        $historicos[$i]->descricao = $descricao;
    }

    $titulos = explode('¥', $desTituloHistorico);
    foreach ($titulos as $i => $titulo) {
        if ($i == count($titulos)-1) break;
        $historicos[$i]->titulo = $titulo;
    }

    $datas_modificacoes = explode('¥', $datahoraModificacaoHistorico);
    foreach ($datas_modificacoes as $i => $data_modificacao) {
        if ($i == count($datas_modificacoes)-1) break;
        $historicos[$i]->data_modificacao = $data_modificacao;
    }

    $apelidos = explode('¥', $apelidoUsuarioHistorico);
    foreach ($apelidos as $i => $apelido) {
        if ($i == count($apelidos)-1) break;
        $historicos[$i]->apelido = $apelido;
    }

?>

<div id='infowindowview' class='balao' style='width: 550px; height: 470px; overflow: hidden;'>
    <div id='tabs'>
        <ul>
            <li><a href='#tab-1' onclick="ga('send', 'event', 'Clique', 'Aba', 'Dados');"><span>Dados</span></a></li>
            <?php if ($endImagem || $pode_editar == 'true' ) : ?>
                <li><a href='#tab-2' onclick="ga('send', 'event', 'Clique', 'Aba', 'Imagem');"><span>Imagem</span></a></li>
            <?php endif; ?>
            <?php if ($desUrlVideo || $pode_editar == 'true' ) : ?>
                <li><a href='#tab-3' onclick="ga('send', 'event', 'Clique', 'Aba', 'Vídeo');"><span>Video</span></a></li>
            <?php endif; ?>
            <?php if ($endArquivo || $pode_editar == 'true' ) : ?>
                <li><a href='#tab-4' onclick="ga('send', 'event', 'Clique', 'Aba', 'Arquivo');"><span>Arquivo</span></a></li>
            <?php endif; ?>
            <?php if ($forum != '' || $pode_editar == 'true') : ?>
                <li><a href='#tab-5' onclick="ga('send', 'event', 'Clique', 'Aba', 'Forum');"><span>Forum</span></a></li>
            <?php endif; ?>
            <li><a href='#tab-6' onclick="ga('send', 'event', 'Clique', 'Aba', 'Metadados');"><span>Metadados</span></a></li>
        </ul>

        <div id='tab-1' class='balao'>
            <div class='row'>
                <div id='descricoes' class='carousel slide' data-ride='carousel' data-interval='false'>
                    <div class='carousel-inner' role='listbox'>
                        <?php foreach ($historicos as $i => $historico) : ?>
                            <div class='item <?php echo ($i == count($historicos)-1 ? 'active': '')?>'>
                                <div class='row text-center' style='margin-bottom: 10px;'>
                                    <h4 class='text-center'><?php echo $historico->titulo;?></h4>
                                </div>
                                <div class='row' style="margin-bottom: 10px;">
                                    <div class='col-md-12'  style='min-height: 80px; padding: 0 10%;'>
                                        <?php echo substr($historico->descricao, 0, 250);?>
                                        <?php if (strlen($historico->descricao)>250) : ?>
                                            ... (<a onclick="setDescricaoModal('<?php echo $historico->descricao;?>'); ga('send', 'event', 'Clique', 'Link', 'Ver tudo - Descrição Colaboração');" style="color: rgb(255, 158, 0);" >ver tudo</a>)
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-md-6 text-right'>
                                        <span class='fa fa-calendar'></span> <?php echo ($i == 0 ? 'Colaboração': 'Modificação')?>:  <?php echo date('d/m/Y - H:i:s', strtotime($historico->data_modificacao));?>
                                    </div>
                                    <div class='col-md-<?php echo (count($historicos) > 1 ? '4' : '5') ?> text-center' style="padding: 0 0 0 5px;">
                                        <span class='glyphicon glyphicon-<?php echo ($i == 0 ? 'user': 'pencil')?>'></span> <?php echo ($i == 0 ? 'Autor': 'Editor')?>:  <a href='user_profile.php?uid=<?php echo $historico->apelido;?>' title="Ver Perfil de <?php echo $historico->apelido;?>" style='color: rgb(255, 158, 0); font-weight: bold;' onclick="ga('send', 'event', 'Clique', 'Link', 'Descrição Colaboração - Perfil de Autor/Editor');"><?php echo $historico->apelido;?></a>
                                    </div>
                                    <?php if (count($historicos) > 1) : ?>
                                        <div class='col-md-2 text-center' style="padding: 0 0 0 5px;">
                                            <span><?php echo ($i+1).'/'.count($historicos);?></span>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <?php if (count($historicos) > 1) : ?>
                        <a class='left carousel-control' href='#descricoes' role='button' data-slide='prev' style='background: none; width: 4%;' onclick="ga('send', 'event', 'Clique', 'Botão', 'Navegação - Descrição da Colaboração');">
                            <span class='glyphicon glyphicon-chevron-left' aria-hidden='true'></span>
                            <span class='sr-only'>Anterior</span>
                        </a>
                        <a class='right carousel-control' href='#descricoes' role='button' data-slide='next' style='background: none; width: 4%;' onclick="ga('send', 'event', 'Clique', 'Botão', 'Navegação - Descrição da Colaboração');">
                            <span class='glyphicon glyphicon-chevron-right' aria-hidden='true'></span>
                            <span class='sr-only'>Próxima</span>
                        </a>
                    <?php endif; ?>
                </div>

                <?php if ($pode_editar == 'true') : ?>
                    <form id="editar_colaboracao" style="display:none;">
                        <div class="form-group" style="margin-bottom: 5px;">
                            <label for="novo_titulo">Título<span style= 'color:red;'>*</span></label>
                            <input type="text" class="form-control" id="novo_titulo" maxlength="100">
                        </div>
                        <div class="form-group" style="margin-bottom: 0;">
                            <label for="nova_descricao">Descrição da colaboração<span style= 'color:red;'>*</span></label>
                            <textarea class="form-control" rows="3" id="nova_descricao" style='resize: none;'></textarea>
                        </div>
                    </form>
                <?php endif; ?>
            </div>

            <?php if ($pode_editar == 'true') : ?>
                <div class='row'>
                    <div class='col-md-12 text-center' style='margin: 15px 0;'>
                        <button id='botaoEditar' name='botaoEditar' type='button' class='btn btn-warning active'  onclick='Edicao("<?php echo $historicos[count($historicos)-1]->titulo;?>", "<?php echo $historicos[count($historicos)-1]->descricao;?>"); ga("send", "event", "Clique", "Botão", "Editar Colaboração");'><span class='glyphicon glyphicon-pencil'></span> <strong>Editar Colaboração</strong></button>
                        <button id='botaoCancelar' name='botaoCancelar' type='button' class='btn btn-danger active' style='display: none;'  onclick='Cancelar(); ga("send", "event", "Clique", "Botão", "Cancelar Edição");'><span class='glyphicon glyphicon-remove'></span> <strong>Cancelar</strong></button>
                        <button id='botaoSalvar' name='botaoSalvar' type='button' class='btn btn-success active' style='display: none;'  onclick='Salvar(<?php echo $codColaboracao;?> ); ga("send", "event", "Clique", "Botão", "Salvar Edição");'><span class='glyphicon glyphicon-floppy-disk'></span> <strong>Salvar Edição</strong></button>
                    </div>
                </div>
            <?php endif; ?>
            <div class='row' <?php echo ($pode_editar == 'true' ? '' : 'style="margin-top: 30px;"'); ?>>
                <div class='col-md-7'>
                    <div class='row text-left' style='margin: 8px;'>
                        <span class='glyphicon glyphicon-th-large'></span> Categoria:  <?php echo $codCategoriaEvento;?>
                    </div>
                    <?php if (!empty($codTipoEvento)) :?>
                    <div class='row text-left' style='margin: 8px;'>
                        <span class='glyphicon glyphicon-th-list'></span> Tipo:  <?php echo $codTipoEvento;?>
                    </div>
                    <?php endif;?>
                    <div class='row text-left' style='margin: 8px;'>
                        <span class='glyphicon glyphicon-map-marker'></span> Status:  <?php echo $status;?>
                    </div>
                    <?php if (!empty($dataHoraOcorrencia)) : ?>
                        <div class='row text-left' style='margin: 8px;'>
                            <span class='fa fa-calendar'></span> Ocorrência:  <?php echo $dataHoraOcorrencia;?>
                        </div>
                    <?php endif;?>
                </div>
                <div class='col-md-5'>
                    <?php if ($ja_avaliou == 'false' && $pode_editar == 'true') : ?>
                        <div>
                            <div class='row text-center' style='margin-bottom: 10px;'>
                                <strong>Avalie esta colaboração</strong>
                            </div>
                            <div class='row'>
                                <form class='font1' name='formularioNota' id='formularioNota'>
                                    <div class='col-md-5' style='padding: 0;'>
                                        <select name='nota' class='form-control' id='nota' style='margin-right: 15px;'>
                                            <option value=0> 0 </option>
                                            <option value=1> 1 </option>
                                            <option value=2> 2 </option>
                                            <option value=3> 3 </option>
                                            <option value=4> 4 </option>
                                            <option value=5> 5 </option>
                                        </select>
                                    </div>
                                    <div class='col-md-7'>
                                        <button type='button' onclick="avaliaColaboracao(); ga('send', 'event', 'Clique', 'Botão', 'Avaliar Colaboração');" class='btn btn-warning btn-lg active'><span class='glyphicon glyphicon-ok'></span> <strong>Avaliar</strong></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php else:?>
                        <div>
                            <div id = 'notaMedia' >
                                <div class='row text-center' style='margin-bottom: 10px;'>
                                    <strong>Estatísticas da colaboração</strong>
                                </div>
                                <div class='row text-center'>
                                    <div class="col-md-12">
                                        Nota final: <?php echo $notaMedia; ?>
                                    </div>
                                    <div class="col-md-12">
                                        Avaliações: <?php echo $qtdAvaliacao; ?>
                                    </div>
                                    <div class="col-md-12">
                                        Visualizações: <?php echo $qtdVisualizacao; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

            </div>
            <div class='row'>
                <div class='col-md-12'>
                    <?php if ($keywords != '') : ?>
                    <div class='row text-left' style='margin: 0 8px;'>
                        <span class='fa fa-key'></span> Palavras-chave:  <?php echo $keywords;?>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <form name='frmFoto' id='frmFoto' action = 'phpsqlinfo_addrow_update.php' method='post' enctype='multipart/form-data' target='upload_target' >
            <input type='hidden' name='usuario_id' id='usuario_id' value = '<?php echo $_SESSION['code_user_'.$link_inicial]; ?>'/>
            <input type='hidden' name='codColaboracao' id='codColaboracao' value = '<?php echo $codColaboracao;?>'/>

            <?php if ($endImagem || $pode_editar == 'true' ) : ?>
                <div id='tab-2' class='balao'>
                    <?php if($endImagem) : ?>
                        <div class='row'>
                            <div class='col-md-12 text-center'>
                                <h4><?php echo $desTituloImagem;?></h4>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12 text-center' style="margin: 0 0 20px 0;">
                                <a href="imagensenviadas/<?php echo $endImagem;?>" title="Baixar Imagem" target="_blank" onclick="ga('send', 'event', 'Clique', 'Baixar', 'Imagem');"><img class='img-responsive center-block' style="max-height: 200px;max-width: 100%;" src='imagensenviadas/<?php echo $endImagem;?>'></a>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-6 text-right'>
                                <span class='fa fa-calendar'></span> Envio:  <?php echo date('d/m/Y - H:i:s', strtotime($dataEnvioImagem));?>
                            </div>
                            <div class='col-md-5 text-center' style="padding: 0 0 0 5px;">
                                <span class='glyphicon glyphicon-user'></span> Autor:  <a href='user_profile.php?uid=<?php echo $apelidoImagem;?>' title="Ver Perfil de <?php echo $apelidoImagem;?>" style='color: rgb(255, 158, 0); font-weight: bold;' onclick="ga('send', 'event', 'Clique', 'Link', 'Descrição Imagem - Perfil do Autor');"><?php echo $apelidoImagem;?></a>
                            </div>
                        </div>

                        <?php if($comentarioImagem) : ?>
                            <div class='row'>
                                <div class='col-md-12 text-justify' style="margin-top: 20px;">
                                    <p><?php echo $comentarioImagem;?></p>
                                </div>
                            </div>
                        <?php endif; ?>

                    <?php else: ?>
                        <div class='row'>
                            <div class='col-md-12'>
                                <fieldset class='form-group'>
                                    <label for='desTituloImagem'>Título da Imagem<span style= 'color:red;'>*</span></label>
                                    <input class='form-control' type='text' id='desTituloImagem' name='desTituloImagem' placeholder='Informe um título para a imagem' maxlength='100'/>
                                </fieldset>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12'>
                                <fieldset class='form-group'>
                                    <label for='Imagem' class='file'>Imagem<span style= 'color:red;'>*</span></label>
                                    <input type='file' class='filestyle'  name='Imagem' id='Imagem'>
                                    <span class='file-custom'></span>
                                </fieldset>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12'>
                                <fieldset class='form-group'>
                                    <label for='comentImagem'>Comentário da Imagem</label>
                                    <textarea class='form-control' rows='4' id='comentImagem' name='comentImagem' style='resize: none;' placeholder='Descreva a imagem'></textarea>
                                </fieldset>
                            </div>
                        </div>

                        <div class='row'>
                           <div class='col-md-12'>
                            <small>(<span style= 'color:red;'>*</span>) Campos Obrigatórios</small>
                            </div>
                        </div>

                        <div class='row text-center'>
                            <div class='col-md-12'>
                                <button type='submit' class='btn btn-success btn-lg' onclick="ga('send', 'event', 'Clique', 'Botão', 'Enviar Dados - Imagem');"><span class='glyphicon glyphicon-share-alt'></span> <strong>Enviar Dados</strong></button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($desUrlVideo || $pode_editar == 'true' ) : ?>
                <div id='tab-3' class='balao'>
                    <?php if ($desUrlVideo) : ?>
                        <div class='row'>
                            <div class='col-md-12 text-center'>
                                <h4><?php echo $desTituloVideo;?></h4>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12 text-center'>
                                <iframe width='350' height='200' src='http://www.youtube.com/embed/<?php echo $desUrlVideo;?>'></iframe>
                            </div>
                        </div>

                        <div class='row text-center' style="margin: 0 0 20px 0;">
                            Em caso de falhas na exibição <a href='http://www.youtube.com/watch?v=<?php echo $desUrlVideo;?>' target='_blank'  onclick="ga('send', 'event', 'Clique', 'Baixar', 'Vídeo');"> "clique aqui "</a> para assistir
                        </div>

                        <div class='row'>
                            <div class='col-md-6 text-right'>
                                <span class='fa fa-calendar'></span> Envio:  <?php echo date('d/m/Y - H:i:s', strtotime($dataEnvioVideo));?>
                            </div>
                            <div class='col-md-5 text-center' style="padding: 0 0 0 5px;">
                                <span class='glyphicon glyphicon-user'></span> Autor:  <a href='user_profile.php?uid=<?php echo $apelidoVideo;?>' title="Ver Perfil de <?php echo $apelidoVideo;?>" style='color: rgb(255, 158, 0); font-weight: bold;'  onclick="ga('send', 'event', 'Clique', 'Link', 'Descrição Vídeo - Perfil do Autor');"><?php echo $apelidoVideo;?></a>
                            </div>
                        </div>

                        <?php if ($comentarioVideo) : ?>
                            <div class='row'>
                                <div class='col-md-12 text-justify' style="margin-top: 20px;">
                                    <p><?php echo $comentarioVideo;?></p>
                                </div>
                            </div>
                        <?php endif;?>

                    <?php else :?>
                        <div class='row'>
                            <div class='col-md-12'>
                                <fieldset class='form-group'>
                                    <label for='desTituloVideo'>Título do Video<span style= 'color:red;'>*</span></label>
                                    <input class='form-control' type='text' id='desTituloVideo' name='desTituloVideo' placeholder='Informe um título para o vídeo' maxlength='100'/>
                                </fieldset>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12'  style='margin-bottom: 5px;'>
                                <fieldset class='form-group' style='margin-bottom: 0'>
                                    <label for='desUrlVideo'>URL do Video<span style= 'color:red;'>*</span></label>
                                    <input class='form-control' type='text' id='desUrlVideo' name='desUrlVideo' placeholder='Informe a URL do vídeo'/>
                                </fieldset>
                            <small><strong>Obs.:</strong> Apenas Urls de Video do YouTube</small>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12'>
                                <fieldset class='form-group'>
                                    <label for='comentVideo'>Comentário do Vídeo</label>
                                    <textarea class='form-control' rows='4' id='comentVideo' name='comentVideo' style='resize: none;' placeholder='Descreva o vídeo'></textarea>
                                </fieldset>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12'>
                                <small>(<span style= 'color:red;'>*</span>) Campos Obrigatórios</small>
                            </div>
                        </div>

                        <div class='row text-center'>
                            <div class='col-md-12'>
                                <button type='submit' class='btn btn-success btn-lg' onclick="ga('send', 'event', 'Clique', 'Botão', 'Enviar Dados - Vídeo');"><span class='glyphicon glyphicon-share-alt'></span> <strong>Enviar Dados</strong></button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if ($endArquivo || $pode_editar == 'true' ) : ?>
                <div id='tab-4' class='balao'>
                    <?php if ($endArquivo):?>
                        <div class='row'>
                            <div class='col-md-12 text-center'>
                                <h4><?php echo $tituloArquivo;?></h4>
                            </div>
                        </div>

                        <?php if ($comentarioArquivo) : ?>
                            <div class='row'>
                                <div class='col-md-12 text-justify' style="margin-top: 20px;">
                                    <p><?php echo $comentarioArquivo;?></p>
                                </div>
                            </div>
                        <?php endif;?>

                        <div class='row' style="margin: 30px 0;">
                            <div class='col-md-6 text-right'>
                                <span class='fa fa-calendar'></span> Envio:  <?php echo date('d/m/Y - H:i:s', strtotime($dataEnvioArquivo));?>
                            </div>
                            <div class='col-md-5 text-center' style="padding: 0 0 0 5px;">
                                <span class='glyphicon glyphicon-user'></span> Autor:  <a href='user_profile.php?uid=<?php echo $apelidoArquivo;?>' title="Ver Perfil de <?php echo $apelidoArquivo;?>" style='color: rgb(255, 158, 0); font-weight: bold;'  onclick="ga('send', 'event', 'Clique', 'Link', 'Descrição Arquivo - Perfil do Autor');"><?php echo $apelidoArquivo;?></a>
                            </div>
                        </div>

                        <div class='row text-center' style="margin-top: 60px;">
                            <a href='arquivos/<?php echo $endArquivo;?>' target='_blank'>
                                <button type='button' class='btn btn-success btn-lg'><span class='glyphicon glyphicon-download-alt' onclick="ga('send', 'event', 'Clique', 'Baixar', 'Arquivo');"></span> <strong> Baixar Arquivo</strong></button>
                            </a>
                        </div>

                    <?php else :?>
                        <div class='row'>
                            <div class='col-md-12'>
                                <fieldset class='form-group'>
                                    <label for='desArquivo'>Título do Arquivo<span style= 'color:red;'>*</span></label>
                                    <input class='form-control' type='text' id='desArquivo' name='desArquivo' placeholder='Informe um título para o arquivo' maxlength='100'/>
                                </fieldset>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12'>
                                <fieldset class='form-group'>
                                    <label for='arquivo' class='file'>Arquivo<span style= 'color:red;'>*</span></label>
                                    <input type='file' class='filestyle'  name='arquivo' id='arquivo'>
                                    <span class='file-custom'></span>
                                </fieldset>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12'>
                                <fieldset class='form-group'>
                                    <label for='comentArq'>Comentário do Arquivo</label>
                                    <textarea class='form-control' rows='4' id='comentArq' name='comentArq' style='resize: none;' placeholder='Descreva o arquivo'></textarea>
                                </fieldset>
                            </div>
                        </div>

                        <div class='row'>
                            <div class='col-md-12'>
                                <small>(<span style= 'color:red;'>*</span>) Campos Obrigatórios</small>
                            </div>
                        </div>

                        <div class='row text-center'>
                            <div class='col-md-12'>
                                <button type='submit' class='btn btn-success btn-lg' onclick="ga('send', 'event', 'Clique', 'Botão', 'Enviar Dados - Arquivo');"><span class='glyphicon glyphicon-share-alt'></span> <strong>Enviar Dados</strong></button>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            <?php endif; ?>
        </form>

        <?php if ($forum != '' || $pode_editar == 'true' ) : ?>
            <div id='tab-5' class='balao'>
                <div id='com-comentario' style="display: <?php echo ($forum != '') ? '' : 'none' ?>" >
                    <div class='row text-center'>
                        <div class='col-md-12'>
                            <h4>Comentários Adicionados</h4>
                        </div>
                    </div>

                    <div class='row text-center'>
                        <div class='col-md-12'>
                            <div id='divForum' class='comentario'><?php echo $forum;?></div>
                        </div>
                    </div>
                </div>

                <div id='sem-comentario' class='row text-center' style="display: <?php echo ($forum == '') ? '' : 'none' ?>">
                    <div class='col-md-12'>
                        <h4>Seja o primeiro a comentar!</h4>
                    </div>
                </div>

                <?php if ($pode_editar == 'true' ) : ?>
                    <div name='comentario' id='comentario'>
                        <div class='row'>
                            <fieldset class='form-group'>
                                <label for='desComentario'>Comentário</label>
                                <input type='hidden' name='usuario_id' id='usuario_id' value = '<?php echo $_SESSION['code_user_'.$link_inicial]; ?>'/>
                                <input type='hidden' name='codColaboracao' id='codColaboracao' value = '<?php echo $codColaboracao;?>'/>
                                <textarea class='form-control' rows='4' id='desComentario' name='desComentario' style='resize: none;' placeholder='Deixe seu comentário a respeito desta colaboração'></textarea>
                            </fieldset>
                        </div>

                        <div class='row text-center'>
                            <div class='col-md-12'>
                                <button type='submit' class='btn btn-success btn-lg' onclick="enviarComentario(); ga('send', 'event', 'Clique', 'Botão', 'Enviar Comentário');"><span class='glyphicon glyphicon-comment'></span> <strong>Enviar Comentário</strong></button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <div id='tab-6' class='balao'>
            <span id='metadados' name='metadados'></span>
            </div>
        </div>
    </div>
</div>