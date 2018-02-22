<?php
namespace mapper;

class UnitMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT u.id, u.id_department, d.fullname AS department, u.id_position, p.name AS position, u.tariff_category, u.id_military_rank, mr.name AS military_rank, u.id_access_type, at.name AS access_type, u.order_number, u.order_owner, u.dateorderstart, u.dateorderend, u.vacant FROM unit u LEFT OUTER JOIN department d ON u.id_department = d.id LEFT OUTER JOIN position p ON u.id_position = p.id LEFT OUTER JOIN military_rank mr ON u.id_military_rank = mr.id LEFT OUTER JOIN access_type at ON u.id_access_type = at.id WHERE u.deleted IS NULL");
		// $this->selectTreeStmt = self::$PDO->prepare("WITH recursive r AS (SELECT id, fullname, shortname, dep_index, server_addr, note, parent, active, deleted FROM department WHERE parent = 0 UNION SELECT t1.id, t1.fullname, t1.shortname, t1.dep_index, t1.server_addr, t1.note, t1.parent, t1.active, t1.deleted FROM department AS t1 JOIN r ON t1.parent = r.id) SELECT id, fullname, shortname, dep_index, server_addr, note, parent, active FROM r WHERE deleted IS NULL ORDER BY id, parent");
		$this->selectStmt = self::$PDO->prepare("SELECT u.id, u.id_department, d.fullname AS department, u.id_position, p.name AS position, u.tariff_category, u.id_military_rank, mr.name AS military_rank, u.id_access_type, at.name AS access_type, u.order_number, u.order_owner, u.dateorderstart, u.dateorderend, u.vacant FROM unit u LEFT OUTER JOIN department d ON u.id_department = d.id LEFT OUTER JOIN position p ON u.id_position = p.id LEFT OUTER JOIN military_rank mr ON u.id_military_rank = mr.id LEFT OUTER JOIN access_type at ON u.id_access_type = at.id WHERE u.id = ? AND u.deleted IS NULL");
		// $this->updateStmt = self::$PDO->prepare("UPDATE unit SET fullname=?, shortname=?, dep_index=?, server_addr=?, note=?, parent=?, active=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO unit (id_department, id_position, tariff_category, id_military_rank, id_access_type, order_number, order_owner, dateorderstart, dateorderend, vacant) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE unit SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new DepartmentCollection($raw, $this);
    }

	protected function doCreateObject(array $array) {
		$obj = new \domain\Unit($array['id']);
		$obj->id_department = $array['id_department'];
		$obj->department = $array['department'];
    	$obj->id_position = $array['id_position'];
    	$obj->position = $array['position'];
    	$obj->tariff_category = $array['tariff_category'];
    	$obj->id_military_rank = $array['id_military_rank'];
    	$obj->military_rank = $array['military_rank'];
    	$obj->id_access_type = $array['id_access_type'];
    	$obj->access_type = $array['access_type'];
    	$obj->order_number = $array['order_number'];
    	$obj->order_owner = $array['order_owner'];
    	$obj->dateorderstart = $array['dateorderstart'];
    	$obj->dateorderend = $array['dateorderend'];
    	$obj->vacant = $array['vacant'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\Unit)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->id, $object->id_department, $object->id_position, $object->tariff_category, $object->id_military_rank, $object->id_access_type, $object->order_number, $object->order_owner, $object->dateorderstart, $object->dateorderend, $object->vacant);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->id, $object->id_department, $object->id_position, $object->tariff_category, $object->id_military_rank, $object->id_access_type, $object->order_number, $object->order_owner, $object->dateorderstart, $object->dateorderend, $object->vacant, $object->id);
		$this->updateStmt->execute($values);
	}

	function selectStmt() {
		return $this->selectStmt;
	}

	function selectAllStmt() {
        return $this->selectAllStmt;
    }

    // function selectTreeStmt() {
    //     return $this->selectTreeStmt;
    // }

    // function getTree() {
    //     $this->selectTreeStmt()->execute(array());
    //     return $this->getCollection($this->selectTreeStmt()->fetchAll(\PDO::FETCH_ASSOC));
    // }

    function delete(\domain\DomainObject $object) {
		$values = array($object->id);
		$this->deleteStmt->execute($values);
	}
}

?>
