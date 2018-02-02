<?php
namespace command;

class EncryptionWork extends Command {
	function doExecute(\controller\Request $request) {
		return self::statuses('CMD_OK');
	}
}
?>