<?php
namespace command;

class DeletePosition extends Command {
    function doExecute(\controller\Request $request) {
    	$positionMapper = \base\RequestRegistry::getPositionMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$position = $positionMapper->find($id);
    		
    		if (!is_null($position)) {
				$positionMapper->delete($position);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>