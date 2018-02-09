<?php
namespace domain;

class MilitaryRank extends DomainObject {
	public $id;	
	public $name;	
	public $deleted;

	function __construct($id=null, $name=null) {
		$this->id = $id;	
		$this->name = $name;	
	}
}
?>