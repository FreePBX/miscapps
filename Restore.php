<?php
namespace FreePBX\modules\Miscapps;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
  public function runRestore($jobid){
    $configs = reset($this->getConfigs());
    foreach ($configs as $destination) {
        $this->FreePBX->Miscapps->upsert($destination['miscapps_id'], $destination['description'], $destination['ext'], $destination['dest'], $destination['enabled']);
    }
  }
  public function processLegacy($pdo, $data, $tables, $unknownTables, $tmpfiledir){
    $tables = array_flip($tables+$unknownTables);
    if(!isset(tables['miscapps']))
      return $this;
    }
    $bmo = $this->FreePBX->Miscapps;
    $bmo->setDatabase($pdo);
    $data = $bmo->listApps(true);
    $bmo->resetDatabase();
    foreach ($data as $destination) {
      $bmo->upsert($destination['miscapps_id'], $destination['description'], $destination['ext'], $destination['dest'], $destination['enabled']);
    }
    return $this;
  }
}