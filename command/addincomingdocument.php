<?php
namespace command;

class AddIncomingDocument extends Command {
    function doExecute(\controller\Request $request) {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $accessTypeMapper = \base\RequestRegistry::getAccessTypeMapper();

            $access_type_list = $accessTypeMapper->findAll();
            $request->setProperty('access_type_list', $access_type_list->getGenerator());
        }
  		else if($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$incomingDocumentMapper = \base\RequestRegistry::getIncomingDocumentMapper();
			
			$incomingDocument = new \domain\IncomingDocument();  			
            $incomingDocument->number_in = $request->getProperty('number_in');
            $incomingDocument->date_registration = $request->getProperty('date_registration');
            $incomingDocument->number_primary = $request->getProperty('number_primary');
            $incomingDocument->date_primary = $request->getProperty('date_primary');
            $incomingDocument->senders_numbers = $request->getProperty('senders_numbers');
            $incomingDocument->security_label = $request->getProperty('security_label');
            $incomingDocument->number_sheets = $request->getProperty('number_sheets');
            $incomingDocument->copies = $request->getProperty('copies');
            $incomingDocument->copies_numbers = $request->getProperty('copies_numbers');
            $incomingDocument->subject = $request->getProperty('subject');
            $incomingDocument->order = $request->getProperty('order');
            $incomingDocument->instructions = $request->getProperty('instructions');
            $incomingDocument->note = $request->getProperty('note');
            $incomingDocument->control = $request->getProperty('control');
            $incomingDocument->out_where = $request->getProperty('out_where');
            $incomingDocument->out_details = $request->getProperty('out_details');
            $incomingDocument->out_date = $request->getProperty('out_date');
			
			$incomingDocumentMapper->insert($incomingDocument);
			if (!is_null($incomingDocument->id)) {
                $id_incoming_document = $incomingDocument->id;
              
    //             if (sizeof($_FILES) && !$_FILES['document_file']['error'] && $_FILES['document_file']['size'] < 1024 * 2 * 1024) {
    //                 $upload_info = $_FILES['document_file'];
    //                 $upload_dir_name = $_SERVER['DOCUMENT_ROOT'] . '/upload/document/';
    //                 $file_name = $upload_dir_name.$id_document;

    //                 switch ($upload_info['type']) {
    //                     case 'image/jpeg':
    //                         $file_name .= '.jpg';
    //                         break;
    //                     case 'image/png':
    //                         $file_name .= '.png';
    //                         break;
    //                     case 'application/msword':
    //                         $file_name .= '.doc';
    //                         break;
    //                     case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
    //                         $file_name .= '.docx';
    //                         break;
    //                     case 'application/pdf':
    //                         $file_name .= '.pdf';
    //                         break;
    //                     default:
    //                         exit;
    //                 }
    //                 $file_name = iconv('utf-8', 'windows-1251', $file_name);
                    
    //                 if (!file_exists($upload_dir_name)) {
    //                     mkdir($upload_dir_name, 0777, true);
    //                 }
    //                 if (!move_uploaded_file($upload_info['tmp_name'], $file_name)) {
    //                     $request->setProperty('error', 'Не удалось осуществить сохранение файла');
    //                 }
    //                 $document->document_file = $file_name;
    //                 $documentMapper->update($document);
				// }

				return self::statuses('CMD_OK');
			}

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>