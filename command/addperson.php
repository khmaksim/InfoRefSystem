<?php
namespace command;

class AddPerson extends Command {
    function doExecute(\controller\Request $request) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            
            $id_department = $request->getProperty('id_department');
            if (!is_null($id_department)) {
                $departmentMapper = \base\RequestRegistry::getDepartmentMapper();
                $department = $departmentMapper->find($id_department);
                $request->setProperty('department', $department);
             
                $unitMapper = \base\RequestRegistry::getUnitMapper();   
                $unit_list = $unitMapper->findByDepartment($id_department);
                $request->setProperty('unit_list', $unit_list->getGenerator());
            }

            $militaryRankMapper = \base\RequestRegistry::getMilitaryRankMapper();
            $military_rank_list = $militaryRankMapper->findAll();
            $request->setProperty('military_rank_list', $military_rank_list->getGenerator());

            $accessTypeMapper = \base\RequestRegistry::getAccessTypeMapper();
            $access_type_list = $accessTypeMapper->findAll();
            $request->setProperty('access_type_list', $access_type_list->getGenerator());

            $cityMapper = \base\RequestRegistry::getCityMapper();
            $city_list = $cityMapper->findAll();
            $request->setProperty('city_list', $city_list->getGenerator());

            $phoneNumberTypeMapper = \base\RequestRegistry::getPhoneNumberTypeMapper();
            $phone_number_type_list = $phoneNumberTypeMapper->findAll();
            $request->setProperty('phone_number_type_list', $phone_number_type_list->getGenerator());
        }
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$personMapper = \base\RequestRegistry::getPersonMapper();
            
            $person = new \domain\Person();           
            $person->firstname = $request->getProperty('firstname');  
            $person->lastname = $request->getProperty('lastname');
            $person->patronymic = $request->getProperty('patronymic');
            $person->military = $request->getProperty('military');
            $person->personal_number = $request->getProperty('personal_number');
            $person->birthday = $request->getProperty('birthday');
            $person->id_access_type = $request->getProperty('id_access_type');
            $person->id_unit = $request->getProperty('id_unit');
            $person->id_military_rank = $request->getProperty('id_military_rank');
            $person->img_ext = $request->getProperty('img_ext');
            $person->address = $request->getProperty('address');
            $person->id_city = $request->getProperty('id_city');
            $person->note = $request->getProperty('note');

			$personMapper->insert($person);
			if (!is_null($person->id)) {
				return self::statuses('CMD_OK');
			}

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>