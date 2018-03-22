<?php
namespace command;

class IncomingDocument extends Command {
    function doExecute(\controller\Request $request) {
    	$incomingDocumentMapper = \base\RequestRegistry::getIncomingDocumentMapper();

    	$collection = $incomingDocumentMapper->findAll();
    	$request->setProperty('incoming_document_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>