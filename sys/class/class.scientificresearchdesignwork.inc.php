<?php

class ScientificResearchDesignWork extends DatabaseConnect 
{
	public $id;	
	public $index;	
	public $cipher;
	public $description;
	public $image_file_name;
	
	public function __construct($product=NULL)
	{
		if (is_array($product)) {
			$this->id = $product['id'];
			$this->index = $product['index'];
			$this->cipher = $product['cipher'];
			$this->description = $product['description'];
			$this->image_file_name = $product['image_file_name'];
		}
		else {
			$this->id = "";
			$this->index = "";
			$this->cipher = "";
			$this->description = "";
			$this->image_file_name = "";
		}
	}
}

?>