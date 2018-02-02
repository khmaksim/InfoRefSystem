<?php
namespace command;

class DefaultCommand extends Command {
	function doExecute(\controller\Request $request) {
		// $manager = \base\RequestRegistry::getAccessManager();
		return self::statuses('CMD_OK');
	}
}
?>