<?php
namespace command;

class EditProduct extends Command {
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
  		else if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$id = $request->getProperty('id');
    		if (!is_null($id)) {
    			$product = $productMapper->find($id);
                
	  			$product->index = $request->getProperty('index');
                $product->cipher = $request->getProperty('cipher');
                $product->description = $request->getProperty('description');
                $product->creator = $request->getProperty('creator');
                $product->security_label = $request->getProperty('security-label');
				
                if (sizeof($_FILES) && !$_FILES['image-file']['error'] && $_FILES['image-file']['size'] < 1024 * 2 * 1024) {
                    $upload_info = $_FILES['image-file'];
                    $upload_dir_name = $_SERVER['DOCUMENT_ROOT'] . '/upload/product/';
                    $file_name = $upload_dir_name.$id;

                    switch ($upload_info['type']) {
                        case 'image/jpeg':
                            $file_name .= '.jpg';
                            break;
                        case 'image/png':
                            $file_name .= '.png';
                            break;
                        default:
                            exit;
                    }
                    $file_name = iconv('utf-8', 'windows-1251', $file_name);
                    
                    if (!file_exists($upload_dir_name)) {
                        mkdir($upload_dir_name, 0777, true);
                    }
                    if (!move_uploaded_file($upload_info['tmp_name'], $file_name)) {
                        $request->setProperty('error', 'Не удалось осуществить сохранение файла');
                    }

                    $product->image_file_name = $file_name;
                }
                $productMapper->update($product);

				return self::statuses('CMD_OK');
			}
			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>