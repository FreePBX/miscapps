<div id="toolbar-rnav">
  <a href='?display=miscapps' class="btn btn-default"><i class = 'fa fa-plus'></i>&nbsp;<?php echo _("Add Misc App")?></a>
</div>
<table data-url="ajax.php?module=miscapps&amp;command=rnav" data-toolbar="#toolbar-rnav" data-cache="false" data-toggle="table" data-search="true" class="table" id="table-miscapps-side">
    <thead>
        <tr>
            <th data-sortable="true" data-field="ext"><?php echo _('Extension')?></th>
            <th data-sortable="true" data-field="description"><?php echo _('Description')?></th>
        </tr>
    </thead>
</table>

<script type="text/javascript">

$("#table-miscapps-side").on('click-row.bs.table',function(e,row,elem){
  window.location = '?display=miscapps&extdisplay='+row['miscapps_id'];
})
</script>
