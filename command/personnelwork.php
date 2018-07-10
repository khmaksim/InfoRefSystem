<?php
namespace command;

class PersonnelWork extends Command {
	function doExecute(\controller\Request $request) {
		$documentMapper = \base\RequestRegistry::getDocumentMapper();
    	$collection = $documentMapper->findBySection('Кадровая работа');
    	$request->setProperty('document_list', $collection->getGenerator());
    	
		return self::statuses('CMD_OK');
	}
}
?>