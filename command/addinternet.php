<?php
namespace command;

class AddInternet extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$internetMapper = \base\RequestRegistry::getInternetMapper();
			
			$internet = new \domain\Internet();  			
  			$internet->location = $request->getProperty('location');
  			$internet->permission = $request->getProperty('permission');
  			$internet->reg_number = $request->getProperty('reg_number');
            $internet->composition = $request->getProperty('composition');
            $internet->order = $request->getProperty('order');
            $internet->email = $request->getProperty('email');
            $internet->id_department = $request->getProperty('id_department');
			
			$internetMapper->insert($internet);
			if (!is_null($internet->id)) {
				return self::statuses('CMD_OK');
			}

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>