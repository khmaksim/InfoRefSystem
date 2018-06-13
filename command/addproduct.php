<?php
namespace command;

class AddProduct extends Command {
    function doExecute(\controller\Request $request) {
  		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  			$productMapper = \base\RequestRegistry::getProductMapper();
			
			$product = new \domain\Product();  			
  			$product->index = $request->getProperty('index');
  			$product->cipher = $request->getProperty('cipher');
  			$product->description = $request->getProperty('description');
            $product->creator = $request->getProperty('creator');
            $product->security_label = $request->getProperty('security-label');
			
            if (!is_null($productMapper->findByCipher($product->cipher))) {
                $request->setProperty('error', 'Запись с таким индексом уже существует в базе данных');
                $request->setProperty('product', $product);
                return self::statuses('CMD_ERROR');                
            }

			$productMapper->insert($product);
			if (!is_null($product->id)) {
                $id_product = $product->id;
              
                if (sizeof($_FILES) && !$_FILES['image-file']['error'] && $_FILES['image-file']['size'] < 1024 * 2 * 1024) {
                    $upload_info = $_FILES['image-file'];
                    $upload_dir_name = $_SERVER['DOCUMENT_ROOT'] . '/upload/product/';
                    $image_file_name = $upload_dir_name.$id_product;

                    switch ($upload_info['type']) {
                        case 'image/jpeg':
                            $image_file_name .= '.jpg';
                            break;
                        case 'image/png':
                            $image_file_name .= '.png';
                            break;
                        default:
                            exit;
                    }
                    $image_file_name = iconv('utf-8', 'windows-1251', $image_file_name);
                    
                    if (!file_exists($upload_dir_name)) {
                        mkdir($upload_dir_name, 0777, true);
                    }
                    if (!move_uploaded_file($upload_info['tmp_name'], $image_file_name)) {
                        $request->setProperty('error', 'Не удалось осуществить сохранение файла');
                    }
                    $product->image_file_name = $image_file_name;
                    $productMapper->update($product);
				}

				return self::statuses('CMD_OK');
			}

			return self::statuses('CMD_ERROR');
  		}
        // return self::statuses('CMD_OK');
    }
}
?>