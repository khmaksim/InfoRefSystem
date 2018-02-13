<?php
namespace command;

class AddAccessType extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$accessTypeMapper = \base\RequestRegistry::getAccessTypeMapper();
			
			$access_type = new \domain\AccessType();  			
  			$access_type->name = $request->getProperty('name');
			
			$accessTypeMapper->insert($access_type);
			if (!is_null($access_type->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>