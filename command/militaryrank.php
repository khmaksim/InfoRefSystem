<?php
namespace command;

class MilitaryRank extends Command {
    function doExecute(\controller\Request $request) {
    	$militaryRankMapper = \base\RequestRegistry::getMilitaryRankMapper();

    	$collection = $militaryRankMapper->findAll();
    	$request->setProperty('military_rank_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>