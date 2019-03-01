<?php
// Esta Função transforma o texto em minúsculo respeitando a acentuação
function str_minuscula($texto)
{
    $texto = mb_convert_case($texto, MB_CASE_LOWER, "UTF-8");
    return $texto;
}

// Esta Função transforma o texto em maiúsculo respeitando a acentuação
function str_maiuscula($texto)
{
    //$texto = strtr(strtoupper($texto),"àáâãçèéêìíîñòóôõùüúç","ÀÁÂÃÇÈÉÊÌÍÎÑÒÓÔÕÙÜÚÇ");
    $texto = mb_convert_case($texto, MB_CASE_UPPER, "UTF-8");
    return $texto;
}

// Esta Função transforma a primeira letra do texto em maiúsculo respeitando a acentuação
function primeira_maiuscula($texto)
{
    //$texto = strtr(ucfirst($texto),"ÀÁÂÃÇÈÉÊÌÍÎÑÒÓÔÕÙÜÚÇ","àáâãçèéêìíîñòóôõùüúç");
    $texto = mb_convert_case(mb_substr($texto, 0, 1, "UTF-8"), MB_CASE_UPPER, "UTF-8").mb_substr($texto, 1, mb_strlen($texto), "UTF-8");
    return $texto;
}

// Verifica se a palavra está toda em maiúscula
function comparaPalavraMaiuscula($palavra)
{

    $palavra = str_replace(" ", "",$palavra);

    if ($palavra == "") return false;
    if ($palavra == "[:p:]")  return false;
    if (strlen($palavra) <= 1) return false;

    $palavra = preg_replace("[^a-zA-Z0-9]", "", strtr($palavra, "áàãâéêíóôõúçÁÀÃÂÉÊÍÓÔÕÚÇ ", "aaaaeeioooucAAAAEEIOOOUC_"));

    return ($palavra == str_maiuscula($palavra));
}


/////////////////////////////////
// Filtro
/////////////////////////////////

