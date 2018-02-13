<?php
namespace mapper;

class PhonenumberTypeMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM phonenumber_type WHERE deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM phonenumber_type WHERE id=? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE phonenumber_type SET name=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO phonenumber_type (name) VALUES (?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE phonenumber_type SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new PhonenumberTypeCollection($raw, $this);
    }

	protected function doCreateObject(array $array) {
		$obj = new \domain\PhonenumberType($array['id']);
		$obj->name = $array['name'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\PhonenumberType)) {
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
