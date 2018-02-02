<?php
namespace domain;

abstract class DomainObject {
	private $id;
	
	function __construct($id=null) {
		$this->id = $id;
	}
	
	function getId() {
		return $this->id;
	}

	static function getCollection($type=null) {
		if (is_null($type)) {
			return HelperFactory::getCollection(get_called_class()); 	
		}
		return HelperFactory::getCollection($type); 
	}

	function collection() {
		return self::getCollection(get_class($this));
	}
}

?>