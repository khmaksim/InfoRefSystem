<?php
namespace command;

class EditPerson extends Command {
    function doExecute(\controller\Request $request) {
    	$personMapper = \base\RequestRegistry::getPersonMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$person = $personMapper->find($id);
    			if (!is_null($person)) {
					$request->setProperty('person', $person);
                   
                    $id_department = $request->getProperty('id_department');
                    if (!is_null($id_department)) {
                        $departmentMapper = \base\RequestRegistry::getDepartmentMapper();
                        $department = $departmentMapper->find($id_department);
                        $request->setProperty('department', $department);
                     
                        $unitMapper = \base\RequestRegistry::getUnitMapper();   
                        $unit_list = $unitMapper->findByDepartment($id_department);
                        $request->setProperty('unit_list', $unit_list->getGenerator());

                        $phoneNumberMapper = \base\RequestRegistry::getPhoneNumberMapper();   
                        $phone_number_list = $phoneNumberMapper->findByPerson($id);
                        $request->setProperty('phone_number_list', $phone_number_list->getGenerator());                        
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
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$personMapper = \base\RequestRegistry::getPersonMapper();

                $person = $personMapper->find($id);
                $person->firstname = $request->getProperty('firstname');  
                $person->lastname = $request->getProperty('lastname');
                $person->patronymic = $request->getProperty('patronymic');
                $person->military = ($request->getProperty('military') == 1) ? 'true' : 'false';
                $person->personal_number = $request->getProperty('personal_number');
                $person->birthday = ($request->getProperty('birthday') == '') ? null : $request->getProperty('birthday');
                $person->id_access_type = ($request->getProperty('id_access_type') == '') ? null : $request->getProperty('id_access_type');
                $person->id_unit = ($request->getProperty('id_unit') == '') ? null : $request->getProperty('id_unit');
                $person->id_military_rank = ($request->getProperty('id_military_rank') == '') ? null : $request->getProperty('id_military_rank');
                $person->address = $request->getProperty('address');
                $person->id_city = ($request->getProperty('id_city') == '') ? null : $request->getProperty('id_city');
                $person->note = $request->getProperty('note');

                $personMapper->update($person);
                    
                if (sizeof($_FILES) && !$_FILES['face']['error'] && $_FILES['face']['size'] < 1024 * 2 * 1024) {
                    $upload_info = $_FILES['image-file'];
                    $upload_dir_name = $_SERVER['DOCUMENT_ROOT'] . '/upload/user/';
                    $photo_file_name = $upload_dir_name.$id_person;

                    switch ($upload_info['type']) {
                        case 'image/jpeg':
                            $photo_file_name .= 'jpg';
                            $photo_file_ext = 'jpg';
                            break;
                        case 'image/png':
                            $photo_file_name .= 'png';
                            $photo_file_ext = 'png';
                            break;
                        default:
                            $photo_file_ext = 'jpg';
                            exit;
                    }
                    $photo_file_name = iconv('utf-8', 'windows-1251', $photo_file_name);
                            
                    if (!file_exists($upload_dir_name)) {
                        mkdir($upload_dir_name, 0777, true);
                    }
                    if (!move_uploaded_file($upload_info['tmp_name'], $photo_file_name)) {
                        $request->setProperty('error', 'Не удалось осуществить сохранение файла');
                    }
                    $person->img_ext = $photo_file_ext;
                    $personMapper->update($person);
                }

                $phoneNumberMapper = \base\RequestRegistry::getPhoneNumberMapper();
                $phone_number_list_new = $request->getProperty('phone_number');
                $phone_number_type_list_new = $request->getProperty('phone_number_type');

                $i = 0;
                foreach ($phone_number_list_new as $phone_number_new) {
                    if ($phone_number_new != '') {
                        $phone_number = new \domain\PhoneNumber();
                        $phone_number->number = $phone_number_new;
                        $phone_number->id_person = $id;
                        $phone_number->id_phone_number_type = $phone_number_type_list_new[$i];
                        $phoneNumberMapper->insert($phone_number);
                        $i += 1;
                    }
                }
                return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>