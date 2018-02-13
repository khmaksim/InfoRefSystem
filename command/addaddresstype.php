<?php
namespace command;

class AddAddressType extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$addressTypeMapper = \base\RequestRegistry::getAddressTypeMapper();
			
			$address_type = new \domain\AddressType();  			
  			$address_type->name = $request->getProperty('name');
			
			$addressTypeMapper->insert($address_type);
			if (!is_null($address_type->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>