<?php
namespace command;

class Enterprise extends Command {
    function doExecute(\controller\Request $request) {
    	$enterpriseMapper = \base\RequestRegistry::getEnterpriseMapper();

    	$collection = $enterpriseMapper->findAll();
    	$request->setProperty('enterprise_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>