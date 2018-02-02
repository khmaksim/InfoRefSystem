<?php
namespace command;

class TechnicalProtectedInformation extends Command {
    function doExecute(\controller\Request $request) {
        return self::statuses('CMD_OK');
    }
}
?>