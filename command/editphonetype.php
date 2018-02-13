<?php
namespace command;

class EditPhoneType extends Command {
    function doExecute(\controller\Request $request) {
    	$phoneTypeMapper = \base\RequestRegistry::getPhoneTypeMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$phone_type = $phoneTypeMapper->find($id);
    			if (!is_null($phone_type)) {
					$request->setProperty('phone_type', $phone_type);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$phone_type = $phoneTypeMapper->find($id);

	  			$phone_type->name = $request->getProperty('name');
                $phoneTypeMapper->update($phone_type);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>