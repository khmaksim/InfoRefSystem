<?php
namespace command;

class AddPhonenumberType extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$phonenumberTypeMapper = \base\RequestRegistry::getPhonenumberTypeMapper();
			
			$phonenumber_type = new \domain\PhonenumberType();  			
  			$phonenumber_type->name = $request->getProperty('name');
			
			$phonenumberTypeMapper->insert($phonenumber_type);
			if (!is_null($phonenumber_type->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>