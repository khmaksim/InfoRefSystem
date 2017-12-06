<?php

class Role extends DatabaseConnect 
{
	public $id;	
	public $name;	

	public function __construct($object=NULL)
	{
		if (is_array($object)) {
			$this->id = $object['id'];
			$this->name = $object['name'];
		}
		else {
			$this->name = "";
		}
	}
	
	public function getId()
	{
		return $this->id;
	}

	public function getName()
	{
		return $this->name;
	}
}

?>