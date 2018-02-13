<?php
namespace command;

class EditCity extends Command {
    function doExecute(\controller\Request $request) {
    	$cityMapper = \base\RequestRegistry::getCityMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$city = $cityMapper->find($id);
    			if (!is_null($city)) {
					$request->setProperty('city', $city);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$city = $cityMapper->find($id);

	  			$city->name = $request->getProperty('name');
                $cityMapper->update($city);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>