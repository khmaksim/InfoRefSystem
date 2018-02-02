<?php
namespace command;

class TelephoneDirectoryDepartment extends Command {
    function doExecute(\controller\Request $request) {
    	$departmentMapper = \base\RequestRegistry::getDepartmentMapper();
    	
    	$id = $request->getProperty('id_department');
    	if (!is_null($id)) {
    		$department = $departmentMapper->find($id);
        	$request->setProperty('department', $department);

        	return self::statuses('CMD_OK');
    	}
    }
}
?>