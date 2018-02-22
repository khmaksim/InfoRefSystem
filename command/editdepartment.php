<?php
namespace command;

class EditDepartment extends Command {
    function doExecute(\controller\Request $request) {
    	$departmentMapper = \base\RequestRegistry::getDepartmentMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$department = $departmentMapper->find($id);
    			if (!is_null($department)) {
					$request->setProperty('department', $department);
                    $department_list = $departmentMapper->findAll();
                    $request->setProperty('department_list', $department_list->getGenerator());
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$department = $departmentMapper->find($id);
                
                $department->fullname = $request->getProperty('fullname');
                $department->shortname = $request->getProperty('shortname');
                $department->dep_index = $request->getProperty('dep_index');
                $department->server_addr = $request->getProperty('server_addr');
                $department->note = $request->getProperty('note');
                $department->parent = $request->getProperty('parent');
                $department->active = $request->getProperty('active');

                $departmentMapper->update($department);
                
				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>