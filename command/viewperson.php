<?php
namespace command;

class ViewPerson extends Command {
    function doExecute(\controller\Request $request) {
    	$personMapper = \base\RequestRegistry::getPersonMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$person = $personMapper->find($id);
    			if (!is_null($person)) {
					$request->setProperty('person', $person);    		

                    $militaryRankMapper = \base\RequestRegistry::getMilitaryRankMapper();
                    $military_rank = $militaryRankMapper->find($person->id_military_rank);
                    $request->setProperty('military_rank', $military_rank);		

                    $unitMapper = \base\RequestRegistry::getUnitMapper();
                    $unit = $unitMapper->find($person->id_unit);
                    
                    $departmentMapper = \base\RequestRegistry::getDepartmentMapper();
                    $department = $departmentMapper->find($unit->id_department);
                    $request->setProperty('department', $department);

                    $positionMapper = \base\RequestRegistry::getPositionMapper();
                    $position = $positionMapper->find($unit->id_position);
                    $request->setProperty('position', $position);

                    $accessTypeMapper = \base\RequestRegistry::getAccessTypeMapper();
                    $access_type = $accessTypeMapper->find($person->id_access_type);
                    $request->setProperty('access_type', $access_type);
                    
                    $cityMapper = \base\RequestRegistry::getCityMapper();
                    $city = $cityMapper->find($person->id_city);
                    $request->setProperty('city', $city);

                    $phoneNumberMapper = \base\RequestRegistry::getPhoneNumberMapper();
                    $phone_number_list = $phoneNumberMapper->findByPerson($id);
                    $request->setProperty('phone_number_list', $phone_number_list->getGenerator());

                    $phoneNumberTypeMapper = \base\RequestRegistry::getPhoneNumberTypeMapper();
                    $phone_number_type_list = $phoneNumberTypeMapper->findAll();
                    $request->setProperty('phone_number_type_list', $phone_number_type_list->getGenerator());
    			}
    		}
    	}
        // return self::statuses('CMD_OK');
    }
}
?>