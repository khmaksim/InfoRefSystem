<?php
namespace command;

class ScientificWork extends Command {
    function doExecute(\controller\Request $request) {
    	$scientificWorkMapper = \base\RequestRegistry::getScientificWorkMapper();

    	$collection = $scientificWorkMapper->findAll();
    	$request->setProperty('scientific_work_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>