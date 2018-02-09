<?php
namespace command;

class EditPosition extends Command {
    function doExecute(\controller\Request $request) {
    	$positionMapper = \base\RequestRegistry::getPositionMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$position = $positionMapper->find($id);
    			if (!is_null($position)) {
					$request->setProperty('position', $position);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$position = $positionMapper->find($id);

	  			$position->name = $request->getProperty('name');
                $positionMapper->update($position);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>