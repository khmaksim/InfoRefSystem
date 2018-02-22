<?php
namespace command;

class Department extends Command {
    function doExecute(\controller\Request $request) {
    	$departmentMapper = \base\RequestRegistry::getDepartmentMapper();

    	$collection = $departmentMapper->getTree();
    	$request->setProperty('department_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>