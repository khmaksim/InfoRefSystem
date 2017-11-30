<?php

class ControlScientificResearchDesignWorkInterface extends BaseInterface 
{
	protected function _loadData($id=NULL)
	{
		$sql = "SELECT * FROM control_scientific_research_design_work";
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
					<th>Дата (вх. №)</th>
					<th>Название</th>
					<th>Исполнитель</th>
					<th>Результат рассмотрения</th>
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
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td class="col-xs-1 text-center"><a href="#" class="button btn-info btn-sm" target="_blank"><span class="glyphicon glyphicon-print"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="./controlscientificresearchdesignwork_edit.php?action=edit&id='. $obj->id .'" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('. $obj->id .');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>';
        }
        $html .= '</tbody>';
		return $html;
	}

	public function displayById($id=NULL)
	{
		$image = '';
		if (empty($id) || $id == NULL)
			$obj = new ControlScientificResearchDesignWork();
		else {	
			$id = preg_replace('/[^0-9]/', '', $id);
			$obj = $this->_loadById("ControlScientificResearchDesignWork", $id);
		}
		
		return '
			<div class="form-group">
				<label for="inputDate">Дата</label>
				<input type="text" name="date" class="form-control" id="inputDate" placeholder="Дата" value="' . $obj->date . '" required autofocus>
			</div>
			<div class="form-group">
				<label for="inputIncomingNumber">Дата</label>
				<input type="text" name="incoming_number" class="form-control" id="inputIncomingNumber" placeholder="Входящий номер" value="' . $obj->incomingNumber . '" required autofocus>
			</div>
			<div class="form-group">
				<label for="inputName">Название</label>
				<input type="text" name="name" class="form-control" id="inputName" placeholder="Название" value="' . $obj->name . '">
			</div>
			<div class="form-group">
				<label for="inputName">Название</label>
				<input type="text" name="name" class="form-control" id="inputName" placeholder="Название" value="' . $obj->name . '">
			</div>
			<div class="form-group">
				<label for="inputResult">Результат рассмотрения</label>
				<input type="text" name="result" class="form-control" id="inputResult" placeholder="Результат рассмотрения" value="' . $obj->result . '">
			</div>
		';
	}

	public function processForm()
	{
		$date = htmlentities($_POST['date'], ENT_QUOTES);
		$incomingNumber = htmlentities($_POST['incoming_number'], ENT_QUOTES);
		$name = htmlentities($_POST['name'], ENT_QUOTES);
		$result = htmlentities($_POST['result'], ENT_QUOTES);
		$id = NULL;

		if (empty($_POST['id'])) {
			$sql = "INSERT INTO public.product (date, incoming_number, name, result) VALUES (:date, :incoming_number, :name, :result)";
		}
		else {
			$id = (int) $_POST['id'];
			$sql = "UPDATE public.product SET date=:date, incoming_number=:incoming_number, name=:name, result=:result WHERE id=$id";
		}
		try
		{
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":date", $date, PDO::PARAM_STR);
			$stmt->bindParam(":incoming_number", $incomingNumber, PDO::PARAM_STR);
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":result", $result, PDO::PARAM_STR);
			$stmt->execute();
			$stmt->closeCursor();
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