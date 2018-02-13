<?php
namespace command;

class AddPhoneType extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$phoneTypeMapper = \base\RequestRegistry::getPhoneTypeMapper();
			
			$phone_type = new \domain\PhoneType();  			
  			$phone_type->name = $request->getProperty('name');
			
			$phoneTypeMapper->insert($phone_type);
			if (!is_null($phone_type->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>