<?php
namespace command;

class DeleteAddressType extends Command {
    function doExecute(\controller\Request $request) {
    	$addressTypeMapper = \base\RequestRegistry::getAddressTypeMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$address_type = $addressTypeMapper->find($id);
    		
    		if (!is_null($address_type)) {
				$addressTypeMapper->delete($address_type);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>