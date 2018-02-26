<?php
namespace domain;

class PhoneNumberType extends DomainObject {
	public $id;	
	public $name;	

	function __construct($id=null, $name=null) {
		$this->id = $id;	
		$this->name = $name;	
	}
}
?>