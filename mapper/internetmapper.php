<?php
namespace mapper;

class InternetMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM internet WHERE deleted IS NULL");
		$this->selectByDepartmentStmt = self::$PDO->prepare("SELECT * FROM internet WHERE deleted IS NULL AND id_department IN (?)");
		$this->selectStmt = self::$PDO->prepare("SELECT  * FROM internet WHERE id = ? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE internet SET location=?, permission=?, reg_number=?, composition=?, order=?, email=?, id_department=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO internet (location, permission, reg_number, composition, order, email, id_department) VALUES(?, ?, ?, ?, ?, ?, ?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE internet SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new InternetCollection($raw, $this);
    }

	protected function doCreateObject(array $array) {
		$obj = new \domain\Department($array['id']);
		$obj->location = $array['location'];	
		$obj->permission = $array['permission'];
		$obj->reg_number = $array['reg_number'];
		$obj->composition = $array['composition'];
		$obj->order = $array['order'];
		$obj->email = $array['email'];
		$obj->id_department = $array['id_department'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\Internet)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->location, $object->permission, $object->reg_number, $object->composition, $object->order, $object->email, $object->id_department);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->setId($id);
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->location, $object->permission, $object->reg_number, $object->composition, $object->order, $object->email, $object->id_department, $object->id);
		$this->updateStmt->execute($values);
	}

	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }

    function findByDepatrment($id_departmant_list) {
    	$values = array($id_departmant_list);
        $this->selectByDepartmentStmt->execute($values);
        return $this->getCollection($this->selectByDepartmentStmt()->fetchAll(\PDO::FETCH_ASSOC));
    }

    function delete(\domain\DomainObject $object) {
		$values = array($object->id);
		$this->deleteStmt->execute($values);
	}
}

?>
