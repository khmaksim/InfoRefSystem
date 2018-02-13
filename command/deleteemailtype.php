<?php
namespace command;

class DeleteEmailType extends Command {
    function doExecute(\controller\Request $request) {
    	$emailTypeMapper = \base\RequestRegistry::getEmailTypeMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$email_type = $emailTypeMapper->find($id);
    		
    		if (!is_null($email_type)) {
				$emailTypeMapper->delete($email_type);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>