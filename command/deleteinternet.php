<?php
namespace command;

class DeleteInternet extends Command {
    function doExecute(\controller\Request $request) {
    	$internetMapper = \base\RequestRegistry::getInternetMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$internet = $internetMapper->find($id);
    		
    		if (!is_null($internet)) {
				$internetMapper->delete($internet);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>