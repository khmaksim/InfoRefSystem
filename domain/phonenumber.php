<?php
namespace domain;

class PhoneNumber extends DomainObject {
	public $id;	
	public $number;	
	public $id_phone_number_type;
	public $id_person;

	function __construct($id=null, $number=null, $id_phone_number_type=null, $id_person=null) {
		$this->id = $id;	
		$this->number = $number;
		$this->id_phone_number_type = $id_phone_number_type;
		$this->id_person = $id_person;
	}
}
?>