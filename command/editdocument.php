<?php
namespace command;

class EditDocument extends Command {
    function doExecute(\controller\Request $request) {
    	$documentMapper = \base\RequestRegistry::getDocumentMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$document = $documentMapper->find($id);
    			if (!is_null($document)) {
					$request->setProperty('document', $document);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$document = $documentMapper->find($id);

	  			$document->name = $request->getProperty('name');
				$document->section = $request->getProperty('section');
				$document->document_file = $section = $request->getProperty('document_file');

                if (sizeof($_FILES) && !$_FILES['document_file']['error'] && $_FILES['document_file']['size'] < 1024 * 2 * 1024) {
                    $upload_info = $_FILES['document_file'];
                    $upload_dir_name = $_SERVER['DOCUMENT_ROOT'] . '/upload/document/';
                    $file_name = $upload_dir_name.$id_document;

                    switch ($upload_info['type']) {
                        case 'image/jpeg':
                            $file_name .= '.jpg';
                            break;
                        case 'image/png':
                            $file_name .= '.png';
                            break;
                        case 'application/msword':
                            $file_name .= '.doc';
                            break;
                        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                            $file_name .= '.docx';
                            break;
                        case 'application/pdf':
                            $file_name .= '.pdf';
                            break;
                        default:
                            exit;
                    }
                    $file_name = iconv('utf-8', 'windows-1251', $file_name);
                    
                    if (!file_exists($upload_dir_name)) {
                        mkdir($upload_dir_name, 0777, true);
                    }
                    if (!move_uploaded_file($upload_info['tmp_name'], $file_name)) {
                        $request->setProperty('error', 'Не удалось осуществить сохранение файла');
                    }
                    $document->document_file = $file_name;
                    $documentMapper->update($document);
                }

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>