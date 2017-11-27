<?php

class Enterprise extends DatabaseConnect 
{
	public $id;	
	public $name;
	public $location;
	public $head;
	public $post;
	
	public function __construct($product=NULL)
	{
		if (is_array($product)) {
			$this->id = $product['id'];
			$this->name = $product['name'];
			$this->location = $product['location'];
			$this->head = $product['head'];
			$this->post = $product['post'];
		}
		else {
			$this->id = "";
			$this->name = "";
			$this->location = "";
			$this->head = "";
			$this->post = "";
		}
	}
}

?>