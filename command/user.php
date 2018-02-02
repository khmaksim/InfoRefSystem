<?php
namespace command;

class User extends Command {
	function doExecute(\controller\Request $request) {
		$userMapper = \base\RequestRegistry::getUserMapper();

		$collection = $userMapper->findAll();
        $request->setProperty('user_list', $collection->getGenerator());
        return self::statuses('CMD_OK');
	}
}
?>