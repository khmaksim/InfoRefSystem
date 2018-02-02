<?php
namespace domain;

class Internet extends DomainObject {
	public $id;	
	public $location;	
	public $permission;
	public $reg_number;
	public $composition;
	public $order;
	public $email;
	public $id_department;

	function __construct($id=null, $location=null, $permission=null, $reg_number=null, $composition=null, $order=null, $email=null, $id_department=null) {
		$this->id = $id;	
		$this->location = $location;	
		$this->permission = $permission;
		$this->reg_number = $reg_number;
		$this->composition = $composition;
		$this->order = $order;
		$this->email = $email;
		$this->id_department = $id_department;
	}
}
?>