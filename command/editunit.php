<?php
namespace command;

class EditUnit extends Command {
    function doExecute(\controller\Request $request) {
    	$unitMapper = \base\RequestRegistry::getUnitMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$unit = $unitMapper->find($id);
    			if (!is_null($unit)) {
					$request->setProperty('unit', $unit);
                   
                    $departmentMapper = \base\RequestRegistry::getDepartmentMapper();
                    $department = $departmentMapper->find($unit->id_department);
                    $request->setProperty('department', $department);

                    $positionMapper = \base\RequestRegistry::getPositionMapper();
                    $position_list = $positionMapper->findAll();
                    $request->setProperty('position_list', $position_list->getGenerator());

                    $militaryRankMapper = \base\RequestRegistry::getMilitaryRankMapper();
                    $military_rank_list = $militaryRankMapper->findAll();
                    $request->setProperty('military_rank_list', $military_rank_list->getGenerator());

                    $accessTypeMapper = \base\RequestRegistry::getAccessTypeMapper();
                    $access_type_list = $accessTypeMapper->findAll();
                    $request->setProperty('access_type_list', $access_type_list->getGenerator());
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