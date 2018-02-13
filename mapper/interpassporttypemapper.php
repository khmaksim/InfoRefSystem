<?php
namespace mapper;

class InterpassportTypeMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM interpassport_type WHERE deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM interpassport_type WHERE id=? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE interpassport_type SET name=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO interpassport_type (name) VALUES (?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE interpassport_type SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new InterpassportTypeCollection($raw, $this);
    }

    protected function doCreateObject(array $array) {
		$obj = new \domain\InterpassportType($array['id']);
		$obj->name = $array['name'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\InterpassportType)) {
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