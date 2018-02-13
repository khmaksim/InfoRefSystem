<?php
namespace command;

class PhonenumberType extends Command {
    function doExecute(\controller\Request $request) {
    	$phonenumberTypeMapper = \base\RequestRegistry::getPhonenumberTypeMapper();

    	$collection = $phonenumberTypeMapper->findAll();
    	$request->setProperty('phonenumber_type_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>