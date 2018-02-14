<?php
namespace mapper;

class ScientificWorkMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM scientific_research_design_work WHERE deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM scientific_research_design_work WHERE id = ? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE scientific_research_design_work SET year=?, file_name=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO scientific_research_design_work (year) VALUES (?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE scientific_research_design_work SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new ScientificWorkCollection($raw, $this);
    }

    protected function doCreateObject(array $array) {
		$obj = new \domain\ScientificWork($array['id']);
		$obj->year = $array['year'];
		$obj->file_name = $array['file_name'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\ScientificWork)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->year);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->year, $object->file_name, $object->id);
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