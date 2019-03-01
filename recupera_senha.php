<?php
	header('content-type: text/html; charset=utf-8');
	require 'headtag.php';
	require 'phpsqlinfo_dbinfo.php';
?>

<!DOCTYPE html>
<html>
<?php createHead(array("title" => $nomePagina . $nome_site,
    "script" => array("src/jquery.blockUI.js"))); ?>
<body class='corposite'>
	<?php require 'header.php'; ?>
	<div class='div_centro'>
		<div style='text-align: left; margin: 40px 0 35px 20px;min-height: 400px;' >
		<h4>Digite seu email abaixo para que possamos mandar seu código de validação para redefinição de senha.</h4>
			<form name='recupera' action='enviar_senha.php' method='post'>
                <div class='row'>
                    <div id="mensagem-erro" class="alert alert-danger" style="display: none">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md-6 col-lg-12">
                        <label for="endEmail">Email<span style= 'color:red;'>*</span></label>
                        <input type="email" class="form-control" name='endEmail' id='endEmail' maxlength="200" required="required">
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-12'>
                        <small>(<span style= 'color:red;'>*</span>) Campos Obrigatórios</small>
                    </div>
                </div>

                <div class="row text-center">
                    <button type="submit" class="btn btn-success" id='submit_registro' name = 'submit_registro' onclick='return validar(); ga("send", "event", "Clique", "Botão", "Enviar Email com Nova Senha");'><span class="glyphicon glyphicon-send"></span> Enviar</button>
                </div>
			</form>
		</div>
		<br/>
	</div>
    <?php include 'partials/rodape.php'; ?>
  </body>
</html>

<script language='javascript' type='text/javascript'>
	'use strict';

	function validar()
	{
        $.blockUI({ message: 'Enviando código de validação...' });
        var email = $("#endEmail").val();
        var msg_erro = $("#mensagem-erro");

		if (email == '') {
            msg_erro.html('<strong>Atenção:</strong> Preencha o campo com seu email');
            $(this).find('#endEmail').focus();
            msg_erro.show();
            $.unblockUI();
			return false;
		}

		if(!valida_email(email)) {
            msg_erro.html('<strong>Atenção:</strong> Este endereço de email é inválido');
            $(this).find('#endEmail').focus();
            msg_erro.show();
            $.unblockUI();
			return false;
		}
	}

	function valida_email(email)
	{
		var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
		var check=/@[\w\-]+\./;
		var checkend=/\.[a-zA-Z]{2,3}$/;
		return !(((email.search(exclude) != -1) || (email.search(check)) == -1) || (email.search(checkend) == -1));
	}
</script>