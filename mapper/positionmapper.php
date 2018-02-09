<?php
namespace mapper;

class PositionMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM position WHERE deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM position WHERE id=? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE position SET name=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO position (name) VALUES (?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE position SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new PositionCollection($raw, $this);
    }

    protected function doCreateObject(array $array) {
		$obj = new \domain\Position($array['id']);
		$obj->name = $array['name'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\Position)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->name);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->name, $object->id);
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