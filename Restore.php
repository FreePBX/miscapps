<?php
namespace FreePBX\modules\Miscapps;
use FreePBX\modules\Backup as Base;
class Restore Extends Base\RestoreBase{
	public function runRestore($jobid){
		$configs = $this->getConfigs();
		foreach ($configs['data'] as $destination) {
			$this->FreePBX->Miscapps->upsert($destination['miscapps_id'], $destination['description'], $destination['ext'], $destination['dest'], $destination['enabled']);
		}
		$this->importFeatureCodes($config['features']);
	}
	public function processLegacy($pdo, $data, $tables, $unknownTables){
		$this->restoreLegacyDatabase($pdo);
		$this->restoreLegacyFeatureCodes($pdo);
	}
}
