<?php
namespace command;

class DeleteProduct extends Command {
    function doExecute(\controller\Request $request) {
    	$productMapper = \base\RequestRegistry::getProductMapper();
    	
    	$id = $request->getProperty('id');
    	if (!is_null($id)) {
    		$product = $productMapper->find($id);
    		
    		if (!is_null($product)) {
				$productMapper->delete($product);
				return self::statuses('CMD_OK');
    		}
    	}
    	return self::statuses('CMD_ERROR');
    }
}
?>