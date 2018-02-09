<?php
namespace command;

class Position extends Command {
    function doExecute(\controller\Request $request) {
    	$positionMapper = \base\RequestRegistry::getPositionMapper();

    	$collection = $positionMapper->findAll();
    	$request->setProperty('position_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>