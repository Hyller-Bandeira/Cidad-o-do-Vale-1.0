
//Funcao AJAX
var tempo_refresh = 10;
function AJAX()
{
	if (window.XMLHttpRequest) return new XMLHttpRequest();
	else if (window.ActiveXObject) return ActiveXObject("Microsoft.XMLHTTP");
	else
	{
		alert("Your browser does not support AJAX.");
		return false;
	}
}

// Timestamp para evitar caching na requisicao do GET
function fetch_unix_timestamp() { return parseInt(new Date().getTime().toString().substring(0, 10)); }

// Atualizando a div ultimas_colaboracoes
function refresh_ultimas_colaboracoes()
{
	//Opcoes editaveis
	var div_id = "ultimas_colaboracoes";
	var url = "ultimas_colaboracoes.php";
	// Criando xmlHttp
	var xmlhttp = AJAX();
	// Sem cache
	var timestamp = fetch_unix_timestamp();
	var nocacheurl = url + "?t=" + timestamp;

	// O codigo...
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState == 4)
		{
			document.getElementById(div_id).innerHTML = xmlhttp.responseText;
			// $(div_id).html(xmlhttp.responseText);
			setTimeout('refresh_ultimas_colaboracoes()',tempo_refresh * 10000);
		}
	}
	xmlhttp.open("GET", nocacheurl, true);
	xmlhttp.send(null);
}

// Inicia o processo de atualização
window.onload = function startrefresh() { setTimeout('refresh_ultimas_colaboracoes()', tempo_refresh * 10000); }

// Atualizando a div ultimas_colaboracoes
function refresh_colaboracoesMaisVisualizadas()
{
	//Opcoes editaveis
	var div_id = "colaboracoesMaisVisualizadas";
	var url = "colaboracoesMaisVisualizadas.php";
	// Criando xmlHttp
	var xmlhttp = AJAX();
	// Sem cache
	var timestamp = fetch_unix_timestamp();
	var nocacheurl = url + "?t=" + timestamp;

	// O codigo...
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4)
		{
			document.getElementById(div_id).innerHTML = xmlhttp.responseText;
			// $(div_id).html(xmlhttp.responseText);
			setTimeout('refresh_colaboracoesMaisVisualizadas()',tempo_refresh * 10000);
		}
	}

	xmlhttp.open("GET", nocacheurl, true);
	xmlhttp.send(null);
}

// Inicia o processo de atualização
window.onload = function startrefresh() { setTimeout('refresh_colaboracoesMaisVisualizadas()', tempo_refresh * 10000); }

// Atualizando a div colaboracaoesMaisAvaliadas
function refresh_colaboracoesMaisAvaliadas()
{
	// Opcoes editaveis
	var div_id = "colaboracoesMaisAvaliadas";
	var url = "colaboracoesMaisAvaliadas.php";
	// Criando xmlHttp
	var xmlhttp = AJAX();
	// Sem cache
	var timestamp = fetch_unix_timestamp();
	var nocacheurl = url + "?t=" + timestamp;

	// O codigo...
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4)
		{
			document.getElementById(div_id).innerHTML = xmlhttp.responseText;
			// $(div_id).html(xmlhttp.responseText);
			setTimeout('refresh_colaboracoesMaisAvaliadas()', tempo_refresh * 10000);
		}
	}
	xmlhttp.open("GET", nocacheurl, true);
	xmlhttp.send(null);
}

// Inicia o processo de atualização
window.onload = function startrefresh() { setTimeout('refresh_colaboracoesMaisAvaliadas()', tempo_refresh * 10000); }

// Atualizando a div colaboracaoesMaisRevisadas
function refresh_colaboracoesMaisRevisadas()
{
	//Opcoes editaveis
	var div_id = "colaboracoesMaisRevisadas";
	var url = "colaboracoesMaisRevisadas.php";

	// Criando xmlHttp
	var xmlhttp = AJAX();

	// O codigo...
	xmlhttp.onreadystatechange = function()
	{
		if (xmlhttp.readyState == 4)
		{
			document.getElementById(div_id).innerHTML = xmlhttp.responseText;
			// $(div_id).html(xmlhttp.responseText);
			setTimeout('refresh_colaboracoesMaisRevisadas()',tempo_refresh * 10000);
		}
	}
	xmlhttp.open("GET", url + "?t=" + fetch_unix_timestamp(), true);
	xmlhttp.send(null);
}

// Inicia o processo de atualização
window.onload = function startrefresh() { setTimeout('refresh_colaboracoesMaisRevisadas()', tempo_refresh * 10000); }