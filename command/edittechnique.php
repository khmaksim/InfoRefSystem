<?php
namespace command;

class EditTechnique extends Command {
    function doExecute(\controller\Request $request) {
    	$techniqueMapper = \base\RequestRegistry::getTechniqueMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$technique = $techniqueMapper->find($id);
    			if (!is_null($technique)) {
					$request->setProperty('technique', $technique);
                   
                    $departmentMapper = \base\RequestRegistry::getDepartmentMapper();
                    $department = $departmentMapper->find($technique->id_department);
                    $request->setProperty('department', $department);
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$technique = $techniqueMapper->find($id);
                
                $technique->fullname = $request->getProperty('fullname');
                $technique->shortname = $request->getProperty('shortname');
                $technique->id_department = $request->getProperty('id_department');

                $techniqueMapper->update($technique);
                
				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>