<?php
namespace command;

class Secrecy extends Command {
	function doExecute(\controller\Request $request) {
		$documentMapper = \base\RequestRegistry::getDocumentMapper();
    	$collection = $documentMapper->findBySection('Режим секретности');
    	$request->setProperty('document_list', $collection->getGenerator());
    	
		return self::statuses('CMD_OK');
	}
}
?>