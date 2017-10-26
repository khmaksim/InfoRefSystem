<?php

class InternetInterface extends DatabaseConnect
{
	public function __construct($dbo=NULL)
	{
		parent::__construct($dbo);
	}

	private function _loadData($id=NULL, $id_department=NULL)
	{
		$sql = "SELECT * FROM internet";
		if (!empty($id)) {
			$sql .= " WHERE id=:id LIMIT 1";
		} 
		else if (!empty($id_department)) {
			$sql .= " WHERE id_department=:id_department";
		}
		else {
		}
		try	{
			$stmt = $this->db->prepare($sql);
			if (!empty($id)) {
				$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			}
			else if (!empty($id_department)) {
				$stmt->bindParam(":id_department", $id_department, PDO::PARAM_INT);
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

	private function _createObj($id_department=NULL)
	{
		$arr = $this->_loadData(NULL, $id_department);
		$internet = array();
		foreach ($arr as $obj) {
			try {
				array_push($internet, new Internet($obj));
			}
			catch (Exception $e) {
				die ($e->getMessage());
			}
		}
		return $internet;
	}

	public function displayByIdDepartment($id_department=NULL)
	{		
		$html = '
			<thead>
				<tr>
					<th class="col-xs-1">№</th>
					<th>Место дислокации</th>
					<th>Разрешение об открытии</th>
					<th>Регистрационный №</th>
					<th>Состав АРМ/Сервер</th>
					<th>Приказ</th>
					<th>Адрес электронной почты</th>
					<th class="col-xs-1 text-center">Редактировать</th>
					<th class="col-xs-1 text-center">Удалить</th>
				</tr>
			</thead>
			<tbody id="items"></tbody>
			';
		$objects = $this->_createObj($id_department);
		$count = 1;
		foreach ($objects as $object) {
			$html .= '<tr id="' . $object->id_unit . '">
							<td>' . $count++ . '</td>
                            <td>' . $object->location . '</td>
                            <td>' . $object->permission . '</td>
                            <td>' . $object->reg_number . '</td>
                            <td>' . $object->composition . '</td>
                            <td>' . $object->order . '</td>
                            <td>' . $object->email . '</td>
                            <td class="col-xs-1 text-center"><a href="./internet_edit.php?action=edit&id='. $object->id .'" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('. $object->id .');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>';
		}
		return $html;
	}

	public function display($id=NULL)
	{
		if (empty($id) || $id == NULL)
			$object = new Internet();
		else {	
			$id = preg_replace('/[^0-9]/', '', $id);
			$object = $this->_loadById($id);
		}
		
		return '
			<div class="form-group">
				<label for="exampleInputLocation">Местонахождение</label>
				<input type="text" name="location" class="form-control" id="exampleInputLocation" placeholder="Местонахождение" value="' . $object->location . '" required autofocus>
			</div>
			<div class="form-group">
				<label for="exampleInputPermission">Разрешение об открытии</label>
				<input type="text" name="permission" class="form-control" id="exampleInputPermission" placeholder="Разрешение об открытии" value="' . $object->permission . '">
			</div>
			<div class="form-group">
				<label for="exampleInputRegNumber">Регистрационный номер</label>
				<input type="text" name="reg_number" class="form-control" id="exampleInputRegNumber" placeholder="Регистрационный номер" value="' . $object->reg_number . '">
			</div>
			<div class="form-group">
				<label for="exampleInputComposition">Состав АРМ/Сервер</label>
				<input type="text" name="composition" class="form-control" id="exampleInputComposition" placeholder="Состав АРМ/Сервер" value="' . $object->composition . '">
			</div>
			<div class="form-group">
				<label for="exampleInputOrder">Приказ</label>
				<input type="text" name="order" class="form-control" id="exampleInputOrder" placeholder="Приказ" value="' . $object->order . '">
			</div>
			<div class="form-group">
				<label for="exampleInputEmail">Адрес электронной почты</label>
				<input type="text" name="email" class="form-control" id="exampleInputEmail" placeholder="email@email.mil" value="' . $object->email . '">
			</div>
		';
	}

	public function _loadByid($id)
	{
		if (empty($id))
			return NULL;

		$objects = $this->_loadData($id);

		if (isset($objects[0])) {
			return new Internet($objects[0]);
		}
		else
			return NULL;
	}

	public function processForm()
	{
		$location = htmlentities($_POST['location'], ENT_QUOTES);
		$permission = htmlentities($_POST['permission'], ENT_QUOTES);
		$reg_number = htmlentities($_POST['reg_number'], ENT_QUOTES);
		$composition = htmlentities($_POST['composition'], ENT_QUOTES);
		$order = htmlentities($_POST['order'], ENT_QUOTES);
		$email = htmlentities($_POST['email'], ENT_QUOTES);

		if (empty($_POST['id'])) {
			$sql = "INSERT INTO internet (location, permission, reg_number, composition, \"order\", email, id_department) VALUES (:location, :permission, :reg_number, :composition, :order, :email, :id_department)";
		}
		else {
			$id = (int) $_POST['id'];
			$sql = "UPDATE internet SET location=:location, permission=:permission, reg_number=:reg_number, composition=:composition, \"order\"=:order, email=:email WHERE id=$id";
		}
		try
		{
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":location", $location, PDO::PARAM_STR);
			$stmt->bindParam(":permission", $permission, PDO::PARAM_STR);
			$stmt->bindParam(":reg_number", $reg_number, PDO::PARAM_STR);
			$stmt->bindParam(":composition", $composition, PDO::PARAM_STR);
			$stmt->bindParam(":order", $order, PDO::PARAM_STR);
			$stmt->bindParam(":email", $email, PDO::PARAM_STR);
			$stmt->bindParam(":id_department", $_POST['id_department'], PDO::PARAM_STR);
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

		$sql = "DELETE FROM internet WHERE id=:id";
		try {
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
			$stmt->execute();
			$stmt->closeCursor();
			header("Location: {$_SERVER['HTTP_REFERER']}");
			return;
		} 
		catch (Exception $e) {
			return $e->getMessage();
		}
	}
}

?>