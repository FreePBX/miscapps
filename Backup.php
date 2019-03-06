<?php
namespace FreePBX\modules\Miscapps;
use FreePBX\modules\Backup as Base;
class Backup Extends Base\BackupBase{
	public function runBackup($id,$transaction){
		$configs = $this->FreePBX->Miscapps->listApps(true);
		$this->addConfigs([
			'data' => $configs,
			'features' => $this->dumpFeatureCodes()
		]);
	}
}