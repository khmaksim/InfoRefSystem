<?php
namespace command;

class EmailType extends Command {
    function doExecute(\controller\Request $request) {
    	$emailTypeMapper = \base\RequestRegistry::getEmailTypeMapper();

    	$collection = $emailTypeMapper->findAll();
    	$request->setProperty('email_type_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>