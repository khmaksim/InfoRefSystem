<?php
namespace command;

class EditAccessType extends Command {
    function doExecute(\controller\Request $request) {
    	$accessTypeMapper = \base\RequestRegistry::getAccessTypeMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$access_type = $accessTypeMapper->find($id);
    			if (!is_null($access_type)) {
					$request->setProperty('access_type', $access_type);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$access_type = $accessTypeMapper->find($id);

	  			$access_type->name = $request->getProperty('name');
                $accessTypeMapper->update($access_type);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>