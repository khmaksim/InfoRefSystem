<?php

class Enterprise extends DatabaseConnect 
{
	public $id;	
	public $name;	
	public $location;
	public $head;
	
	public function __construct($product=NULL)
	{
		if (is_array($product)) {
			$this->id = $product['id'];
			$this->name = $product['name'];
			$this->location = $product['location'];
			$this->head = $product['head'];
		}
		else {
			$this->id = "";
			$this->name = "";
			$this->location = "";
			$this->head = "";
		}
	}
}

?>