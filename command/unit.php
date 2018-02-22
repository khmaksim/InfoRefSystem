<?php
namespace command;

class Unit extends Command {
    function doExecute(\controller\Request $request) {
    	$unitMapper = \base\RequestRegistry::getUnitMapper();
    	
    	$collection = $unitMapper->findAll();
    	$request->setProperty('unit_list', $collection->getGenerator());

        $departmentMapper = \base\RequestRegistry::getDepartmentMapper();
    	$id = $request->getProperty('id_department');
    	if (!is_null($id)) {
    		$department = $departmentMapper->find($id);
            $request->setProperty('department', $department);
        }
    	
        return self::statuses('CMD_OK');
    }
}
?>