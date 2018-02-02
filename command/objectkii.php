<?php
namespace command;

class ObjectKii extends Command {
    function doExecute(\controller\Request $request) {
    	$objectKiiMapper = \base\RequestRegistry::getObjectKiiMapper();
    	$departmentMapper = \base\RequestRegistry::getDepartmentMapper();

    	$collection = $objectKiiMapper->findAll();
    	$request->setProperty('object_kii_list', $collection->getGenerator());

    	$collection = $departmentMapper->getTree();
        $request->setProperty('department_tree', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>