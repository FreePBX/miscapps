<?php

global $db;
global $amp_conf;

// Don't bother uninstalling feature codes, now module_uninstall does it

echo "dropping table miscapps..";
sql("DROP TABLE IF EXISTS `miscapps`");
echo "done<br>\n";

?>
