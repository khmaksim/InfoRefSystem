<?php
namespace mapper;

abstract class Mapper implements \domain\Finder {
	protected static $PDO;
	
	function __construct() {
		if (!isset(self::$PDO)) {
			$dsn = \base\ApplicationRegistry::getDSN();
			$userName = \base\ApplicationRegistry::getUsername();
			$passrd = \base\ApplicationRegistry::getPasswd();

			if (is_null($dsn)) {
				throw new \Exception("DSN not defined");
			}
			try {
				self::$PDO = new \PDO($dsn, $userName, $passrd);
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

	function findAll() {
        $this->selectAllStmt()->execute(array());
        return $this->getCollection($this->selectAllStmt()->fetchAll(\PDO::FETCH_ASSOC));
    }
	
	function createObject($array) {
		$obj = $this->doCreateObject($array);
		return $obj;
	}
	
	function insert(\domain\DomainObject $obj){
		$this->doInsert($obj);
	}

	abstract function update(\domain\DomainObject $object);
	protected abstract function doCreateObject(array $array);
	protected abstract function doInsert(\domain\DomainObject $object);
	protected abstract function selectStmt();
	protected abstract function selectAllStmt();
}

?>