<?php
namespace command;

class DeleteInterpassportType extends Command {
    function doExecute(\controller\Request $request) {
    	$interpassportTypeMapper = \base\RequestRegistry::getInterpassportTypeMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$interpassport_type = $interpassportTypeMapper->find($id);
    		
    		if (!is_null($interpassport_type)) {
				$interpassportTypeMapper->delete($interpassport_type);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>