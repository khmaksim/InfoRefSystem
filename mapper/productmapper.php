<?php
namespace mapper;

class ProductMapper extends Mapper implements \domain\UserFinder {
	function __construct() {
		parent::__construct();
		$this->selectAllStmt = self::$PDO->prepare("SELECT * FROM product WHERE deleted IS NULL");
		$this->selectStmt = self::$PDO->prepare("SELECT * FROM product WHERE id=? AND deleted IS NULL");
		$this->selectByCipherStmt = self::$PDO->prepare("SELECT * FROM product WHERE cipher=? AND deleted IS NULL");
		$this->updateStmt = self::$PDO->prepare("UPDATE product SET index=?, cipher=?, description=?, creator=?, security_label=?, image_file_name=? WHERE id=?");
		$this->insertStmt = self::$PDO->prepare("INSERT INTO product (index, cipher, description, creator, security_label, image_file_name) VALUES (?, ?, ?, ?, ?, ?)");
		$this->deleteStmt = self::$PDO->prepare("UPDATE product SET deleted=now() WHERE id=?");
	}

	function getCollection(array $raw) {
        return new ProductCollection($raw, $this);
    }

    protected function doCreateObject(array $array) {
		$obj = new \domain\Product($array['id']);
		$obj->index = $array['index'];
		$obj->cipher = $array['cipher'];
		$obj->description = $array['description'];
		$obj->creator = $array['creator'];
		$obj->security_label = $array['security_label'];
		$obj->image_file_name = $array['image_file_name'];
		return $obj;
	}

	protected function doInsert(\domain\DomainObject $object) {
		if (!($object instanceof \domain\Product)) {
			throw new Exception("Error argument", 1);
		}
			
		$values = array($object->index, $object->cipher, $object->description, $object->creator, $object->security_label, $object->image_file_name);
		$this->insertStmt->execute($values);
		$id = self::$PDO->lastInsertId();
		$object->id = $id;
	}

	function update(\domain\DomainObject $object) {
		$values = array($object->index, $object->cipher, $object->description, $object->creator, $object->security_label, $object->image_file_name, $object->id);
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

	function findByCipher($cipher) {
		$this->selectByCipherStmt->execute(array($cipher));
		$array = $this->selectByCipherStmt->fetch();
		$this->selectByCipherStmt->closeCursor();
		
		if (!is_array($array)) { 
			return null;
		}
		
		if (!isset($array['id'])) {
			return null;
		}
    	
		$object = $this->createObject($array);
		return $object;
	}
}

?>