<?php
namespace command;

class TelephoneDirectory extends Command {
    function doExecute(\controller\Request $request) {
    	$departmentMapper = \base\RequestRegistry::getDepartmentMapper();
    	
    	$collection = $departmentMapper->getTree();
        $request->setProperty('department_tree', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>