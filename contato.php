<?php
	session_start();
	header('content-type: text/html; charset=utf-8');
	require 'phpsqlinfo_dbinfo.php';
	require 'headtag.php';
?>

<!DOCTYPE html>
<html>
<?php createHead(array("title" => $nomePagina . $nome_site,
    "script" => array("src/jquery.blockUI.js"))); ?>

<body class='corposite'>
	<?php require 'header.php'; ?>
	<div class="div_centro">
        <h4 class="text-center">Mande uma mensagem para o <?php  echo $nome_site; ?> sobre dúvidas, sugestões ou críticas.</h4>
        <form name="form" id='contato-form' style="width: 500px; margin: 20px auto 30px auto;">
            <div class="row">
                <div class="form-group col-md-6 col-lg-12">
                    <label for="titulo">Título<span style= 'color:red;'>*</span></label>
                    <input type="text" class="form-control" name="titulo" id="titulo" maxlength="200" required="required">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-lg-12">
                    <label for="email">Email<span style= 'color:red;'>*</span></label>
                    <input type="email" class="form-control" name="email" id="email" maxlength="200" required="required">
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-6 col-lg-12">
                    <label for="descricao">Mensagem<span style= 'color:red;'>*</span></label>
                    <textarea class="form-control" rows="5" name="descricao" id="descricao" style='resize: none;' required="required"></textarea>
                </div>
            </div>
            <div class='row'>
                <div class='col-md-6 col-lg-12'>
                    <small>(<span style= 'color:red;'>*</span>) Campos Obrigatórios</small>
                </div>
            </div>
            <div class="row text-center">
                <button type="button" class="btn btn-success" onclick="enviaContato();"><span class="glyphicon glyphicon-send" onclick="ga('send', 'event', 'Clique', 'Botão', 'Enviar - Contato');"></span> Enviar</button>
            </div>
        </form>
        <h4 align ='center' class="font8">Email: <a href="mailto:<?php  echo $email_site; ?>" target = "_blank" class="font8" onclick="ga('send', 'event', 'Clique', 'Link', 'Email - Contato');"><?php  echo $email_site; ?> </a> <br><br>
         <label class="font8">Powered By: ClickOnMap</label>
        </h4>
	</div>
    <?php include 'partials/rodape.php'; ?>
</body>
</html>

<script type="text/javascript">
    function enviaContato()
    {
        var titulo = $('#titulo');
        var email = $('#email');
        var descricao = $('#descricao');

        if (titulo.val() != '' && email.val() != '' && descricao.val() != '') {
            $.blockUI({ message: 'Enviando mensagem...' });
            $.post( "email.php", $( "#contato-form" ).serialize(), function( data ) {

                if (data == 1) {
                    bootbox.alert("Email enviado com sucesso!!!");
                    $('#contato-form').each (function(){
                        this.reset();
                    });
                } else {
                    bootbox.alert("Falha ao enviar o email, tente mais tarde...");
                }
                $.unblockUI();

            });
        } else {
            bootbox.alert("Preencha todos os campos obrigatórios!");
            if (titulo.val() != ''){
                titulo.focus();
            } else if (email.val() != ''){
                email.focus();
            } else if (descricao.val() != ''){
                descricao.focus();
            }
        }
    }
</script>

