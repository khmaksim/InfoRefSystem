<?php
namespace command;

class AddEnterprise extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$enterpriseMapper = \base\RequestRegistry::getEnterpriseMapper();
			
			$enterprise = new \domain\Enterprise();  			
  			$enterprise->name = $request->getProperty('name');
  			$enterprise->location = $request->getProperty('location');
  			$enterprise->head = $request->getProperty('head');
			
			$enterpriseMapper->insert($enterprise);
			if (!is_null($enterprise->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>