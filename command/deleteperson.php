<?php
namespace command;

class DeletePerson extends Command {
    function doExecute(\controller\Request $request) {
    	$personMapper = \base\RequestRegistry::getPersonMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$person = $personMapper->find($id);
    		
    		if (!is_null($person)) {
                $id_department = $request->getProperty('id_department');
                
                if (!is_null($id_department)) {
                    $departmentMapper = \base\RequestRegistry::getDepartmentMapper();
                    $department = $departmentMapper->find($id_department);
                    $request->setProperty('department', $department);
                 
                    $unitMapper = \base\RequestRegistry::getUnitMapper();   
                    $unit_list = $unitMapper->findByDepartment($id_department);
                    $request->setProperty('unit_list', $unit_list->getGenerator());
                }
                
				$personMapper->delete($person);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>