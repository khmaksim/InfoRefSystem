<?php
namespace command;

class Technique extends Command {
    function doExecute(\controller\Request $request) {
    	$techniqueMapper = \base\RequestRegistry::getTechniqueMapper();
    	
    	$collection = $techniqueMapper->findAll();
    	$request->setProperty('technique_list', $collection->getGenerator());

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