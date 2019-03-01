<script type="text/javascript">
	'use strict';

	var treeData =
	[
		<?php
			require 'phpsqlinfo_dbinfo.php';
			$consulta = $connection->query('SELECT * FROM categoriaevento');
			while ($row = $consulta->fetch_assoc())
			{?>
				{ title: "<?php  echo $row["desCategoriaEvento"];?>", key: <?php echo $row["codCategoriaEvento"]; ?>,

				children:
				[
					<?php
						$copia = $row["codCategoriaEvento"];
						$consulta2 = $connection->query("SELECT * FROM tipoevento WHERE codCategoriaEvento = '$copia' " );

						while($row2 = $consulta2->fetch_assoc())
						{?>
							{title: "<?php echo $row2["desTipoEvento"]; ?>", key: <?php echo $row["codCategoriaEvento"]; ?> + "-" + <?php echo $row2["codTipoEvento"]; ?>},
							<?php
						}
					?>
					{title: "Sugestao"}
				]
				},
				<?php
			}
		?>
		{title: "Sugestao", key: "sugestao"}
	];

	var tira_ultimo_elemento = treeData.pop();

	for (var i = 0; i < treeData.length; ++i)
		var removerAgora = treeData[i].children.pop();

	$(function()
	{
		$("#tree").dynatree
		({
			checkbox: true,
			selectMode: 3,
			children: treeData,
			onSelect: function(select, node)
			{
				// Get a list of all selected nodes, and convert to a key array:
				var selKeys = $.map(node.tree.getSelectedNodes(), function(node){ return node.data.key;	});
				$("#echoSelection3").text(selKeys.join(", "));
				document.getElementById("ids_filtros").value = selKeys.join(", ");

				// Get a list of all selected TOP nodes
				var selRootNodes = node.tree.getSelectedNodes(true);

				// ... and convert to a key array:
				var selRootKeys = $.map(selRootNodes, function(node) { return node.data.key; });
				$("#echoSelectionRootKeys3").text(selRootKeys.join(", "));
				$("#echoSelectionRoots3").text(selRootNodes.join(", "));
			},

			onDblClick: function(node, event) { node.toggleSelect(); },
			onKeydown: function(node, event)
			{
				if(event.which == 32)
				{
					node.toggleSelect();
					return false;
				}
			},

			// The following options are only required, if we have more than one tree on one page:
			// initId: "treeData",
			cookieId: "dynatree-Cb3",
			idPrefix: "dynatree-Cb3-"
		});
	});

	$("#btnDeselectAll").click(function()
	{
		$("#tree").dynatree("getRoot").visit(function(node) { node.select(false); });
		return false;
	});

	$("#btnSelectAll").click(function()
	{
		$("#tree").dynatree("getRoot").visit(function(node) { node.select(true); });
		return false;
	});
</script>