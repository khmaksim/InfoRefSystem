<?php

class ObjectKii extends DatabaseConnect 
{
	public $id;	
	public $name_kvito;	
	public $reg_number;
	public $certificate;
	public $order;
	public $id_department;

	public function __construct($object_kii=NULL, $dbo=NULL)
	{
		parent::__construct($dbo);

		if (is_array($object_kii)) {
			$this->id = $object_kii['id'];
			$this->name_kvito = $object_kii['name_kvito'];
			$this->reg_number = $object_kii['reg_number'];
			$this->certificate = $object_kii['certificate'];
			$this->order = $object_kii['order'];
			$this->id_unit = $object_kii['id_department'];
		}
		else {
			$this->name_kvito = "";
			$this->reg_number = "";
			$this->certificate = "";
			$this->order = "";
			$this->id_department = "";
		}
	}

	private function _loadData($id=NULL, $id_department=NULL)
	{
		$sql = "SELECT * FROM object_kii";
		if (!empty($id)) {
			$sql .= " WHERE id=:id LIMIT 1";
		} 
		else if (!empty($id_department)) {
			$sql .= " WHERE id_department=:id_department LIMIT 1";
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
		$objects_kii = array();
		foreach ($arr as $obj) {
			try {
				array_push($objects_kii, new ObjectKii($obj));
			}
			catch (Exception $e) {
				die ($e->getMessage());
			}
		}
		return $objects_kii;
	}

	public function displayByIdDepartment($id_department=NULL)
	{		
		$html = '
			<thead>
				<tr>
					<th class="col-xs-1">№</th>
					<th>Наименование КВИТО</th>
					<th>Регистрационный №</th>
					<th>Аттестат</th>
					<th>Приказ</th>
					<th class="col-xs-1 text-center">Редактировать</th>
					<th class="col-xs-1 text-center">Удалить</th>
				</tr>
			</thead>
			<tbody id="items"></tbody>
			';
		$objectskii = $this->_createObj($id_department);
		$count = 1;
		foreach ($objectskii as $object) {
			$html .= '<tr id="' . $object->id_unit . '">
							<td>' . $count++ . '</td>
                            <td>' . $object->name_kvito . '</td>
                            <td>' . $object->reg_number . '</td>
                            <td>' . $object->certificate . '</td>
                            <td>' . $object->order . '</td>
                            <td class="col-xs-1 text-center"><a href="./objectskii_edit.php?action=edit&id='. $object->id .'" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('. $object->id .');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>';
		}
		return $html;
	}

	public function display($id=NULL)
	{
		if (empty($id) || $id == NULL)
			$objectkii = new ObjectKii();
		else {	
			$id = preg_replace('/[^0-9]/', '', $id);
			$objectkii = $this->_loadObjectKiiById($id);
		}
		
		return '
			<div class="form-group">
				<label for="exampleInputNameKVITO">Наименование КВИТО</label>
				<input type="text" name="name_kvito" class="form-control" id="exampleInputNameKVITO" placeholder="Наименование КВИТО" value="' . $objectkii->name_kvito . '" required autofocus>
			</div>
			<div class="form-group">
				<label for="exampleInputRegNumber">Регистрационный номер</label>
				<input type="text" name="reg_number" class="form-control" id="exampleInputRegNumber" placeholder="Регистрационный номер" value="' . $objectkii->reg_number . '" required autofocus>
			</div>
			<div class="form-group">
				<label for="exampleInputAttestat">Аттестат</label>
				<input type="text" name="certificate" class="form-control" id="exampleInputAttestat" placeholder="Аттестат" value="' . $objectkii->certificate . '" required autofocus>
			</div>
			<div class="form-group">
				<label for="exampleInputAttestat">Приказ</label>
				<input type="text" name="order" class="form-control" id="exampleInputAttestat" placeholder="Приказ" value="' . $objectkii->order . '" required autofocus>
			</div>
		';
	}

	public function _loadByid($id)
	{
		if (empty($id))
			return NULL;

		$objectkii = $this->_loadObjectKiiData($id);

		if (isset($objectkii[0])) {
			return new ObjectKii($objectkii[0]);
		}
		else
			return NULL;
	}

	public function processForm()
	{
		$name_kvito = htmlentities($_POST['name_kvito'], ENT_QUOTES);
		$reg_number = htmlentities($_POST['reg_number'], ENT_QUOTES);
		$certificate = htmlentities($_POST['certificate'], ENT_QUOTES);
		$order = htmlentities($_POST['order'], ENT_QUOTES);

		if (empty($_POST['id'])) {
			$sql = "INSERT INTO object_kii (name_kvito, reg_number, certificate, \"order\", id_department) VALUES (:name_kvito, :reg_number, :certificate, :order, :id_department)";
		}
		else {
			$id = (int) $_POST['id'];
			$sql = "UPDATE object_kii SET name_kvito=:name_kvito, reg_number=:reg_number, certificate=:certificate, \"order\"=:order WHERE id=$id";
		}
		try
		{
			$stmt = $this->db->prepare($sql);
			$stmt->bindParam(":name_kvito", $name_kvito, PDO::PARAM_STR);
			$stmt->bindParam(":reg_number", $reg_number, PDO::PARAM_STR);
			$stmt->bindParam(":certificate", $certificate, PDO::PARAM_STR);
			$stmt->bindParam(":order", $order, PDO::PARAM_STR);
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

		$sql = "DELETE FROM object_kii WHERE id=:id";
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