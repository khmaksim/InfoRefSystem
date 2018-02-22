<?php
namespace command;

class EditInternet extends Command {
    function doExecute(\controller\Request $request) {
    	$internetMapper = \base\RequestRegistry::getInternetMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$internet = $internetMapper->find($id);
    			if (!is_null($internet)) {
					$request->setProperty('internet', $internet);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$internet = $internetMapper->find($id);
                
                $internet->location = $request->getProperty('location');
                $internet->permission = $request->getProperty('permission');
                $internet->reg_number = $request->getProperty('reg_number');
                $internet->composition = $request->getProperty('composition');
                $internet->order = $request->getProperty('order');
                $internet->email = $request->getProperty('email');
                $internet->id_department = $request->getProperty('id_department');

                $internetMapper->update($internet);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>