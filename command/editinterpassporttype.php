<?php
namespace command;

class EditInterpassportType extends Command {
    function doExecute(\controller\Request $request) {
    	$interpassportTypeMapper = \base\RequestRegistry::getInterpassportTypeMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$interpassport_type = $interpassportTypeMapper->find($id);
    			if (!is_null($interpassport_type)) {
					$request->setProperty('interpassport_type', $interpassport_type);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$interpassport_type = $interpassportTypeMapper->find($id);

	  			$interpassport_type->name = $request->getProperty('name');
                $interpassportTypeMapper->update($interpassport_type);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>