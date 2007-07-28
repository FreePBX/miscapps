<?php

global $db;
global $amp_conf;

$miscapps_arr = miscapps_list();
foreach ($miscapps_arr as $item) {
	echo "removing ".$item['description']."..";
	miscapps_delete($item['miscapps_id']);
	echo "done<br>\n";
}

echo "dropping table miscapps..";
sql("DROP TABLE IF EXISTS `miscapps`");
echo "done<br>\n";

?>
