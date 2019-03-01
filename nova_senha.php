<?php
	header('content-type: text/html; charset=utf-8');
	require 'phpsqlinfo_dbinfo.php';
	require 'headtag.php';
?>

<!DOCTYPE html>
<html>
<?php createHead(array("title" => $nomePagina . $nome_site)); ?>

<body>
	<?php require 'header.php'; ?>
	<div class="div_centro">
		<div style="text-align: left; margin: 50px 0 0 20px; min-height: 400px;" >
			<form name="troca_senha" action="troca_senha.php" method="post">
                <div class='row'>
                    <div id="mensagem-erro" class="alert alert-danger" style="display: none">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-lg-12">
                        <label for="endEmail">Email<span style= 'color:red;'>*</span></label>
                        <input type="email" class="form-control" name="endEmail" id="endEmail" maxlength="200" required="required" onchange="verifica_email()">
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-lg-12">
                        <label for="codigo_ativacao">Código de validação<span style= 'color:red;'>*</span></label>
                        <input type="text" class="form-control" name="codigo_ativacao" id='codigo_ativacao' maxlength="200" required="required" onchange="verifica_codigo_ativacao()">
                        <small>Este código foi enviado para seu e-mail, caso necessário, verifique a caixa de Spam. Se quiser gerar um novo código de ativação <strong><a href="recupera_senha.php" style="color: #E3911E"  onclick="ga('send', 'event', 'Clique', 'Link', 'Novo Código de Validação - Nova Senha');">clique aqui!</a></strong></small>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-lg-12">
                        <label for="nova_senha">Nova Senha<span style= 'color:red;'>*</span></label>
                        <input type="password" class="form-control" name="nova_senha" id='nova_senha' maxlength="200" required="required">
                        <small>Sua nova senha deve conter no mínimo 6 caracteres</small>
                    </div>
                </div>

                <div class="row">
                    <div class="form-group col-md-6 col-lg-12">
                        <label for="senha2">Repita a Nova Senha<span style= 'color:red;'>*</span></label>
                        <input type="password" class="form-control" name="senha2" id='senha2' maxlength="200" required="required">
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-12'>
                        <small>(<span style= 'color:red;'>*</span>) Campos Obrigatórios</small>
                    </div>
                </div>

                <div class="row text-center">
                    <button type="submit" class="btn btn-success" id='submit_registro' name = 'submit_registro' onclick='return validar(); ga("send", "event", "Clique", "Botão", "Mudar Senha");'><span class="glyphicon glyphicon-random"></span> Mudar Senha</button>
                </div>
			</form>
		</div>
	</div>
    <?php include 'partials/rodape.php'; ?>
  </body>
</html>

<script language="javascript" type="text/javascript">
	'use strict';

    $('#endEmail').keyup(function()
    {
        var endEmail = $("#endEmail").val();
        var msg_erro = $("#mensagem-erro");

        $.get('verifica_email.php', {endEmail: endEmail}, function( data ) {
            if (data != "0") {
                msg_erro.html('<strong>Atenção:</strong> Email não existe');
                $("#endEmail").focus();
                msg_erro.show();
                $('#cadastro').prop( "disabled", true );
            } else {
                msg_erro.hide();
                $('#cadastro').prop( "disabled", false );
            }
        });
    });

	function verifica_codigo_ativacao()
	{
        var xmlhttp = '';
		if(window.XMLHttpRequest)	// codigo para IE7+, Firefox, Chrome, Opera, Safari
		{
			xmlhttp = new XMLHttpRequest();
		}
		else	// codigo para IE6, IE5
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}

        var codigo_ativacao = $("#codigo_ativacao").val();
        var msg_erro = $("#mensagem-erro");

		xmlhttp.open("GET", "verifica_codigo_ativacao.php?codigo_ativacao=" + codigo_ativacao , true);
		xmlhttp.onreadystatechange=function()
		{
			if(xmlhttp.readyState == 4 && xmlhttp.status == 200)
			{
				var results = xmlhttp.responseText;
				if (results == "1")
				{
                    msg_erro.html('<strong>Atenção:</strong> Codigo de ativacao esta errado');
                    $(this).find('#codigo_ativacao').focus();
                    msg_erro.show();
                    $("#submit_registro").prop( "disabled", true );
				}
				else
				{
                    msg_erro.hide();
                    $("#submit_registro").prop( "disabled", false );
				}
			}
		}
		xmlhttp.send(null);
	}

	function validar()
	{
		var email = $('#endEmail').val();
		var codigo_ativacao = $('#codigo_ativacao').val();
		var senha = $('#nova_senha').val();
		var rep_senha = $('#senha2').val();
        var msg_erro = $("#mensagem-erro");

		if (email == "") {
            msg_erro.html('<strong>Atenção:</strong> Preencha o campo com seu email');
            $(this).find('#endEmail').focus();
            msg_erro.show();
			return false;
		}

		if(!valida_email(email)) {
            msg_erro.html('<strong>Atenção:</strong> Este endereço de email é inválido');
            $(this).find('#endEmail').focus();
            msg_erro.show();
			return false;
		}

		if (codigo_ativacao == "") {
            msg_erro.html('<strong>Atenção:</strong> Preencha o campo com seu código de validação');
            $(this).find('#codigo_ativacao').focus();
            msg_erro.show();
			return false;
		}

		if (senha == "") {
            msg_erro.html('<strong>Atenção:</strong> Preencha o campo com sua senha');
            $(this).find('#nova_senha').focus();
            msg_erro.show();
			return false;
		}

		if (senha.length < 6) {
            msg_erro.html('<strong>Atenção:</strong> Sua senha deve conter no mínimo 6 caracteres');
            $(this).find('#senha').focus();
            msg_erro.show();
			return false;
		}

		if (senha != rep_senha) {
            msg_erro.html('<strong>Atenção:</strong> Sua senha não confere');
            $(this).find('#senha2').focus();
            msg_erro.show();
			return false;
		}
	}

	function valida_email(email)
	{
		var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
		var check=/@[\w\-]+\./;
		var checkend=/\.[a-zA-Z]{2,3}$/;
		if(((email.search(exclude) != -1)||(email.search(check)) == -1)||(email.search(checkend) == -1)){return false;}
		else {return true;}
	}

</script>