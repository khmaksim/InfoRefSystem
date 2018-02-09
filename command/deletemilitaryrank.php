<?php
namespace command;

class DeleteMilitaryRank extends Command {
    function doExecute(\controller\Request $request) {
    	$militaryRankMapper = \base\RequestRegistry::getMilitaryRankMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$military_rank = $militaryRankMapper->find($id);
    		
    		if (!is_null($military_rank)) {
				$militaryRankMapper->delete($military_rank);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>