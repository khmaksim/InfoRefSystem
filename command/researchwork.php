<?php
namespace command;

class ResearchWork extends Command {
    function doExecute(\controller\Request $request) {
    	$documentMapper = \base\RequestRegistry::getDocumentMapper();
    	$collection = $documentMapper->findBySection('Научно-исследовательская работа');
    	$request->setProperty('document_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>