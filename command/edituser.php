<?php
namespace command;

include_once $_SERVER['DOCUMENT_ROOT'] . '/date.func.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/resize_image.php';

class EditUser extends Command {
    function doExecute(\controller\Request $request) {
        $userMapper = \base\RequestRegistry::getUserMapper();

        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $id = $request->getProperty('id');
            if (!is_null($id)) {
                $user = $userMapper->find($id);
                if (!is_null($user)) {
                    $request->setProperty('user', $user);                   
                }
            }
            return self::statuses('CMD_INSUFFICIENT_DATA');
        }
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $request->getProperty('id');
            if (!is_null($id)) {
                $user = $userMapper->find($id);
                if (\DateTime::createFromFormat('d-m-Y', $request->getProperty('adate')) == false || \DateTime::createFromFormat('d-m-Y', $request->getProperty('bdate')) == false) {
                    $request->setProperty('user', $user); 
                    return self::statuses('CMD_ERROR');
                }

                $user->title = $request->getProperty('title');
      			$user->name = $request->getProperty('name');
                $user->passwd = md5($request->getProperty('passwd'));
                $user->adate = \DateTime::createFromFormat('d-m-Y', $request->getProperty('adate'))->format('Y-m-d');
                $user->bdate = \DateTime::createFromFormat('d-m-Y', $request->getProperty('bdate'))->format('Y-m-d');
                $user->active = $request->getProperty('active');

    			if (!is_null($user->id)) {
                    $id_user = $user->id;
                  
                    if (sizeof($_FILES) && !$_FILES['face']['error'] && $_FILES['face']['size'] < 1024 * 2 * 1024) {
                        // $file_ext = mb_strtolower(mb_substr($_FILES['face']['name'], mb_strpos($_FILES['face']['name'], '.', (mb_strlen($_FILES['face']['name'], 'utf-8') - 4), 'utf-8') + 1, (mb_strlen($_FILES['face']['name'], 'utf-8') - mb_strpos($_FILES['face']['name'], '.', 0, 'utf-8')), 'utf-8'), 'utf-8');
                        
                        $upload_info = $_FILES['face'];
                        $upload_dir_name = './upload/face/';
                        $file_name = $upload_dir_name.$id_user;

                        switch ($upload_info['type']) {
                            case 'image/jpeg':
                                $file_name .= '.jpg';
                                $file_ext = 'jpg';
                                break;
                            case 'image/png':
                                $file_name .= '.png';
                                $file_ext = 'png';
                                break;
                            default:
                                exit;
                        }
                        $file_name = iconv('utf-8', 'windows-1251', $file_name);
                        
                        if (!file_exists($upload_dir_name)) {
                            mkdir($upload_dir_name, 0777, true);
                        }

                        copy($_FILES['face']['tmp_name'], $upload_dir_name . $id_user . "." . $file_ext);
                        resizeImage($upload_dir_name, 100, 100, $id_user, $file_ext, $id_user . '_thumb');

                        // if (!move_uploaded_file($upload_info['tmp_name'], $file_name)) {
                        //     $request->setProperty('error', 'Не удалось осуществить сохранение файла');
                        // }
                        $user->img_ext = $file_ext;
    				}
                    $userMapper->update($user);
    				return self::statuses('CMD_OK');
    			}
			    return self::statuses('CMD_ERROR');
  		    }
            return self::statuses('CMD_ERROR');
        }
        return self::statuses('CMD_DEFAULT');
    }
}
?>