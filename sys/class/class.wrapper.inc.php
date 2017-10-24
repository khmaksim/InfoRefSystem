<?php

class Wrapper extends DatabaseConnect 
{
	public function __construct($dbo=NULL) {
		parent::__construct($dbo);
	}

	// public function getTitle($name) {
	// 	switch ($name) {
	// 		case 'objectskii':
	// 			$title = 'Объекты КИИ';
	// 			break;
	// 		default:
	// 			$title = '';
	// 	}
	// 	return $title;
	// }

	private function _loadObjectKiiData($id=NULL)
	{
		$sql = "SELECT id, name_kvito, reg_number, certificate, \"order\" FROM object_kii";
		if (!empty($id)) {
			$sql .= " WHERE id=:id LIMIT 1";
		}
		else {
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

	private function _createObjectKiiObj()
	{
		$arr = $this->_loadObjectKiiData();
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

	public function displayObjectsKii()
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
			';
		$objectskii = $this->_createObjectKiiObj();
		$count = 1;
		foreach ($objectskii as $object) {
			$html .= '<tr>
							<td>' . $count++ . '</td>
                            <td>' . $object->name_kvito . '</td>
                            <td>' . $object->reg_number . '</td>
                            <td>' . $object->certificate . '</td>
                            <td>' . $object->order . '</td>
                            <td class="col-xs-1 text-center"><a href="./objectskii_edit.php?action=edit&id='. $object->id .'" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete();" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                        </tr>';
		}
		return $html;
	}

	public function displayObjectKii($id=NULL)
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

	public function _loadObjectKiiByid($id)
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
			$sql = "INSERT INTO object_kii (name_kvito, reg_number, certificate, \"order\") VALUES (:name_kvito, :reg_number, :certificate, :order)";
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
			$stmt->execute();
			$stmt->closeCursor();
			return TRUE;
		}
		catch (Exception $e) {
			return $e->getMessage();
		}
	}
}

?>