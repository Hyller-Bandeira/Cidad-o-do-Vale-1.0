<script language="javascript" type="text/javascript">

    $( document ).load(function() {
        // console.log($('#ultimas_colaboracoes').html());

        if ($('#ultimas_colaboracoes').html() == '') {
            $('#ultimas_colaboracoes').hide();
        }
        if ($('#colaboracoesMaisVisualizadas').html() == '') {
            $('#colaboracoesMaisVisualizadas').hide();
        }
        if ($('#colaboracoesMaisAvaliadas').html() == '') {
            $('#colaboracoesMaisAvaliadas').hide();
        }
        if ($('#colaboracoesMaisRevisadas').html() == '') {
            $('#colaboracoesMaisRevisadas').hide();
        }
    });

    refresh_ultimas_colaboracoes();
    refresh_colaboracoesMaisVisualizadas();
    refresh_colaboracoesMaisAvaliadas();
    refresh_colaboracoesMaisRevisadas();
</script>

<div class="row" style="margin-top: 25px;">
    <div id="ultimas_colaboracoes" name="ultimas_colaboracoes" class="col-md-6"></div>
    <div id="colaboracoesMaisVisualizadas" name="colaboracoesMaisVisualizadas" class="col-md-6"></div>
    <div id="colaboracoesMaisAvaliadas" name="colaboracoesMaisAvaliadas" class="col-md-6"></div>
    <div id="colaboracoesMaisRevisadas" name="colaboracoesMaisRevisadas" class="col-md-6"></div>
</div>

<div id= 'output1' name = 'output1' style="display: none;"></div>