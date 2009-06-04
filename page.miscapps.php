<?php 
/** Misc Applications module for FreePBX 2.2+
 * Copyright 2006 Greg MacLellan
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 * 
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 */

$tabindex = 0;
$action = isset($_POST['action']) ? $_POST['action'] :  '';
if (isset($_POST['delete'])) $action = 'delete'; 


$miscapp_id = isset($_POST['miscapp_id']) ? $_POST['miscapp_id'] :  false;
$description = isset($_POST['description']) ? $_POST['description'] :  '';
$ext = isset($_POST['ext']) ? $_POST['ext'] :  '';
$dest = isset($_POST['dest']) ? $_POST['dest'] :  '';
$enabled = isset($_POST['enabled']) ? (!empty($_POST['enabled'])) : true;

if (isset($_POST['goto0']) && $_POST['goto0']) {
	$dest = $_POST[ $_POST['goto0'].'0' ];
}


switch ($action) {
	case 'add':
		$conflict_url = array();
		$usage_arr = framework_check_extension_usage($ext);
		if (!empty($usage_arr)) {
			$conflict_url = framework_display_extension_usage_alert($usage_arr);
		} else {
			miscapps_add($description, $ext, $dest);
			needreload();
			redirect_standard();
		}
	break;
	// TODO: need to lookup the current extension based on the id and if it is changing
	//       do a check to make sure it doesn't conflict. If not changing, np.
	//
	case 'edit':
		$fc = new featurecode('miscapps', 'miscapp_'.$miscapp_id);
		$conflict_url = array();
		if ($fc->getDefault() != $ext) {
			$usage_arr = framework_check_extension_usage($ext);
			if (!empty($usage_arr)) {
				$conflict_url = framework_display_extension_usage_alert($usage_arr);
			}
		}
		if (empty($conflict_url)) {
			miscapps_edit($miscapp_id, $description, $ext, $dest, $enabled);
			needreload();
			redirect_standard('extdisplay');
		}
	break;
	case 'delete':
		miscapps_delete($miscapp_id);
		needreload();
		redirect_standard();
	break;
}


?> 
</div>

<div class="rnav"><ul>
<?php 

echo '<li><a href="config.php?display=miscapps&amp;type=setup">'._('Add Misc Application').'</a></li>';

foreach (miscapps_list() as $row) {
	echo '<li><a href="config.php?display=miscapps&amp;type=setup&amp;extdisplay='.$row['miscapps_id'].'" class="">'.$row['description'].'</a></li>';
}

?>
</ul></div>

<div class="content">

<?php

if ($extdisplay) {
	// load
	$row = miscapps_get($extdisplay);
	
	$description = $row['description'];
	$ext = $row['ext'];
	$dest = $row['dest'];
	$enabled = $row['enabled'];

	echo "<h2>"._("Edit Misc Application")."</h2>";
} else {
	echo "<h2>"._("Add Misc Application")."</h2>";
}

$helptext = _("Misc Applications are for adding feature codes that you can dial from internal phones that go to various destinations available in FreePBX. This is in contrast to the <strong>Misc Destinations</strong> module, which is for creating destinations that can be used by other FreePBX modules to dial internal numbers or feature codes.");
echo $helptext;
?>

<?php if (!empty($conflict_url)) {
      	echo "<h5>"._("Conflicting Extensions")."</h5>";
      	echo implode('<br .>',$conflict_url);
      }
?>

<form name="editMiscapp" action="<?php  $_SERVER['PHP_SELF'] ?>" method="post" onsubmit="return checkMiscapp(editMiscapp);">
	<input type="hidden" name="extdisplay" value="<?php echo $extdisplay; ?>">
	<input type="hidden" name="miscapp_id" value="<?php echo $extdisplay; ?>">
	<input type="hidden" name="action" value="<?php echo ($extdisplay ? 'edit' : 'add'); ?>">
	<table>
	<tr><td colspan="2"><h5><?php  echo ($extdisplay ? _("Edit Misc Application") : _("Add Misc Application")) ?><hr></h5></td></tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Description")?>:<span><?php echo _("The name of this application")?></span></a></td>
		<td><input size="15" type="text" name="description" value="<?php  echo $description; ?>" tabindex="<?php echo ++$tabindex;?>"></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Feature Code")?>:<span><?php echo _("The feature code/extension users can dial to access this application. This can also be modified on the Feature Codes page.")?></span></a></td>
		<td><input type="text" name="ext" value="<?php echo $ext; ?>"  tabindex="<?php echo ++$tabindex;?>"/></td>
	</tr>
	<tr>
		<td><a href="#" class="info"><?php echo _("Feature Status")?>:<span><?php echo _("If this code is enabled or not.")?></span></a></td>
		<td><select name="enabled" tabindex="<?php echo ++$tabindex;?>">
			<option value="1" <?php if ($enabled) echo "SELECTED"; ?>><?php echo _("Enabled");?></option>
			<option value="0" <?php if (!$enabled) echo "SELECTED"; ?>><?php echo _("Disabled");?></option>
		</select></td>
	</tr>
	
	<tr><td colspan="2"><br><h5><?php echo _("Destination")?>:<hr></h5></td></tr>

<?php 
//draw goto selects
echo drawselects($dest,0);
?>
			
			<tr>
			<td colspan="2"><br><input name="Submit" type="submit" value="<?php echo _("Submit Changes")?>" tabindex="<?php echo ++$tabindex;?>">
			<?php if ($extdisplay) { echo '&nbsp;<input name="delete" type="submit" value="'._("Delete").'">'; } ?>
			</td>		
			
			</tr>
			</table>
			</form>
			
			
<script language="javascript">
<!--

function checkMiscapp(theForm) {
	var msgInvalidDescription = "<?php echo _('Invalid description specified'); ?>";

	// set up the Destination stuff
	setDestinations(theForm, '_post_dest');

	// form validation
	defaultEmptyOK = false;	
	if (isEmpty(theForm.description.value))
		return warnInvalid(theForm.description, msgInvalidDescription);

	if (!validateDestinations(theForm, 1, true))
		return false;

	return true;
}
//-->
</script>
