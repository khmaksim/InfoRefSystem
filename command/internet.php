<?php
namespace command;

class Internet extends Command {
    function doExecute(\controller\Request $request) {
    	$internetMapper = \base\RequestRegistry::getInternetMapper();
    	$departmentMapper = \base\RequestRegistry::getDepartmentMapper();

    	$id_department_list = $request->getProperty('deparment');
    	if (!is_null($id_department_list)) {
    		$collection = $internetMapper->findByDepartment($id_department_list);	
    	}
    	else
    		$collection = $internetMapper->findAll();

    	$request->setProperty('internet_list', $collection->getGenerator());

    	$collection1 = $departmentMapper->getTree();
        $request->setProperty('department_tree', $collection1->getGenerator());
        
        return self::statuses('CMD_OK');
    }
}
?>