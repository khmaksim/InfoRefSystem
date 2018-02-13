<?php
namespace command;

class EditAddressType extends Command {
    function doExecute(\controller\Request $request) {
    	$addressTypeMapper = \base\RequestRegistry::getAddressTypeMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$address_type = $addressTypeMapper->find($id);
    			if (!is_null($address_type)) {
					$request->setProperty('address_type', $address_type);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$address_type = $addressTypeMapper->find($id);

	  			$address_type->name = $request->getProperty('name');
                $addressTypeMapper->update($address_type);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>