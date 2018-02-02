<?php
namespace command;

class Administration extends Command {
	function doExecute(\controller\Request $request) {
		return self::statuses('CMD_OK');
	}
}
?>