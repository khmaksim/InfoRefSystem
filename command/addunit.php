<?php
namespace command;

class AddUnit extends Command {
    function doExecute(\controller\Request $request) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $departmentMapper = \base\RequestRegistry::getDepartmentMapper();
            

            $id_department = $request->getProperty('id_department');
            if (!is_null($id_department)) {
                $department = $departmentMapper->find($id_department);
                $request->setProperty('department', $department);
            }

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
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$unitMapper = \base\RequestRegistry::getUnitMapper();
			
			$unit = new \domain\Unit();  			
            $unit->id_department = $request->getProperty('id_department');
            $unit->id_militaryposition = $request->getProperty('id_militaryposition');
            $unit->tariffcategory = $request->getProperty('tariffcategory');
            $unit->id_militaryrank = $request->getProperty('id_militaryrank');
            $unit->id_accesslevel = $request->getProperty('id_accesslevel');
            $unit->ordernumber = $request->getProperty('ordernumber');
            $unit->orderowner = $request->getProperty('orderowner');
            $unit->dateorderstart = $request->getProperty('dateorderstart');
            $unit->dateorderend = $request->getProperty('dateorderend');
            $unit->vacant = $request->getProperty('vacant');

			$unitMapper->insert($unit);
			if (!is_null($unit->id)) {
				return self::statuses('CMD_OK');
			}

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>