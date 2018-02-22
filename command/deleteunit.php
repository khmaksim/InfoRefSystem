<?php
namespace command;

class DeleteUnit extends Command {
    function doExecute(\controller\Request $request) {
    	$unitMapper = \base\RequestRegistry::getUnitMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$unit = $unitMapper->find($id);
    		
    		if (!is_null($unit)) {
				$unitMapper->delete($unit);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>