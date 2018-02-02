<?php
namespace command;

class ScientificResearchDesignWork extends Command {
    function doExecute(\controller\Request $request) {
        return self::statuses('CMD_OK');
    }
}
?>