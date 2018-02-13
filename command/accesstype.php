<?php
namespace command;

class AccessType extends Command {
    function doExecute(\controller\Request $request) {
    	$accessTypeMapper = \base\RequestRegistry::getAccessTypeMapper();

    	$collection = $accessTypeMapper->findAll();
    	$request->setProperty('access_type_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>