<?php
namespace command;

class AddCity extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$cityMapper = \base\RequestRegistry::getCityMapper();
			
			$city = new \domain\City();  			
  			$city->name = $request->getProperty('name');
			
			$cityMapper->insert($city);
			if (!is_null($city->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>