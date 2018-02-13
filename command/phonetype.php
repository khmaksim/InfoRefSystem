<?php
namespace command;

class PhoneType extends Command {
    function doExecute(\controller\Request $request) {
    	$phoneTypeMapper = \base\RequestRegistry::getPhoneTypeMapper();

    	$collection = $phoneTypeMapper->findAll();
    	$request->setProperty('phone_type_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>