<?php
namespace domain;

class ObjectKii extends DomainObject {
	public $id;	
	public $name_kvito;	
	public $reg_number;
	public $certificate;
	public $order;
	public $id_department;

	function __construct($id=null, $name_kvito=null, $reg_number=null, $certificate=null, $order=null, $id_department=null) {
		$this->id = $id;
		$this->name_kvito = $name_kvito;
		$this->reg_number = $reg_number;
		$this->certificate = $certificate;
		$this->order = $order;
		$this->id_department = $id_department;
	}
}
?>