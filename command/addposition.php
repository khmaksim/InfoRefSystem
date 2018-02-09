<?php
namespace command;

class AddPosition extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$positionMapper = \base\RequestRegistry::getPositionMapper();
			
			$position = new \domain\Position();  			
  			$position->name = $request->getProperty('name');
			
			$positionMapper->insert($position);
			if (!is_null($position->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>