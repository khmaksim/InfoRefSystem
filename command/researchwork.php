<?php
namespace command;

class ResearchWork extends Command {
    function doExecute(\controller\Request $request) {
        return self::statuses('CMD_OK');
    }
}
?>