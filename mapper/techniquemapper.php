<?php
namespace mapper;

class TechniqueMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM technique WHERE deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM technique WHERE id=? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE technique SET fullname=?, shortname=?, id_department=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO technique (fullname, shortname, id_department) VALUES(?, ?, ?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE technique SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new TechniqueCollection($raw, $this);
    }

	protected function doCreateObject(array $array) {
		$obj = new \domain\Technique($array['id']);
		$obj->fullname = $array['fullname'];
		$obj->shortname = $array['shortname'];
    	$obj->id_department = $array['id_department'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\Technique)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->fullname, $object->shortname, $object->id_department);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->fullname, $object->shortname, $object->id_department, $object->id);
		$this->updateStmt->execute($values);
	}

	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }

    function delete(\domain\DomainObject $object) {
		$values = array($object->id);
		$this->deleteStmt->execute($values);
	}
}

?>
