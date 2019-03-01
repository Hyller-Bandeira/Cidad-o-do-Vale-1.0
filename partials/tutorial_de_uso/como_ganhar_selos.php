<?php
    require 'phpsqlinfo_dbinfo.php';

    $query = "SELECT nomeSelo, descricaoSelo, imagemSelo
              FROM selosconquistas
              WHERE seloAtivo = '1'
              ORDER BY nomeSelo ASC";
    $result = $connection->query($query);
?>

<div class="row" style="margin-top: 0;">
    <div class="col-sm-12">
        <?php while ($row = $result->fetch_array()) : ?>
            <div class="col-md-4">
                <div class="well" style="padding: 0 8px; min-height: 150px;">
                    <div class="text-center" style="margin: 5px 0;min-height: 42px;"><span class="text-warning vcenter"><strong><?php echo $row['nomeSelo']; ?></strong></span></div>
                    <div class="row" style="margin: 0;">
                        <div class="col-sm-3 vcenter" style="padding: 0;">
                            <img class="img-responsive" src="images/selos/<?php echo $row['imagemSelo']; ?>">
                        </div>
                        <div class="col-sm-9 vcenter" style="padding: 0 0 0 5px;">
                            <div style="padding: 5px; text-align: justify; text-indent: 20px;"><small style="font-size: 80%;"><?php echo $row['descricaoSelo']; ?></small></div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div><!--/col-12-->
</div><!--/row-->


