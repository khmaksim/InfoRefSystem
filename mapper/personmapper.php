<?php
namespace mapper;

class PersonMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM person WHERE deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM person WHERE id=? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE person SET firstname=?, lastname=?, patronymic=?, military=?, personal_number=?, birthday=?, id_access_type=?, id_unit=?, id_military_rank=?, img_ext=?, address=?, id_city=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO person (firstname, lastname, patronymic, military, personal_number, birthday, id_access_type, id_unit, id_military_rank, img_ext, address, id_city) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
	}

	function getCollection(array $raw) {
        return new PersonCollection($raw, $this);
    }

    protected function doCreateObject(array $array) {
		$obj = new \domain\Person($array['id']);
		$obj->firstname = $array['firstname'];	
		$obj->lastname = $array['lastname'];
		$obj->patronymic = $array['patronymic'];
		$obj->military = $array['military'];
		$obj->personal_number = $array['personal_number'];
		$obj->birthday = $array['birthday'];
		$obj->id_accesslevel = $array['id_access_type'];
		$obj->id_unit = $array['id_unit'];
		$obj->id_militaryrank = $array['id_military_rank'];
		$obj->img_ext = $array['img_ext'];
		$obj->address = $array['address'];
		$obj->id_city = $array['id_city'];
		$obj->note = $array['note'];
		$phoneNumberMapper = \base\RequestRegistry::getPhoneNumberMapper();
		$obj->phone_number_collection = $phoneNumberMapper->findByPerson($array['id']);
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\Person)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->firstname, $object->lastname, $object->patronymic, $object->military, $object->personal_number, $object->birthday, $object->id_access_type, $object->id_unit, $object->id_military_rank, $object->img_ext, $object->address, $object->id_city, $object->note);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->firstname, $object->lastname, $object->patronymic, $object->military, $object->personal_number, $object->birthday, $object->id_access_type, $object->id_unit, $object->id_military_rank, $object->img_ext, $object->address, $object->id_city, $object->note, $object->id);
		$this->updateStmt->execute($values);
	}

	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }
}

?>