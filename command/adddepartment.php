<?php
namespace command;

class AddDepartment extends Command {
    function doExecute(\controller\Request $request) {
        $departmentMapper = \base\RequestRegistry::getDepartmentMapper();
        
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $collection = $departmentMapper->findAll();
            
            $request->setProperty('department_list', $collection->getGenerator()) ;
        }
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$department = new \domain\department();  			
  			$department->fullname = $request->getProperty('fullname');
			$department->shortname = $request->getProperty('shortname');
            $department->dep_index = $request->getProperty('dep_index');
            $department->server_addr = $request->getProperty('server_addr');
            $department->note = $request->getProperty('note');
            $department->parent = $request->getProperty('parent');
            $department->active = $request->getProperty('active');
			
			$departmentMapper->insert($department);
			if (!is_null($department->id)) {
				return self::statuses('CMD_OK');
			}

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>