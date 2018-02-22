<?php
namespace command;

class DeleteDepartment extends Command {
    function doExecute(\controller\Request $request) {
    	$departmentMapper = \base\RequestRegistry::getDepartmentMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$department = $departmentMapper->find($id);
    		
    		if (!is_null($department)) {
				$departmentMapper->delete($department);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>