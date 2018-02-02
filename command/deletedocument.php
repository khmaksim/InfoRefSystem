<?php
namespace command;

class DeleteDocument extends Command {
    function doExecute(\controller\Request $request) {
    	$documentMapper = \base\RequestRegistry::getDocumentMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$document = $documentMapper->find($id);
    		
    		if (!is_null($document)) {
				$documentMapper->delete($document);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>