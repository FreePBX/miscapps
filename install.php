<?php

global $db;
global $amp_conf;

$results = array();
$sql = "SELECT miscapps_id, dest FROM miscapps";
$results = $db->getAll($sql, DB_FETCHMODE_ASSOC);
if (!DB::IsError($results)) { // error - table must not be there
	foreach ($results as $result) {
		$old_dest    = $result['dest'];
		$miscapps_id = $result['miscapps_id'];

		$new_dest = merge_ext_followme(trim($old_dest));
		if ($new_dest != $old_dest) {
			$sql = "UPDATE miscapps SET dest = '$new_dest' WHERE miscapps_id = $miscapps_id  AND dest = '$old_dest'";
			$results = $db->query($sql);
			if(DB::IsError($results)) {
				die($results->getMessage());
			}
		}
	}
}

?>
