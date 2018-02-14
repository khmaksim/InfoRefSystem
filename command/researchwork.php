<?php
namespace command;

class ResearchWork extends Command {
    function doExecute(\controller\Request $request) {
    	$documentMapper = \base\RequestRegistry::getDocumentMapper();
    	$section = $request->getProperty('section');
    	
    	$collection = $documentMapper->findBySection($section);
    	$request->setProperty('document_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>