<div id="toolbar-all">
	<a href="?display=miscapps&amp;action=add" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo _("Add Misc Application")?></a>
</div>
<table id="wcbgrid" data-url="ajax.php?module=miscapps&amp;command=rnav" data-escape="true" data-sortable="true" data-cache="false" data-toolbar="#toolbar-all" data-maintain-selected="true" data-show-columns="true" data-show-toggle="true" data-toggle="table" data-pagination="true" data-search="true" class="table table-striped">
	<thead>
		<tr>
			<th data-field="description"><?php echo _('Description')?></th>
			<th data-field="ext"><?php echo _('Extension')?></th>
			<th data-field="actions" data-formatter="linkFormatter"><?php echo _("Actions")?></th>
		</tr>
	</thead>
</table>
