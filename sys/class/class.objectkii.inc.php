<?php

class ObjectKii
{
	public $id;	
	public $name_kvito;	
	public $reg_number;
	public $certificate;
	public $order;
	public $id_department;

	public function __construct($object_kii=NULL)
	{
		if (is_array($object_kii)) {
			$this->id = $object_kii['id'];
			$this->name_kvito = $object_kii['name_kvito'];
			$this->reg_number = $object_kii['reg_number'];
			$this->certificate = $object_kii['certificate'];
			$this->order = $object_kii['order'];
			$this->id_unit = $object_kii['id_department'];
		}
		else {
			$this->name_kvito = "";
			$this->reg_number = "";
			$this->certificate = "";
			$this->order = "";
			$this->id_department = "";
		}
	}
}

?>