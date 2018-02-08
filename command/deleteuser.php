<?php
namespace command;

class DeleteUser extends Command {
    function doExecute(\controller\Request $request) {
    	$userMapper = \base\RequestRegistry::getUserMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$user = $userMapper->find($id);
    		
    		if (!is_null($user)) {
				$userMapper->delete($user);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>