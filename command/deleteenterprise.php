<?php
namespace command;

class DeleteEnterprise extends Command {
    function doExecute(\controller\Request $request) {
    	$enterpriseMapper = \base\RequestRegistry::getEnterpriseMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$enterprise = $enterpriseMapper->find($id);
    		
    		if (!is_null($enterprise)) {
				$enterpriseMapper->delete($enterprise);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>