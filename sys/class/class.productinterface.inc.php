<?php

class ProductInterface extends BaseInterface 
{
	protected function _loadData($id=NULL)
	{
		$sql = "SELECT * FROM product";
		if (!empty($id)) {
			$sql .= " WHERE id=:id LIMIT 1";
		} 
		try	{
			$stmt = $this->db->prepare($sql);
			if (!empty($id)) {
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			}
			$stmt->execute();
			$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
			$stmt->closeCursor();
			return $results;
		}
		catch (Exception $e) {
			die ($e->getMessage());
		}
	}

	public function display()
	{		
		$html = '
			<thead>
				<tr>
					<th class="col-xs-1">№</th>
					<th>Индекс</th>
					<th>Шифр</th>
					<th class="col-xs-1 text-center">Печать</th>
					<th class="col-xs-1 text-center">Редактировать</th>
					<th class="col-xs-1 text-center">Удалить</th>
				</tr>
			</thead>
			<tbody id="items">
			';
		$objects = $this->_createObject("Product");
		$count = 1;
		foreach ($objects as $obj) {
			$html .= '<tr>
							<td>' . $count++ . '</td>
                            <td><a data-toggle="collapse" href="#' . $obj->id . '">' . $obj->index . '</a></td>
                            <td>' . $obj->cipher . '</a></td>
                            <td class="col-xs-1 text-center"><a href="./product_view_print.php?id='. $obj->id .'" class="button btn-info btn-sm" target="_blank"><span class="glyphicon glyphicon-print"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="./product_edit.php?action=edit&id='. $obj->id .'" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('. $obj->id .');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>
                        <tr id="' . $obj->id . '" class="panel-collapse collapse">
                        	<td colspan="4">
                        		<p><b>Описание: </b>' . $obj->description . '</p>
                        	</td>
                        	<td colspan="2">
                        		<img src="' . $obj->image_file_name . '" alt="' . $obj->index . '" class="img-rounded" width=100% height=100%>
                        	</td>
                        </tr>';
        }
        $html .= '</tbody>';
		return $html;
	}

	public function displayById($id=NULL)
	{
		$image = '';
		if (empty($id) || $id == NULL)
			$product = new Product();
		else {	
			$id = preg_replace('/[^0-9]/', '', $id);
			$product = $this->_loadById("Product", $id);
			// $image = '<img src="' . $product->image_file_name . '" border="0" alt="" class="img-thumbnail" /><br />';
		}
		
		return '
			<div class="form-group">
				<label for="inputIndex">Индекс</label>
				<input type="text" name="index" class="form-control" id="inputIndex" placeholder="Индекс" value="' . $product->index . '" required autofocus>
			</div>
			<div class="form-group">
				<label for="inputCipher">Шифр</label>
				<input type="text" name="cipher" class="form-control" id="inputCipher" placeholder="Шифр" value="' . $product->cipher . '">
			</div>
			<div class="form-group">
				<label for="inputDescription">Описание</label>
				<input type="text" name="description" class="form-control" id="inputDescription" placeholder="Описание" value="' . $product->description . '">
			</div>
			<div class="form-group">' . $image . '
				<label for="inputImageFile">Изображение</label>
				<input type="file" name="image-file" id="inputImageFile">
				<p class="help-block">Размер файла не более 2 Мб.</p>
			</div>
		';
	}

	public function processForm()
	{
		$index = htmlentities($_POST['index'], ENT_QUOTES);
		$cipher = htmlentities($_POST['cipher'], ENT_QUOTES);
		$description = htmlentities($_POST['description'], ENT_QUOTES);
		$id = NULL;

		if (empty($_POST['id'])) {
			$sql = "INSERT INTO public.product (index, cipher, description) VALUES (:index, :cipher, :description) RETURNING id";
		}
		else {
			$id = (int) $_POST['id'];
			$sql = "UPDATE public.product SET index=?, cipher=?, description=? WHERE id=$id";
		}
		try
		{
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":index", $index, PDO::PARAM_STR);
			$stmt->bindParam(":cipher", $cipher, PDO::PARAM_STR);
			$stmt->bindParam(":description", $description, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();

			if ($id == NULL)
				$id = $this->db->lastInsertId('product_id_seq');

            if (sizeof($_FILES) && !$_FILES['image-file']['error'] && $_FILES['image-file']['size'] < 1024 * 2 * 1024) {
                $uploadInfo = $_FILES['image-file'];
                $fileName = 'img/product/' . $id;
                switch ($uploadInfo['type']) {
                	case 'image/jpeg':
                	$fileName .= '.jpg';
                	break;
                	case 'image/png':
                	$fileName .= '.png';
                	break;
                	default:
                	exit;
                }
                $fileName = iconv('utf-8', 'windows-1251', $fileName);
                if (!move_uploaded_file($uploadInfo['tmp_name'], $_SERVER['DOCUMENT_ROOT'] . $fileName))
                	echo 'Не удалось осуществить сохранение файла';

                $this->db->query("UPDATE public.product SET image_file_name = '" . $fileName . "' WHERE id = " . $id);
            }
            return TRUE;
		}
		catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function delete($id)
	{
		if (empty($id)) { 
			return NULL; 
		}
		$id = preg_replace('/[^0-9]/', '', $id);
		$object = $this->_loadById("Product", $id);

		$sql = "DELETE FROM product WHERE id=:id";
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();

            if (file_exists($_SERVER['DOCUMENT_ROOT'] . $object->image_file_name))
                unlink($_SERVER['DOCUMENT_ROOT'] . $object->image_file_name);

			header("Location: {$_SERVER['HTTP_REFERER']}");
			return;
		} 
		catch (Exception $e) {
			return $e->getMessage();
		}
	}

	public function view_print($id=NULL)
	{
		if (empty($id) || $id == NULL)
			$product = new Product();
		else {	
			$id = preg_replace('/[^0-9]/', '', $id);
			$product = $this->_loadById("Product", $id);
		}
		return '
				<div class="row">
					<big>
					<div class="col-xs-6 col-xs-offset-4 col-md-4 col-md-offset-4 col-lg-3 col-lg-offset-5">Изделие <b>' . $product->index . '</b>, шифр <b>' . $product->cipher . '</b></div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-12 col-lg-12">' . $product->description . '</div>
				</div>
				<div class="row">
					<div class="col-xs-4 col-xs-offset-8 col-md-2 col-md-offset-10">
						<img src="' . $product->image_file_name . '" alt="' . $product->index . '" class="img-thumbnail" width=100% height=100%>
					</div>
					</big>
				</div>
				';
	}
}

?>