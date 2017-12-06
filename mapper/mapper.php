<?php

namespace mapper;

abstract class Mapper {
	protected static $PDO;
	
	function __construct() {
		if (!isset(self::$PDO)) {
			$dsn = \base\ApplicationRegistry::getDSN();
			if (is_null($dsn)) {
				// throw new \base\AppException("DSN не определен");
			}
			try {
				self::$PDO = new \PDO($dsn, DB_USER, DB_PASS);
				// self::$PDO->setAttribute(\PDO::ATTR_ERRМODE, \PDO::ERRМODE_EXCEPTION);
			}
			catch(\PDOException $e) {
				echo $e->getMessage();
			}
		}
	}
	
	function find($id) {
		$this->selectStmt()->execute(array($id));
		$array = $this->selectStmt()->fetch();
		$this->selectStmt()->closeCursor();
		
		if (!is_array($array)) { 
			return null;
		}
		
		if (!isset($array['id'])) {
			return null;
		}
		
		$object = $this->createObject($array);
		return $object;
	}
	
	function createObject($array) {
		$obj = $this->doCreateObject($array);
		return $obj;
	}
	
	function insert(\isszgt\domain\DomainObject $obj){
		$this->doInsert($obj);
	}
	abstract function update(\isszgt\domain\DomainObject $object);
	protected abstract function doCreateObject(array $array);
	protected abstract function doInsert(\isszgt\domain\DomainObject $object);
	protected abstract function selectStmt();
}

?>