<?php
namespace command;

class AddressType extends Command {
    function doExecute(\controller\Request $request) {
    	$addressTypeMapper = \base\RequestRegistry::getAddressTypeMapper();

    	$collection = $addressTypeMapper->findAll();
    	$request->setProperty('address_type_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>