<?php
namespace command;

class EditMedalType extends Command {
    function doExecute(\controller\Request $request) {
    	$medalTypeMapper = \base\RequestRegistry::getMedalTypeMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$medal_type = $medalTypeMapper->find($id);
    			if (!is_null($medal_type)) {
					$request->setProperty('medal_type', $medal_type);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$medal_type = $medalTypeMapper->find($id);

	  			$medal_type->name = $request->getProperty('name');
                $medalTypeMapper->update($medal_type);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>