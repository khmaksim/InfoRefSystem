<?php
namespace command;

class EditEmailType extends Command {
    function doExecute(\controller\Request $request) {
    	$emailTypeMapper = \base\RequestRegistry::getEmailTypeMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$email_type = $emailTypeMapper->find($id);
    			if (!is_null($email_type)) {
					$request->setProperty('email_type', $email_type);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$email_type = $emailTypeMapper->find($id);

	  			$email_type->name = $request->getProperty('name');
                $emailTypeMapper->update($email_type);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>