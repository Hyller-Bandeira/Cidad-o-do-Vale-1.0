<?php
    require 'src/class.eyemysqladap.inc.php';
    require 'src/class.eyedatagrid.inc.php';
    require 'phpsqlinfo_dbinfo.php';

    $id_usuario = (isset($_GET['id']) ? $_GET['id'] : '');

    // Load the database adapter
    $db = new EyeMySQLAdap('localhost', $username, $password, $database);

    // Load the datagrid class
    $x = new EyeDataGrid($db);

    // Set the query
    $x->setQuery("*", "colaboracao", 'codColaboracao', 'codUsuario = '.$id_usuario );

    // Allows filters
    $x->allowFilters();

    // Change headers text
    $x->setColumnHeader('desTituloAssunto', 'Título');
    $x->setColumnHeader('desColaboracao', 'Descrição');
    $x->setColumnHeader('datahoraCriacao', 'Data e Hora da Criação');
    $x->setColumnHeader('codCategoriaEvento', 'Categoria');
    $x->setColumnHeader('codTipoEvento', 'Tipo');

    $x->setColumnHeader('dataHoraOcorrencia', 'Data e Hora da Ocorrência');
    $x->setColumnHeader('numLatitude', 'Latitude');
    $x->setColumnHeader('numLongitude', 'Longitude');
    $x->setColumnHeader('tipoStatus', 'Status');
    $x->setColumnHeader('desJustificativa', 'Justificativa');
    $x->setColumnHeader('zoom', 'Nível de Zoom');

    // Hide codColaboracao Column
    $x->hideColumn('codUsuario', 'Email do Usuário');
    $x->hideColumn('codColaboracao');
    $x->hideColumn('desTituloAssuntoSemFiltro');
    $x->hideColumn('desColaboracaoSemFiltro');
    $x->hideColumn('desJustificativa');
    $x->hideColumn('numLatitude');
    $x->hideColumn('numLongitude');
    $x->hideColumn('ip');

    // Change column type
    $x->setColumnType('dataHoraOcorrencia', EyeDataGrid::TYPE_DATE, 'd/m/Y - H:i:s', true); // Change the date format
    $x->setColumnType('datahoraCriacao', EyeDataGrid::TYPE_DATE, 'd/m/Y - H:i:s', true); // Change the date format
    $x->setColumnType('tipoStatus', EyeDataGrid::TYPE_ARRAY, array('a' => 'Aprovado', 'A' => 'Aprovado', 'r' => 'Reprovado', 'R' => 'Reprovado', 'e' => 'Em Avaliação', 'E' => 'Em Avaliação')); // Convert db values to something better

    //--------------------------------------------------//

    $campo = array();
    $consultacategoriaevento =  $connection->query("SELECT * FROM categoriaevento ");

    while($rowcategoriaevento = $consultacategoriaevento->fetch_assoc())
        $campo[$rowcategoriaevento['codCategoriaEvento']] = $rowcategoriaevento['desCategoriaEvento'];

    $x->setColumnType('codCategoriaEvento', EyeDataGrid::TYPE_ARRAY, $campo);

    //--------------------------------------------------//

    $campo2 = array();
    $consultacodTipoEvento = $connection->query("SELECT * FROM tipoevento ");

    while($rowcodTipoEvento = $consultacodTipoEvento->fetch_assoc())
        $campo2[$rowcodTipoEvento['codTipoEvento']] = $rowcodTipoEvento['desTipoEvento'];

    $x->setColumnType('codTipoEvento', EyeDataGrid::TYPE_ARRAY, $campo2);

    //--------------------------------------------------//

    $campo3 = array();
    $consultaUsuario = $connection->query("SELECT * FROM usuario ");

    while($rowUsuario = $consultaUsuario->fetch_assoc())
        $campo3[$rowUsuario['codUsuario']] = $rowUsuario['endEmail'];

    $x->setColumnType('codUsuario', EyeDataGrid::TYPE_ARRAY, $campo3);

    //--------------------------------------------------//

    // Add custom control, order does matter
    $x->addCustomControl(EyeDataGrid::CUSCTRL_TEXT, "mostrarColaboracao(%codColaboracao%, %numLatitude%, %numLongitude%)", EyeDataGrid::TYPE_ONCLICK, 'Visualizar');

    if (EyeDataGrid::isAjaxUsed())
    {
        $x->printTable();
        exit;
}