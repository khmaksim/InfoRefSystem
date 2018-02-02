<?php
namespace command;

class Structure extends Command {
    function doExecute(\controller\Request $request) {
        return self::statuses('CMD_OK');
    }
}
?>