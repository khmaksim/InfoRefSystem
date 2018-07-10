<?php
namespace mapper;

class DocumentMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM document WHERE deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM document WHERE id = ? AND deleted IS NULL");
		$this->selectBySectionStmt = self::$PDO->prepare("SELECT * FROM document WHERE section LIKE ? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE document SET name=?, section=?, file_name=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO document (name, section, file_name) VALUES (?, ?, ?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE document SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new ObjectKiiCollection($raw, $this);
    }

    protected function doCreateObject(array $array) {
		$obj = new \domain\ObjectKii($array['id']);
		$obj->name = $array['name'];
		$obj->section = $array['section'];
  		$obj->file_name = $array['file_name'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\Document)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->name, $object->section, $object->file_name);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->name, $object->section, $object->file_name, $object->id);
		$this->updateStmt->execute($values);
	}

	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }

    function findBySection($section) {
    	$section = '%'. $section .'%';
    	$this->selectBySectionStmt->execute(array($section));
        return $this->getCollection($this->selectBySectionStmt->fetchAll(\PDO::FETCH_ASSOC));
    }

    function delete(\domain\DomainObject $object) {
    	$values = array($object->id);
		$this->deleteStmt->execute($values);
    }
}

?>