<?php
namespace command;

class MedalType extends Command {
    function doExecute(\controller\Request $request) {
    	$medalTypeMapper = \base\RequestRegistry::getMedalTypeMapper();

    	$collection = $medalTypeMapper->findAll();
    	$request->setProperty('medal_type_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>