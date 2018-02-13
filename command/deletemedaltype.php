<?php
namespace command;

class DeleteMedalType extends Command {
    function doExecute(\controller\Request $request) {
    	$medalTypeMapper = \base\RequestRegistry::getMedalTypeMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$medal_type = $medalTypeMapper->find($id);
    		
    		if (!is_null($medal_type)) {
				$medalTypeMapper->delete($medal_type);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>