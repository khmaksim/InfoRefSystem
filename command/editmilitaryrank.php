<?php
namespace command;

class EditMilitaryRank extends Command {
    function doExecute(\controller\Request $request) {
    	$militaryRankMapper = \base\RequestRegistry::getMilitaryRankMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$military_rank = $militaryRankMapper->find($id);
    			if (!is_null($military_rank)) {
					$request->setProperty('military_rank', $military_rank);    				
    			}
    		}
    	}
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$military_rank = $militaryRankMapper->find($id);

	  			$military_rank->name = $request->getProperty('name');
                $militaryRankMapper->update($military_rank);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>