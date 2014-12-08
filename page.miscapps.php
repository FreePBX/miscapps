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

?>
<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9">
			<div class="fpbx-container">
				<form autocomplete="off" class="fpbx-submit" name="editMiscapp" action="config.php?display=miscapps" method="post" data-fpbx-delete="<?php echo $delurl ?>" role="form" onsubmit="return checkMiscapp(editMiscapp);">
				<input type="hidden" name="extdisplay" value="<?php echo $extdisplay; ?>">
				<input type="hidden" name="miscapp_id" value="<?php echo $extdisplay; ?>">
				<input type="hidden" name="action" value="<?php echo ($extdisplay ? 'edit' : 'add'); ?>">
				<div class="display full-border">
					<div>
						<h1><?php echo $title ?></h1>
						<?php echo $warn ?>
						<p><?php echo $helptext ?></p>
					</div>
					<!--Descripton-->
					<div class="element-container">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="description"><?php echo _("Description:")?></label>
											<i class="fa fa-question-circle fpbx-help-icon" data-for="description"></i>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" id="description" name="description" value="<?php echo (isset($description) ? $description : ''); ?>" tabindex="<?php echo ++$tabindex;?>" >
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span id="description-help" class="help-block fpbx-help-block"><?php echo _("The name of this application")?></span>
							</div>
						</div>
					</div>
					<!--End Description-->
					<!--Feaurecode-->
					<div class="element-container">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="ext"><?php echo _("Feature Code")?></label>
											<i class="fa fa-question-circle fpbx-help-icon" data-for="ext"></i>
										</div>
										<div class="col-md-9">
											<input type="text" class="form-control" id="extdisplay" name="ext" value="<?php echo (isset($ext) ? $ext : ''); ?>" tabindex="<?php echo ++$tabindex;?>" >
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span id="extd-help" class="help-block fpbx-help-block"><?php echo _("The feature code/extension users can dial to access this application. This can also be modified on the Feature Codes page.")?></span>
							</div>
						</div>
					</div>					
					<!--END Feaurecode-->
					<!--Enabled-->
					<div class="element-container">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3 radioset">
											<input type="checkbox" id="enabled" name="enabled" <?php if ($enabled) echo "checked"; ?>>
											<label for="enabled">Enabled</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					<!--End Enabled-->
					<!--Destination-->
					<div class="element-container">
						<div class="row">
							<div class="col-md-12">
								<div class="row">
									<div class="form-group">
										<div class="col-md-3">
											<label class="control-label" for="goto0"><?php echo _("Destination") ?></label>
											<i class="fa fa-question-circle fpbx-help-icon" data-for="goto0"></i>
										</div>
										<div class="col-md-9">
											<?php echo drawselects($dest,0);?>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<span id="goto0-help" class="help-block fpbx-help-block"><?php echo _("Chose the destination for this app")?></span>
							</div>
						</div>
					</div>
					<!--End Destination-->
				</div>
			</form>
			</div>
		</div>
	   <?php echo $bootnav ?>
	</div>
</div>
