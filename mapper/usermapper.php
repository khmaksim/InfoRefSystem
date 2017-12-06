<?php

namespace mapper;

class UserMapper extends Mapper {
	function __construct() {
		parent::__construct();
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM user WHERE id=?");
		$this->updateStmt = self::$PDO->prepare("UPDATE user SET name=?, active=?, title=?, bdate=?, adate=?, img_ext=?, editable=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO user (name, active, title, bdate, adate, img_ext, editable) VALUES(?, ?, ?, ?, ?, ?, ?)");
	}

	protected function doCreateObject(array $array) {
		$obj = new \isszgt\domain\User($array['id']);
		$obj->setName($array['name']);
		$obj->setAtive($array['active']);
  		$obj->setTitle($array['title']);
  		$obj->setBdate($array['bdate']);
  		$obj->setAdate($array['adate']);
  		$obj->setImg($array['img_ext']);
		$obj->setEditable($array['editable']);
	}

	protected function doInsert(\isszgt\domain\DomainObject $object) {
		if (!($object instanceof \domain\User)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->getName(), $object->getActive(), $object->getTitle(), $object->getBdate(), $object->getAdate(), $object->getImg(), $object->getEditable());
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->setId($id);
	}

	function update(\isszgt\domain\DomainObject $object) {
		$values = array($object->getName(), $object->getId(), $object->getId());
		$this->updateStmt->execute($values);
	}
	
	function selectStmt() {
		return $this->selectStmt;
	}
}

?>