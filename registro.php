<?php
	header('content-type: text/html; charset=utf-8');
	require 'phpsqlinfo_dbinfo.php';
	require 'headtag.php';

	$erro = '';
	if(isset($_GET['erro'])) $erro = $_GET['erro'];
 ?>

<!DOCTYPE html>
<html>
	<?php
	createHead(array("title" => $nomePagina . $nome_site,
				"script" => array("links.js")));
	?>

<body style="margin: 0;" class="corposite">
	<?php require 'header.php'; ?>

	<div class="div_centro">
        <h3 style="margin: 20px;">Criar uma conta</h3>
        <h4 style="margin: 0 0 30px 20px;">Registre-se e comece a colaborar no sistema!</h4>
        <form id="cadastro" name="cadastro" action="cadastrando_usuario.php" method="post">
            <div class='col-md-11' style="float: none; margin: 0 auto;">
                <div class='row'>
                    <div id="mensagem-erro" class="alert alert-danger" style="<?php echo ($erro != '1' ? 'display: none' : '');?>">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <span><strong>Atenção:</strong> Login Inválido! Registre-se por meio do formulário abaixo!</span>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-4'>
                        <fieldset class='form-group'>
                            <label for='nomPessoa'>Nome<span style= 'color:red;'>*</span></label>
                            <input class='form-control' type='text' id='nomPessoa' name='nomPessoa' placeholder='Informe seu nome completo' required="required"/>
                            <small>Não será visto pelos outros usuários do sistema</small>
                        </fieldset>
                    </div>

                    <div class='col-md-4'>
                        <fieldset class='form-group'>
                            <label for='apelidoPessoa'>Apelido<span style= 'color:red;'>*</span></label>
                            <input class='form-control' type='text' id='apelidoPessoa' name='apelidoPessoa' placeholder='Informe um apelido' required="required"/>
                            <small>Será visto por todos no sistema</small>
                        </fieldset>
                    </div>

                    <div class='col-md-4'>
                        <fieldset class='form-group'>
                            <label for='faixaEtaria'>Faixa Etária<span style= 'color:red;'>*</span></label>
                            <select name='faixaEtaria' class='form-control c-select' id='faixaEtaria' required="required">
                                <option value= ''>Selecione uma faixa etária</option>
                                <option value= '0 - 17'> até 17 anos </option>
                                <option value= '18 - 25'> 18 - 25 anos </option>
                                <option value= '26 - 64'> 26 - 65 anos </option>
                                <option value= 'mais de 65'> mais de 65 anos</option>
                            </select>
                        </fieldset>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-6'>
                        <fieldset class='form-group'>
                            <label for='endEmail'>E-mail<span style= 'color:red;'>*</span></label>
                            <input class='form-control' type='text' id='endEmail' name='endEmail' placeholder='Informe seu e-mail ' required="required"/>
                        </fieldset>
                    </div>

                    <div class='col-md-6'>
                        <fieldset class='form-group'>
                            <label for='endEmail2'>Repita o Email<span style= 'color:red;'>*</span></label>
                            <input class='form-control' type='text' id='endEmail2' name='endEmail2' placeholder='Repita seu e-mail' required="required"/>
                        </fieldset>
                    </div>
                </div>

                <div class='row'>
                    <div class='col-md-6'>
                        <fieldset class='form-group'>
                            <label for='senha'>Senha<span style= 'color:red;'>*</span></label>
                            <input class='form-control' type='password' id='senha' name='senha' placeholder='Informe sua senha ' required="required"/>
                            <small>Sua senha deve conter no mínimo 6 caracteres</small>
                        </fieldset>
                    </div>

                    <div class='col-md-6'>
                        <fieldset class='form-group'>
                            <label for='senha2'>Repita a Senha<span style= 'color:red;'>*</span></label>
                            <input class='form-control' type='password' id='senha2' name='senha2' placeholder='Repita sua senha' required="required"/>
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
                        <button type='submit' class='btn btn-success' id='submit_registro' name='submit_registro' onclick="ga('send', 'event', 'Clique', 'Botão', 'Cdastrar (Página Cadastro)');"><span class='glyphicon glyphicon-share-alt'></span> <strong>Cadastrar</strong></button>
                    </div>
                </div>
            </div>
        </form>
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
            if (data == "0") {
                msg_erro.find('span').html('<strong>Atenção:</strong> Email <strong>' + endEmail + '</strong> já está cadastrado');
                $("#endEmail").focus();
                msg_erro.show();
                $('#cadastro').prop( "disabled", true );
            } else {
                msg_erro.find('span').html('');
                msg_erro.hide();
                $('#cadastro').prop( "disabled", true );
            }
        });
    });

    $('#apelidoPessoa').keyup(function()
    {
        var apelido = $("#apelidoPessoa").val();
        var msg_erro = $("#mensagem-erro");

        $.get('verifica_apelido.php', {apelido: apelido}, function( data ) {
            if (data == "0") {
                msg_erro.find('span').html('<strong>Atenção:</strong> Apelido <strong>' + apelido + '</strong> já está cadastrado');
                $("#apelidoPessoa").focus();
                msg_erro.show();
                $('#cadastro').prop( "disabled", true );
            } else {
                msg_erro.find('span').html('');
                msg_erro.hide();
                $('#cadastro').prop( "disabled", true );
            }
        });
    });

    $('#cadastro').submit(function() {
		var nome = $(this).find('#nomPessoa').val();
        var apelido = $(this).find('#apelidoPessoa').val();
		var email = $(this).find('#endEmail').val();
		var rep_email = $(this).find('#endEmail2').val();
		var senha = $(this).find('#senha').val();
		var rep_senha = $(this).find('#senha2').val();
        var msg_erro = $("#mensagem-erro");

        msg_erro.hide();

        if (nome == "") {
            msg_erro.html('<strong>Atenção:</strong> Preencha o campo com seu nome');
            $(this).find('#nomPessoa').focus();
            msg_erro.show();
			return false;
		}

        if (apelido == "") {
            msg_erro.html('<strong>Atenção:</strong> Preencha o campo com seu apelido');
            $(this).find('#apelidoPessoa').focus();
            msg_erro.show();
            return false;
        }

		if (nome.length < 3){
            msg_erro.html('<strong>Atenção:</strong> Seu nome deve conter no mínimo 3 caracteres');
            $(this).find('#nomPessoa').focus();
            msg_erro.show();
            return false;
		}

		if (email == ""){
            msg_erro.html('<strong>Atenção:</strong> Preencha o campo com seu email');
            $(this).find('#endEmail').focus();
            msg_erro.show();
            return false;
		}

		if (rep_email == ""){
            msg_erro.html('<strong>Atenção:</strong> Confirme o endereço do seu email');
            $(this).find('#endEmail2').focus();
            msg_erro.show();
            return false;
		}

		if (senha == "") {
            msg_erro.html('<strong>Atenção:</strong> Preencha o campo com sua senha');
            $(this).find('#senha').focus();
            msg_erro.show();
            return false;
		}

		if (senha.length < 6) {
            msg_erro.html('<strong>Atenção:</strong> Sua senha deve conter no mínimo 6 caracteres');
            $(this).find('#senha').focus();
            msg_erro.show();
            return false;
		}

		if (rep_senha == "") {
            msg_erro.html('<strong>Atenção:</strong> Confirme a sua senha');
            $(this).find('#senha2').focus();
            msg_erro.show();
            return false;
		}

		if (email != rep_email) {
            msg_erro.html('<strong>Atenção:</strong> Endereço de email não confere');
            $(this).find('#endEmail2').focus();
            msg_erro.show();
            return false;
		}

		if (senha != rep_senha) {
            msg_erro.html('<strong>Atenção:</strong> Sua senha não confere');
            $(this).find('#senha2').focus();
            msg_erro.show();
            return false;
		}

		if(!valida_email(email)) {
            msg_erro.html('<strong>Atenção:</strong> Este endereço de email é inválido');
            $(this).find('#endEmail').focus();
            msg_erro.show();
            return false;
		}

        return true;
    });

	function valida_email(email){
		var exclude=/[^@\-\.\w]|^[_@\.\-]|[\._\-]{2}|[@\.]{2}|(@)[^@]*\1/;
		var check=/@[\w\-]+\./;
		var checkend=/\.[a-zA-Z]{2,3}$/;
		return !(((email.search(exclude) != -1) || (email.search(check)) == -1) || (email.search(checkend) == -1));
	}
</script>