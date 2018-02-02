<?php
namespace command;

class ProtectionInformation extends Command {
    function doExecute(\controller\Request $request) {
    	$documentMapper = \base\RequestRegistry::getDocumentMapper();
    	
    	$collection = $documentMapper->findBySection('Защита информации от НСД');
    	$request->setProperty('document_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>