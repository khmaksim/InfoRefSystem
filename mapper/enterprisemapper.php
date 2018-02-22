<?php
namespace mapper;

class EnterpriseMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM enterprise WHERE deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM enterprise WHERE id = ? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE enterprise SET name=?, location=?, head=?, post=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO enterprise (name, location, head, post) VALUES (?, ?, ?, ?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE enterprise SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new EnterpriseCollection($raw, $this);
    }

    protected function doCreateObject(array $array) {
		$obj = new \domain\Enterprise($array['id']);
		$obj->name = $array['name'];
		$obj->location = $array['location'];
		$obj->head = $array['head'];
		$obj->post = $array['post'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\Enterprise)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->name, $object->location, $object->head, $object->post);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->name, $object->location, $object->head, $object->post, $object->id);
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