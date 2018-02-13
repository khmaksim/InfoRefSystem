<?php
namespace command;

class DeletePhoneType extends Command {
    function doExecute(\controller\Request $request) {
    	$phoneTypeMapper = \base\RequestRegistry::getPhoneTypeMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$phone_type = $phoneTypeMapper->find($id);
    		
    		if (!is_null($phone_type)) {
				$phoneTypeMapper->delete($phone_type);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>