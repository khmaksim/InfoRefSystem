<?php
namespace command;

class EditEnterprise extends Command {
    function doExecute(\controller\Request $request) {
    	$enterpriseMapper = \base\RequestRegistry::getEnterpriseMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$enterprise = $enterpriseMapper->find($id);
    			if (!is_null($enterprise)) {
					$request->setProperty('enterprise', $enterprise);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$enterprise = $enterpriseMapper->find($id);
                
	  			$enterprise->name = $request->getProperty('name');
                $enterprise->location = $request->getProperty('location');
                $enterprise->head = $request->getProperty('head');
                $enterprise->post = $request->getProperty('post');
				
                $enterpriseMapper->update($enterprise);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>