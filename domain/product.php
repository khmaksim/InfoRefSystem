<?php
namespace domain;

class Product extends DomainObject
{
	public $id;	
	public $index;	
	public $cipher;
	public $description;
	public $creator;
	public $security_label;
	public $image_file_name;
	
	public function __construct($id=null, $index=null, $cipher=null, $description=null, $creator=null, $security_label=null, $image_file_name=null)
	{
		$this->id = $id;
		$this->index = $index;
		$this->cipher = $cipher;
		$this->description = $description;
		$this->creator = $creator;
		$this->security_label = $security_label;
		$this->image_file_name = $image_file_name;
	}
}

?>