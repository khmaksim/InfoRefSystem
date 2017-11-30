<?php

class Role extends DatabaseConnect 
{
	public $id;	
	public $name;	

	public function __construct($object=NULL)
	{
		if (is_array($object_kii)) {
			$this->id = $object['id'];
			$this->name = $object['name'];
		}
		else {
			$this->name = "";
		}
	}
}

?>