<?php
namespace command;

class InterpassportType extends Command {
    function doExecute(\controller\Request $request) {
    	$interpassportTypeMapper = \base\RequestRegistry::getInterpassportTypeMapper();

    	$collection = $interpassportTypeMapper->findAll();
    	$request->setProperty('interpassport_type_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>