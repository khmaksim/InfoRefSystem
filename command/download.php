<?php
namespace command;

class Download extends Command {
    function doExecute(\controller\Request $request) {
		$fileName = $request->getProperty('file');

		switch (pathinfo($fileName)['extension']) {
			case 'jpeg':
			case 'jpg':
				header('Content-type: image/jpg');
				break;
			case 'png':
				header('Content-type: image/jpg');
				break;
			case 'doc':
				header('Content-type: application/msword');
				break;
			case 'docx':
				header('Content-type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
				break;
			case 'pdf':
				header('Content-type: application/pdf');
				break;
			default:
				exit;
		}
		echo file_get_contents($fileName);

        return self::statuses('CMD_OK');
    }
}
?>