<?php
namespace command;

class DeletePhonenumberType
umberType extends Command {
    function doExecute(\controller\Request $request) {
    	$phonenumberTypeMapper = \base\RequestRegistry::getPhonenumberTypeMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$phonenumber_type = $phonenumberTypeMapper->find($id);
    		
    		if (!is_null($phonenumber_type)) {
				$phonenumberTypeMapper->delete($phonenumber_type);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>