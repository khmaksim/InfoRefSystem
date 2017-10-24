<?php

class ObjectKii
{
	public $id;	
	public $name_kvito;	
	public $reg_number;
	public $certificate;
	public $order;

	public function __construct($object_kii=NULL)
	{
		if (is_array($object_kii)) {
			$this->id = $object_kii['id'];
			$this->name_kvito = $object_kii['name_kvito'];
			$this->reg_number = $object_kii['reg_number'];
			$this->certificate = $object_kii['certificate'];
			$this->order = $object_kii['order'];
		}
		else {
			$this->name_kvito = "";
			$this->reg_number = "";
			$this->certificate = "";
			$this->order = "";	
		}
	}
}

?>