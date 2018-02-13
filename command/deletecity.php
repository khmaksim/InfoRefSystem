<?php
namespace command;

class DeleteCity extends Command {
    function doExecute(\controller\Request $request) {
    	$cityMapper = \base\RequestRegistry::getCityMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$city = $cityMapper->find($id);
    		
    		if (!is_null($city)) {
				$cityMapper->delete($city);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>