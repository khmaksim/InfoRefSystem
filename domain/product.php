<?php
namespace domain;

class Product extends DomainObject
{
	public $id;	
	public $index;	
	public $cipher;
	public $description;
	public $image_file_name;
	
	public function __construct($id=null, $index=null, $cipher=null, $description=null, $image_file_name=null)
	{
		$this->id = $id;
		$this->index = $index;
		$this->cipher = $cipher;
		$this->description = $description;
		$this->image_file_name = $image_file_name;
	}
}

?>