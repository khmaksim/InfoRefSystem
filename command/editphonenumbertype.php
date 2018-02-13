<?php
namespace command;

class EditPhonenumberType extends Command {
    function doExecute(\controller\Request $request) {
    	$phonenumberTypeMapper = \base\RequestRegistry::getPhonenumberTypeMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$phonenumber_type = $phonenumberTypeMapper->find($id);
    			if (!is_null($phonenumber_type)) {
					$request->setProperty('phonenumber_type', $phonenumber_type);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$phonenumber_type = $phonenumberTypeMapper->find($id);

	  			$phonenumber_type->name = $request->getProperty('name');
                $phonenumberTypeMapper->update($phonenumber_type);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>