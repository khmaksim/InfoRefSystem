<?php
namespace command;

class ViewProduct extends Command {
    function doExecute(\controller\Request $request) {
    	$productMapper = \base\RequestRegistry::getProductMapper();
    	
    	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    		$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$product = $productMapper->find($id);
    			if (!is_null($product)) {
					$request->setProperty('product', $product);    				
    			}
    		}
    	}
        // return self::statuses('CMD_OK');
    }
}
?>