<?php
namespace command;

class TechnicalProtectedInformation extends Command {
    function doExecute(\controller\Request $request) {
    	$documentMapper = \base\RequestRegistry::getDocumentMapper();
    	$collection = $documentMapper->findBySection('Техническая защита информации');
    	$request->setProperty('document_list', $collection->getGenerator());
    	
        return self::statuses('CMD_OK');
    }
}
?>