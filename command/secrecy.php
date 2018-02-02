<?php
namespace command;

class Secrecy extends Command {
	function doExecute(\controller\Request $request) {
		return self::statuses('CMD_OK');
	}
}
?>