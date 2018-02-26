<?php
namespace mapper;

class PhoneNumberMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM phone_number WHERE deleted IS NULL");
		$this->selectByPersonStmt = self::$PDO->prepare("SELECT * FROM phone_number WHERE id_person AND deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM phone_number WHERE id=? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE phone_number SET number=?, id_phone_number_type=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO phone_number (number, id_phone_number_type, id_person) VALUES (?, ?, ?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE phone_number SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new PhoneNumberCollection($raw, $this);
    }

	protected function doCreateObject(array $array) {
		$obj = new \domain\PhoneType($array['id']);
		$obj->number = $array['number'];
		$obj->id_phone_number_type = $array['id_phone_number_type'];
		$obj->id_person = $array['id_person'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\PhoneNumber)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->number, $object->id_phone_number_type, $object->id_person);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->number, $object->id_phone_number_type, $object->id);
		$this->updateStmt->execute($values);
	}

	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }

    function selectByPersonStmt() {
        return $this->selectByPersonStmt;
    }

    function findByPerson($id_person) {
        $this->selectByPersonStmt()->execute(array($id_person));
        return $this->getCollection($this->selectByPersonStmt()->fetchAll(\PDO::FETCH_ASSOC));
    }

    function delete(\domain\DomainObject $object) {
		$values = array($object->id);
		$this->deleteStmt->execute($values);
	}
}

?>
