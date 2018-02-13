<?php
namespace command;

class AddEmailType extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$emailTypeMapper = \base\RequestRegistry::getEmailTypeMapper();
			
			$email_type = new \domain\EmailType();  			
  			$email_type->name = $request->getProperty('name');
			
			$emailTypeMapper->insert($email_type);
			if (!is_null($email_type->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>