function filtro($texto, $ponto_final = true)
{
    // Variáveis (Nao pode colocar ponto final senao vai tirar reticencias
    $pontuacoes = array("[\s]?\, ", "[\s]?\!", "[\s]?\?", "[\s]?\;"); // Como expressao regular, remove espacos entre as pontuacoes

    $padrao = '([^a-zA-Z])';//Qualquer caracter que nao seja letras maiusculas e nem minusculas

    $dicionario = array(
        'abs' => 'abraços',
        'add' => 'adicionar',
        'agua' => 'água',
        'aki' => 'aqui',
        'ajudandu' => 'ajudando',
        'amg' => 'amigo',
        'axei' => 'achei',
        'bff' => 'best friend forever',
        'bjo' => 'beijo',
        'bjos' => 'beijos',
        'bjs' => 'beijos',
        'blz' => 'beleza',
        'boarracharia' => 'borracharia',
        'brinks' => 'brincadeira',
        'cen' => 'cem',
        'com tigo' => 'contigo',
        'concerteza' => 'com certeza',
        'conhese' => 'conhece',
        'ctz' => 'com certeza',
        'dificiu' => 'difícil',
        'dificio' => 'difícil',
        'eh' => 'é',
        'en' => 'em',
        'enforma' => 'informar',
        'entereso' => 'interesso',
        'fasso' => 'faço',
        'fb' => 'Facebook',
        'fik' => 'fica',
        'ficu' => 'fico',
        'flw' => 'falou',
        'glr' => 'galera',
        'hj' => 'hoje',
        'ixisti' => 'existe',
        'kd' => 'cadê',
        'kra' => 'cara',
        'ksa' => 'casa',
        'mehlor' => 'melhor',
        'msg' => 'mensagem',
        'mds' => 'meu Deus',
        'mi' => 'me',
        'msm' => 'mesmo',
        'mto' => 'muito',
        'ñ' => 'não',
        'ngm' => 'ninguém',
        'naum' => 'não',
        'nd' => 'nada',
        'nda' => 'nada',
        'noob' => 'novato',
        'novis' => 'novidades',
        'obg' => 'obrigado',
        'omg' => 'oh my god',
        'p' => 'para',
        'parabems' => 'parabéns',
        'pfv' => 'por favor',
        'pfvr' => 'por favor',
        'plz' => 'por favor',
        'pq' => 'porque',
        'probrema' => 'problema',
        'q' => 'que',
        'qdo' => 'quando',
        'recramação' => 'reclamação',
        'sds' => 'saudações',
        'sdds' => 'saudades',
        'si' => 'se',
        'sqn' => 'só que não',
        'ta' => 'está',
        'tava' => 'estava',
        'tb' => 'também',
        'tbm' => 'também',
        'tc' => 'teclar',
        'td' => 'tudo',
        'to' => 'estou',
        'vose' => 'você',
        'vc' => 'você',
        'vdd' => 'verdade',
        'vlw' => 'valeu',
    );

    $palavras_erradas = array();
    $palavras_certas = array();

    foreach ($dicionario as $errado => $certo) {
        //'/'.$padrao.'errado'.$padrao.'/' => '\1certo\2',
        array_push($palavras_erradas, '/'.$padrao.$errado.$padrao.'/');
        array_push($palavras_certas, '\1'.$certo.'\2');
    }

    // Remove o excesso de espaços em branco -> amanha    vou falar            com vc => amanha vou falar com vc
    $texto = preg_replace("/\s(?=\s)/", "", $texto);

    //Remove letras repetidas
    $num_repeticao_permitida = 2;//Quantas repeticoes de uma letra é permitida, min 2 senao remove rr ss...
    for ($i = 0; $i < strlen($texto); $i++) {
        $sequencia = '';
        $sequencia .= $texto[$i];
        for ($j = $i+1; $j < strlen($texto); $j++) {
            if ($texto[$i] == $texto[$j]) {
                $sequencia .= $texto[$j];
            } else {
                if(strlen($sequencia) > $num_repeticao_permitida && !in_array($sequencia, array('k'))) {
                    $texto = str_replace($sequencia, $sequencia[0], $texto);
                }
                break;
            }
        }
    }
    $texto = ' '.$texto.' ';//Adiciona espaco antes e depois do texto para substituir abreviacao no inicio e no final caso tenha

    // Expandir palavras abreviadas
    $texto= preg_replace($palavras_erradas, $palavras_certas, str_minuscula($texto));

    $texto = substr($texto, 1, strlen($texto)-1);//Remove espacos em branco adicionado antes das substituicoes

    foreach ($pontuacoes as $pontuacao){
        $texto = preg_replace("/" . $pontuacao . "(?=" . $pontuacao . ")/", "", $texto);
    }

    // Prepara paragrafo
    $texto = str_replace("", "[:p:]", $texto);

    // Acerta maiúscula e minúscula e inicia as sentenças com a primeira letra maiúscula
    $array = explode(" ", $texto);
    $novo_texto = "";
    $tam_array = count($array);

    for ($i = 0; $i < $tam_array; ++$i) {
        $palavra = $array[$i];

        if (comparaPalavraMaiuscula($palavra))
            $nova_palavra = str_minuscula($palavra);
        else
            $nova_palavra = $palavra;

        $caracter_anterior = ($i > 0 ? substr($array[$i - 1], -1) : ' ');
        $caracter_anterior_paragrafo = ($i > 0 ? substr($array[$i - 1], -5) : ' ');

        if (in_array($caracter_anterior, array('.', '!', '?')) || $i == 0)
            $nova_palavra = primeira_maiuscula($nova_palavra);


        $novo_texto .= $nova_palavra . " ";
    }

    $texto = $novo_texto;

    // Adicionar espaçoes depois das pontuações e remover antes
    for ($i = 0; $i < count($pontuacoes); ++$i)
    {
        $ponto = $pontuacoes[$i];
        $texto = str_replace(" " . $ponto . " ",$ponto . " ",$texto);
        $texto = str_replace(" " . $ponto,$ponto . " ",$texto);
        $texto = str_replace($ponto,$ponto . " ",$texto);
    }

    // Acerta parênteses
    $texto = str_replace(" ( ", " (", $texto);
    $texto = str_replace("( ", " (", $texto);
    $texto = str_replace("(", " (", $texto);
    $texto = str_replace(" ) ", ") ", $texto);
    $texto = str_replace(" )", ") ", $texto);
    $texto = str_replace(")", ") ", $texto);

    // Adicionar paragrafo
    $texto = str_replace("\n", "", $texto);
    $texto = str_replace("\r", "", $texto);

    for ($i = 0; $i <= 10; ++$i)
        $texto = str_replace("[:p:][:p:]", "[:p:]", $texto);

    $array = explode("[:p:]", $texto);
    $novo_texto = "";
    $tam_array = count($array);
    for ($i = 0; $i < $tam_array; ++$i)
    {
        $paragrafo = $array[$i];

        $paragrafo = trim($paragrafo);
        $paragrafo = trim($paragrafo, ",");
        //error_log("PARAGRAFO = " . $paragrafo);
        $paragrafo = primeira_maiuscula($paragrafo);

        if ($paragrafo == "") break;

        $ultimo_caracter = substr($paragrafo, -1);

        if ($ultimo_caracter != '.' && $ultimo_caracter != '!' && $ultimo_caracter != '?' && $ultimo_caracter != ':' && $ultimo_caracter != ';' && $ponto_final)
            $paragrafo .= ".";

        if ($i != $tam_array)
            $novo_texto .= $paragrafo . "";
    }

    $texto = $novo_texto;

    return $texto;
}

?>