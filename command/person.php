<?php
namespace command;

class Person extends Command {
    function doExecute(\controller\Request $request) {
    	$personMapper = \base\RequestRegistry::getPersonMapper();
    	
    	$collection = $personMapper->findAll();
    	$request->setProperty('person_list', $collection->getGenerator());

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