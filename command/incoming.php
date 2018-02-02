<?php
namespace command;

class Incoming extends Command {
    function doExecute(\controller\Request $request) {
    	

        return self::statuses('CMD_OK');
    }
}
?>