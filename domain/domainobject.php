<?php

abstract class DomainObject {
	private $ id;
	
	function construct($id=null) {
		$this->id = $id;
	}
	
	function getId() {
		return $this->id;
	}

	static function getCollection($type) {
		return array(); 		// Заглушка
	}

	function collection() {
		return self::getCollection(get_class($this));
	}
}

?>