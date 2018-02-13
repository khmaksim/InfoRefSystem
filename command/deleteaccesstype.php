<?php
namespace command;

class DeleteAccessType extends Command {
    function doExecute(\controller\Request $request) {
    	$accessTypeMapper = \base\RequestRegistry::getAccessTypeMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$access_type = $accessTypeMapper->find($id);
    		
    		if (!is_null($access_type)) {
				$accessTypeMapper->delete($access_type);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>