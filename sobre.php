<?php
	session_start();
	header('content-type: text/html; charset=utf-8');
	require 'phpsqlinfo_dbinfo.php';
	require 'headtag.php';
?>

<!DOCTYPE html>
<html>
	<?php createHead(array("title" => $nomePagina . $nome_site,
        "script" => array("funcoes.js"))); ?>

	<body class="corposite">
		<?php require 'header.php'; ?>
		<div class="div_centro">
			<div class="font8" style="min-height: 400px;">
                <div class="row" style="margin: 0;">
                    <div class="col-md-3 text-center">
                        <img class="img-responsive" src="imagens/sobre/1.jpg" style="max-width: 230px;" title="Cerca de 41% de toda a água tratada no país é desperdiçada.">
                    </div>
                    <div class="col-md-9">
                        <p style="text-indent: 30px;">Geralmente, é comum associar a ideia de desperdício de água a hábitos domésticos, tais como o uso indiscriminado no chuveiro, a torneira mal fechada, entre outros. Entretanto, essa questão pode ir muito além do desperdício residencial. Existe, por exemplo, o desperdício durante o abastecimento de água, causado muitas vezes por falhas técnicas nas tubulações e sistemas públicos de distribuição ou até por desvios ilegais realizados por algumas pessoas para benefício próprio. No Brasil, segundo um relatório do Ministério das Cidades, <strong>cerca de 41% de toda a água tratada no país é desperdiçada</strong>. Outros tipos de desperdício de água acontece na agricultura e na indústria.</p>
                    </div>
                </div>

                <div class="row" style="margin: 0;">
                    <div class="col-md-8">
                        <p style="text-indent: 30px;">Por meio do sistema central, os serviços de água e esgoto conseguem identificar somente os vazamentos de grandes proporções. Muitas vezes, pequenas ocorrências, mas que podem comprometer o abastecimento de milhares de residências, só podem ser identificadas com o <strong>auxílio da população</strong>. Desta forma, você pode ajudar a combater o desperdício de água em sua cidade. Basta <strong><a href="registro.php" style="color: #E3911E">cadastrar-se</a></strong> neste sistema e informar onde existe algum tipo de desperdício. Para conhecer melhor o sistema acesse o tutorial. Este sistema é um projeto de pesquisa do Programa de Pós-Graduação em Ciência da Computação da Universidade Federal de Viçosa (UFV).</p>
                        <div class="text-center">
                            <a href="registro.php"><button type="button" class="btn btn-warning active" onclick="ga('send', 'event', 'Clique', 'Botão', 'Cadastrar');" style="background-color:rgb(247, 68, 69)"><span class="glyphicon glyphicon-plus-sign"></span> Cadastrar</button></a>
                            <a id="tutorial"  onclick="abreTutorial();"><button type="button" class="btn btn-primary" onclick="ga('send', 'event', 'Clique', 'Botão', 'Tutorial');"><span class="glyphicon glyphicon-book"></span> Tutorial</button></a>
                        </div>
                    </div>

                    <div class="col-md-4 text-center">
                        <img class="img-responsive" src="imagens/sobre/4.PNG" style="max-width: 300px;" title="Você pode ajudar a combater o desperdício">
                    </div>
                </div>
			</div>
			<br/>
            <small><strong>Fonte: </strong><a href="http://brasilescola.uol.com.br" target="_blank">Brasil Escola</a></small>
		</div>

        <?php include 'partials/rodape.php'; ?>
        <script>
            //document.getElementById("clickMe").onclick = doFunction;  
            
            $(document).ready(function(){
                $("#tutorial").click(function(){
                    console.log($('#tutorial-usuario'));
                    $('#tutorial-usuario').load('tutorial.php', {pagina:0}, function(){});
                    $('#tutorial-usuario').modal('show');
                });
                $('.popover').zIndex(1040);
            });
        </script>
   </body>
</html>
