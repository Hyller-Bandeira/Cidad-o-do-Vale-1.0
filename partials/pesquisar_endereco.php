<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/pt_BR/sdk.js#xfbml=1&version=v2.7&appId=431019960342667";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<!--<div class="fb-like" data-href="https://www.facebook.com/gotadaguaufv/" data-width="265" data-layout="standard" data-action="like" data-size="small" data-show-faces="true" data-share="true" style="margin-left: 30px; margin-bottom: 19px; height: 56px; display: inline-block;"></div>-->

<div id='buscaNoGoogleMaps' class="row box search_box" style="float: right;">
    <form action="#" onsubmit="showAddress(this.address.value); return false">
        <fieldset class="form-group col-sm-9">
            <input type="text" id="geocode" class="form-control form-control-lg" name="address" placeholder="Informe um endereço" />
        </fieldset>

        <fieldset class="form-group col-sm-3" style="padding: 0px 5px;">
            <button id="buscar" type="submit" class="btn btn-warning active form-control" onclick="ga('send', 'event', 'Clique', 'Botão', 'Buscar Endereço');" style="background-color:rgb(247, 68, 69)"><strong> <span class="glyphicon glyphicon-search"></span> Buscar</strong></button>
        </fieldset>
    </form>
</div>