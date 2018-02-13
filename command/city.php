<?php
namespace command;

class City extends Command {
    function doExecute(\controller\Request $request) {
    	$cityMapper = \base\RequestRegistry::getCityMapper();

    	$collection = $cityMapper->findAll();
    	$request->setProperty('city_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>