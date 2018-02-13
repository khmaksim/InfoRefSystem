<?php
namespace command;

class AddInterpassportType extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$interpassportTypeMapper = \base\RequestRegistry::getInterpassportTypeMapper();
			
			$interpassport_type = new \domain\InterpassportType();  			
  			$interpassport_type->name = $request->getProperty('name');
			
			$interpassportTypeMapper->insert($interpassport_type);
			if (!is_null($medal_type->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>