<?php
namespace command;

class AddScientificWork extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$scientificMapper = \base\RequestRegistry::getScientificMapper();
			
			$scientific_work = new \domain\ScientificWork();  			
  			$scientific_work->year = $request->getProperty('year');
			
			$scientificMapper->insert($scientific_work);
			if (!is_null($scientific_work->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>