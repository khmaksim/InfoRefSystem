<?php
namespace domain;

class InterpassportType extends DomainObject {
	public $id;	
	public $name;	

	function __construct($id=null, $name=null) {
		$this->id = $id;	
		$this->name = $name;	
	}
}
?>