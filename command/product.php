<?php
namespace command;

class Product extends Command {
    function doExecute(\controller\Request $request) {
    	$productMapper = \base\RequestRegistry::getProductMapper();
    	$collection = $productMapper->findAll();
    	$request->setProperty('product_list', $collection->getGenerator());

        return self::statuses('CMD_OK');
    }
}
?>