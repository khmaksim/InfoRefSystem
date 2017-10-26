<?php

class Internet
{
	public $id;	
	public $location;	
	public $permission;
	public $reg_number;
	public $composition;
	public $order;
	public $email;
	public $id_department;

	public function __construct($internet=NULL)
	{
		if (is_array($internet)) {
			$this->id = $internet['id'];
			$this->location = $internet['location'];
			$this->permission = $internet['permission'];
			$this->reg_number = $internet['reg_number'];
			$this->composition = $internet['composition'];
			$this->order = $internet['order'];
			$this->email = $internet['email'];
			$this->id_unit = $internet['id_department'];
		}
		else {
			$this->location = "";
			$this->permission = "";
			$this->reg_number = "";
			$this->composition = "";
			$this->order = "";
			$this->email = "";
			$this->id_department = "";
		}
	}
}

?>