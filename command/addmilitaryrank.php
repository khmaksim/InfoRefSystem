<?php
namespace command;

class AddMilitaryRank extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$militaryRankMapper = \base\RequestRegistry::getMilitaryRankMapper();
			
			$military_rank = new \domain\MilitaryRank();  			
  			$military_rank->name = $request->getProperty('name');
			
			$militaryRankMapper->insert($military_rank);
			if (!is_null($military_rank->id))
				return self::statuses('CMD_OK');

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>