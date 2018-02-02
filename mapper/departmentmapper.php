<?php
namespace mapper;

class DepartmentMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM department");
		$this->selectTreeStmt = self::$PDO->prepare("WITH recursive r AS (SELECT id, fullname, shortname, dep_index, server_addr, note, parent, active, editable FROM department WHERE parent = 0 UNION SELECT t1.id, t1.fullname, t1.shortname, t1.dep_index, t1.server_addr, t1.note, t1.parent, t1.active, t1.editable FROM department AS t1 JOIN r ON t1.parent = r.id) SELECT id, fullname, shortname, dep_index, server_addr, note, parent, active, editable FROM r ORDER BY id, parent");
		$this->selectStmt = self::$PDO->prepare("SELECT  * FROM department WHERE id = ?");
		$this->updateStmt = self::$PDO->prepare("UPDATE department SET fullname=?, shortname=?, dep_index=?, server_addr=?, note=?, parent=?, active=?, editable=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO department (fullname, shortname, dep_index, server_addr, note, parent, active, editable) VALUES(?, ?, ?, ?, ?, ?, ?, ?)");
	}

	function getCollection(array $raw) {
        return new DepartmentCollection($raw, $this);
    }

	protected function doCreateObject(array $array) {
		$obj = new \domain\Department($array['id']);
		$obj->fullname = $array['fullname'];	
		$obj->shortname = $array['shortname'];
		$obj->dep_index = $array['dep_index'];
		$obj->server_addr = $array['server_addr'];
		$obj->note = $array['note'];
		$obj->parent = $array['parent'];
		$obj->active = $array['active'];
		$obj->editable = $array['editable'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\Department)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->fullname, $object->shortname, $object->dep_index, $object->server_addr, $object->note, $object->parent, $object->active, $object->editable);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->setId($id);
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->fullname, $object->shortname, $object->dep_index, $object->server_addr, $object->note, $object->parent, $object->active, $object->editable, $object->getId());
		$this->updateStmt->execute($values);
	}

	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }

    function selectTreeStmt() {
        return $this->selectTreeStmt;
    }

    function getTree() {
        $this->selectTreeStmt()->execute(array());
        return $this->getCollection($this->selectTreeStmt()->fetchAll(\PDO::FETCH_ASSOC));
    }
}

?>
