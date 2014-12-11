<?php
if (!defined('FREEPBX_IS_AUTH')) { die('No direct script access allowed'); }
//	License for all code of this FreePBX module can be found in the license file inside the module directory
//	Copyright 2006-2014 Schmooze Com Inc.

$tabindex = 0;


$helptext = _("Misc Applications are for adding feature codes that you can dial from internal phones that go to various destinations available in FreePBX. This is in contrast to the <strong>Misc Destinations</strong> module, which is for creating destinations that can be used by other FreePBX modules to dial internal numbers or feature codes.");

if ($extdisplay) {
	// load
	$row = miscapps_get($extdisplay);
	$id = $row['miscapps_id'];
	$description = $row['description'];
	$ext = $row['ext'];
	$dest = $row['dest'];
	$enabled = $row['enabled'];
	$helptext = '';
	$title = _("Edit Misc Application");
	$delurl = 'config.php?display=miscapps&action=delete&id=' . $id;
} else {
	$title = _("Add Misc Application");
	$id = "None";
	$delurl = '';
	//Enable by default
	$enabled = true;
}
//bootnav
$bootnav = '';
$bootnav .= '<div class="col-sm-3 hidden-xs bootnav">';
$bootnav .= '<div class="list-group">';
if($extdisplay == ''){
	$bootnav .= '<a href="config.php?display=miscapps&amp;type=setup" class="list-group-item active">'._("Add Misc Application").'</a>';
}else{
	$bootnav .= '<a href="config.php?display=miscapps&amp;type=setup" class="list-group-item">'._("Add Misc Application").'</a>';
}
foreach (miscapps_list() as $row) {
	$bootnav .= '<a class="list-group-item '.($extdisplay==$row['miscapps_id'] ? 'active':'').'" href="config.php?display=miscapps&amp;type=setup&amp;extdisplay='.$row['miscapps_id'].'">'.$row['description'].'</a>';
}
$bootnav .= '</div>';
$bootnav .= '</div>';
//end bootnav
$warn = '';
if (!empty($conflict_url)) {
	$warn .= '<div class="alert alert-danger" role="alert">';
	$warn .= '<i class="glyphicon glyphicon-exclamation-sign"></i>&nbsp;<h5>'._("Conflicting Extensions").'</h5>';
    $warn .= '<ul class="list-group">';
    foreach($conflict_url as $cu){
		$warn .= '<li class="list-group-item" id="iteminuse">' . $cu . '</li>';
     }
     $warn .= '</ul>';
     $warn .= '</div>';
 }

show_view(__DIR__."/views/main.php",array("delurl" => $delurl, "extdisplay" => $extdisplay, "description" => $description, "ext" => $ext, "enabled" => $enabled, "dest" => $dest, "title" => $title, "warn" => $warn, "helptext" => $helptext, "bootnav" => $bootnav));
