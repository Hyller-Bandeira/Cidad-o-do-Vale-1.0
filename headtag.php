<!--
To use it you go
createHead(
	["title" => ,
	"script" => [],
	"css" => [],
	"required" => []]);
-->

<?php
    //error_reporting(0);//Oculta mensagens de erro, aviso e etc

function createHead($config)
{
	?>
	<head>
		<meta charset='utf-8'>
		<title><?= $config["title"] ?></title>
		<script type="text/javascript" src="links.js"></script>
        <script type="text/javascript" src="src/jquery-ui-1.11.4.custom/external/jquery/jquery.js"></script>
        <script type="text/javascript" src="src/jquery-ui-1.11.4.custom/jquery-ui.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/social-button.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="bootstrap/js/bootbox.min.js"></script>
		<script src="src/ouibounce/source/ouibounce.js"></script>
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" type="text/css" />
        <link rel="stylesheet" href="bootstrap/css/social-button.css" type="text/css" />
		<link rel="stylesheet" href="config.css" type="text/css" />
		<link rel="stylesheet" href="style/header.css" type="text/css" />
        <link rel="stylesheet" href="src/ouibounce/ouibounce.min.css">

		<?php
		if (!empty($config["css"]))
			foreach($config["css"] as $confCss)
				echo "<link rel=\"stylesheet\" href=\"$confCss\" type=\"text/css\" />";

		if (!empty($config["script"]))
			foreach($config["script"] as $confScript)
				echo "<script type=\"text/javascript\" src=\"$confScript\"></script>";

		if (!empty($config["required"]))
			foreach($config["required"] as $confReq)
				require $confReq;
		?>

		<link rel="icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="shortcut icon" href="favicon.ico" type="image/x-icon"/>
		<link rel="stylesheet" href="src/jquery-ui-1.11.4.custom/jquery-ui.min.css" />
        <meta property="og:title" content="Gota D' Água - Juntos combateremos o desperdício"/>
        <meta property="og:image" content="imagens/facebooklogo.png"/>
        <meta property="og:site_name" content="Gota D' Água - Juntos combateremos o desperdício"/>
        <meta property="og:description" content="Cerca de 41% de toda a água tratada no país é desperdiçada. Você pode mudar esta estatística! Comece agora mesmo a colaborar e ajude a combater o desperdício em sua cidade."/>

    </head>


    <?php /* if (empty($_COOKIE['modal-perguntas'])) : ?>
	    <div id="ouibounce-modal" style='z-index: 1;'>
			<div class="underlay"></div>
			<div class="modal" style="display:block;">
				<div class="modal-title">
					<?php if (empty($_COOKIE['modal-perguntas-nao-respondeu'])) : ?>
					<h3> Espere! Só um minutinho...</h3>
					<?php else: ?>
					<h3> Estamos aguardando suas respostas!</h3>
					<?php endif; ?>
				</div>
				<div class="modal-body text-center" style="font-size:17px;">

					<?php if (empty($_COOKIE['modal-perguntas-nao-respondeu'])) : ?>
					<p style="margin: 20px 0 50px 0;">Você foi selecionado(a) exclusivamente para responder duas perguntas sobre o sistema. Sua opinião é muito importante, contamos com sua ajuda! </p>
					<?php else: ?>
					<p style="margin: 20px 0 50px 0;">Estamos aguardando suas respostas, apenas alguns usuários foram selecionados. Sua opinião é muito importante, contamos com sua ajuda! </p>
					<?php endif; ?>

					<a href="https://goo.gl/forms/Xy9FcF03qZypCdzP2" target="_blanck"><button onclick="salvacookie(); ga('send', 'event', 'Clique', 'Botão', 'Acessar perguntas');" class="btn btn-lg btn-success">Acessar perguntas</button></a>
					<p class="text-center" style="margin-top: 50px;">Desde já, muito obrigado!</p>

				</div>
			</div>
		</div>

		<script>
			$(document).ready(function(){
				var expires;
				var date; 

				var value;
				date = new Date(); //  criando o COOKIE com a data atual
				date.setTime(date.getTime()+(365*24*60*60*1000));//365 dias
				expires = date.toUTCString();
				document.cookie = "modal-perguntas-nao-respondeu=true; expires="+expires+"; path=/";
			});
		</script>
	<?php else: ?>
		<script>
			$(document).ready(function(){
				window.onbeforeunload = null;
			});
		</script>
	<?php endif; */ ?>

	<script>
		// if you want to use the 'fire' or 'disable' fn,
		// you need to save OuiBounce to an object
		var _ouibounce = ouibounce(document.getElementById('ouibounce-modal'), {
		  aggressive: true,
		  timer: 0,
		  callback: function() { 
		  }
		});

		$('body').on('click', function() {
		  	$('#ouibounce-modal').hide();
			window.onbeforeunload = null;
		});

		$('#ouibounce-modal .modal-footer').on('click', function() {
		  	$('#ouibounce-modal').hide();
			window.onbeforeunload = null;
		});

		$('#ouibounce-modal .modal').on('click', function(e) {
		  e.stopPropagation();
		});

		function salvacookie(){
			var expires;
			var date; 

			date = new Date(); //  criando o COOKIE com a data atual
			date.setTime(date.getTime()+(365*24*60*60*1000));//365 dias
			expires = date.toUTCString();
			document.cookie = "modal-perguntas=true; expires="+expires+"; path=/";
			$('#ouibounce-modal').hide();
			window.onbeforeunload = null;
		}
	</script>

    <?php include_once("analyticstracking.php") ?>

	<?php
}