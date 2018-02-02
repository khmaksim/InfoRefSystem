<?php
namespace mapper;

class ObjectKiiMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM object_kii");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM object_kii WHERE id = ?");
		$this->updateStmt = self::$PDO->prepare("UPDATE object_kii SET name_kvito=?, reg_number=?, certificate=?, \"order\"=? WHERE id=?");
		// $this->updateAntibrutforceStmt = self::$PDO->prepare("UPDATE antibrutforce SET col=?, unban=? WHERE id_user=? AND deleted IS NULL");
		// $this->insertAntibrutforceStmt = self::$PDO->prepare("INSERT INTO antibrutforce (col, id_user) VALUES (?, ?)");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO object_kii (name_kvito, reg_number, certificate, \"order\", id_department) VALUES (?, ?, ?, ?, ?)");
		// $this->insertLoginStmt = self::$PDO->prepare("INSERT INTO public.user_login (user_id, success, ldate) VALUES(?, ?, date('Y-m-d H:i:s'))");
		// $this->deleteAntibrutforceStmt = self::$PDO->prepare("UPDATE antibrutforce SET deleted=date('Y-m-d H:i:s') WHERE id_user=? AND deleted IS NULL");
	}

	function getCollection(array $raw) {
        return new ObjectKiiCollection($raw, $this);
    }

    protected function doCreateObject(array $array) {
		$obj = new \domain\ObjectKii($array['id']);
		$obj->name_kvito = $array['name_kvito'];
		$obj->reg_number = $array['reg_number'];
  		$obj->certificate = $array['certificate'];
  		$obj->order = $array['order'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\ObjectKii)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->name_kvito, $object->reg_number, $object->certificate, $object->order);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->setId($id);
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->name_kvito(), $object->reg_number, $object->certificate, $object->order, $object->getId());
		$this->updateStmt->execute($values);
	}

	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }

	// private function _loadData($id=NULL, $id_departments=NULL)
	// {
	// 	$sql = "SELECT * FROM object_kii";
	// 	if (!empty($id)) {
	// 		$sql .= " WHERE id=:id LIMIT 1";
	// 	} 
	// 	else if (!empty($id_departments)) {
	// 		$sql .= " WHERE id_department IN (" . implode(",", $id_departments) . ")";
	// 	}
	// 	try	{
	// 		$stmt = $this->db->prepare($sql);
	// 		if (!empty($id)) {
	// 			$stmt->bindParam(":id", $id, PDO::PARAM_INT);
	// 		}
	// 		$stmt->execute();
	// 		$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	// 		$stmt->closeCursor();
	// 		return $results;
	// 	}
	// 	catch (Exception $e) {
	// 		die ($e->getMessage());
	// 	}
	// }

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
				<input type="text" name="reg_number" class="form-control" id="exampleInputRegNumber" placeholder="Регистрационный номер" value="' . $objectkii->reg_number . '">
			</div>
			<div class="form-group">
				<label for="exampleInputAttestat">Аттестат</label>
				<input type="text" name="certificate" class="form-control" id="exampleInputAttestat" placeholder="Аттестат" value="' . $objectkii->certificate . '">
			</div>
			<div class="form-group">
				<label for="exampleInputOrder">Приказ</label>
				<input type="text" name="order" class="form-control" id="exampleInputOrder" placeholder="Приказ" value="' . $objectkii->order . '">
			</div>
		';
	}
}

?>