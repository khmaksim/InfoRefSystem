<?php
namespace command;

class PersonnelWork extends Command {
	function doExecute(\controller\Request $request) {
		return self::statuses('CMD_OK');
	}
}
?>