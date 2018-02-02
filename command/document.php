<?php
namespace command;

class Document extends Command {
    function doExecute(\controller\Request $request) {
    	$documentMapper = \base\RequestRegistry::getDocumentMapper();

    	$collection = $documentMapper->findAll();
    	$request->setProperty('document_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>