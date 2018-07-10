<?php
namespace command;

class EncryptionWork extends Command {
	function doExecute(\controller\Request $request) {
		$documentMapper = \base\RequestRegistry::getDocumentMapper();
    	$collection = $documentMapper->findBySection('Шифровальная работа');
    	$request->setProperty('document_list', $collection->getGenerator());
    	
		return self::statuses('CMD_OK');
	}
}
?>