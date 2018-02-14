<?php
namespace command;

class DeleteScientificWork extends Command {
    function doExecute(\controller\Request $request) {
    	$scientificWorkMapper = \base\RequestRegistry::getScientificWorkMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$scientific_work = $scientificWorkMapper->find($id);
    		
    		if (!is_null($scientific_work)) {
				$scientificWorkMapper->delete($scientific_work);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>