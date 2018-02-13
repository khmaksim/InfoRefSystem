<?php
namespace command;

class AddMedalType extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$medalTypeMapper = \base\RequestRegistry::getMedalTypeMapper();
			
			$medal_type = new \domain\MedalType();  			
  			$medal_type->name = $request->getProperty('name');
			
			$medalTypeMapper->insert($medal_type);
			if (!is_null($medal_type->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>