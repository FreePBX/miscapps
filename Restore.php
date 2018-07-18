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
}