<?php
namespace command;

class AddTechnique extends Command {
    function doExecute(\controller\Request $request) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $departmentMapper = \base\RequestRegistry::getDepartmentMapper();
            
            $id_department = $request->getProperty('id_department');
            if (!is_null($id_department)) {
                $department = $departmentMapper->find($id_department);
                $request->setProperty('department', $department);
            }
        }
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$techniqueMapper = \base\RequestRegistry::getTechniqueMapper();
            
            $technique = new \domain\Technique();           
            $technique->fullname = $request->getProperty('fullname');
            $technique->shortname = $request->getProperty('shortname');
            $technique->id_department = $request->getProperty('id_department');

			$techniqueMapper->insert($technique);
			if (!is_null($technique->id)) {
				return self::statuses('CMD_OK');
			}

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>