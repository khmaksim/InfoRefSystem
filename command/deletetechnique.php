<?php
namespace command;

class DeleteTechnique extends Command {
    function doExecute(\controller\Request $request) {
    	$techniqueMapper = \base\RequestRegistry::getTechniqueMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$technique = $techniqueMapper->find($id);
    		
    		if (!is_null($technique)) {
				$techniqueMapper->delete($technique);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>