<?php
/*
function miscapp_destinations() {
	// return an associative array with destination and description
	foreach (announcement_list() as $row) {
		$extens[] = array('destination' => 'app-announcement,ann-'.$row[0].',1', 'description' => $row[1]);
	}
	return $extens;
}
*/

function miscapps_contexts() {
	// return an associative array with context and description
	foreach (miscapps_list() as $row) {
		$contexts[] = array(
			'context' => 'app-miscapps-'.$row['miscapps_id'], 
			'description'=> 'Misc Application: '.$row['description'],
			'source' => 'Misc Applications',
		);
	}
	return $contexts;
}

function miscapps_get_config($engine) {
	global $ext;
	switch ($engine) {
		case 'asterisk':
			foreach (miscapps_list(true) as $row) {
				if ($row['enabled']) {
					$ext->add('app-miscapps-'.$row['miscapps_id'], $row['ext'], '', new ext_noop('Running miscapp '.$row['miscapps_id'].': '.$row['description']));
					$ext->add('app-miscapps-'.$row['miscapps_id'], $row['ext'], '', new ext_goto($row['dest']));
					
					$ext->addInclude('from-internal-additional', 'app-miscapps-'.$row['miscapps_id']);
				}
			}
		break;
	}
}


/**  Get a list of all miscapps
 * Optional parameter is get_ext. Potentially slow, because each row is extracted from the featurecodes table
 * one-by-one
 */
function miscapps_list($get_ext = false) {
	global $db;
	$sql = "SELECT miscapps_id, description, dest FROM miscapps ORDER BY description ";
	$results = $db->getAll($sql, DB_FETCHMODE_ASSOC);
	if(DB::IsError($results)) {
		die($results->getMessage()."<br><br>Error selecting from miscapps");	
	}
	
	if ($get_ext) {
		foreach (array_keys($results) as $idx) {
			$fc = new featurecode('miscapps', 'miscapp_'.$results[$idx]['miscapps_id']);
			$results[$idx]['ext'] = $fc->getCode();
			$results[$idx]['enabled'] = $fc->isEnabled();
		}
	}
	
	return $results;
}

function miscapps_get($miscapps_id) {
	global $db;
	$sql = "SELECT miscapps_id, description, ext, dest FROM miscapps WHERE miscapps_id = ".addslashes($miscapps_id);
	$row = $db->getRow($sql, DB_FETCHMODE_ASSOC);
	if(DB::IsError($row)) {
		die($row->getMessage()."<br><br>Error selecting row from miscapps");	
	}
	
	// we want to get the ext from featurecodes
	$fc = new featurecode('miscapps', 'miscapp_'.$row['miscapps_id']);
	$row['ext'] = $fc->getCode();
	$row['enabled'] = $fc->isEnabled();

	return $row;
}

function miscapps_add($description, $ext, $dest) {
	global $db;
	$sql = "INSERT INTO miscapps (description, ext, dest) VALUES (".
		"'".addslashes($description)."', ".
		"'".addslashes($ext)."', ".
		"'".addslashes($dest)."')";
	$result = $db->query($sql);
	if(DB::IsError($result)) {
		die($result->getMessage().$sql);
	}
	//get id..
	$miscapps_id = $db->getOne('SELECT LAST_INSERT_ID()');
	if (DB::IsError($miscapps_id)) {
		//TODO -- handle this
	}
	
	$fc = new featurecode('miscapps', 'miscapp_'.$miscapps_id);
	$fc->setDescription($description);
	$fc->setDefault($ext, true);
	$fc->update();
}

function miscapps_delete($miscapps_id) {
	global $db;
	$sql = "DELETE FROM miscapps WHERE miscapps_id = ".addslashes($miscapps_id);
	$result = $db->query($sql);
	if(DB::IsError($result)) {
		die($result->getMessage().$sql);
	}
	
	$fc = new featurecode('miscapps', 'miscapp_'.$miscapps_id);
	$fc->delete();
}

function miscapps_edit($miscapps_id, $description, $ext, $dest) { 
	global $db;
	$sql = "UPDATE miscapps SET ".
		"description = '".addslashes($description)."', ".
		"ext = '".addslashes($ext)."', ".
		"dest = '".addslashes($dest)."' ".
		"WHERE miscapps_id = ".addslashes($miscapps_id);
	$result = $db->query($sql);
	if(DB::IsError($result)) {
		die($result->getMessage().$sql);
	}
	
	$fc = new featurecode('miscapps', 'miscapp_'.$miscapps_id);
	$fc->setDescription($description);
	$fc->setCode($ext);
	$fc->update();
}

?>