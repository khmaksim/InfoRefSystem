<?php

class ScientificResearchDesignWork extends DatabaseConnect 
{
	public $id;	
	public $year;
	public $file_name;
	
	public function __construct($product=NULL)
	{
		if (is_array($product)) {
			$this->id = $product['id'];
			$this->year = $product['year'];
			$this->file_name = $product['file_name'];
		}
		else {
			$this->id = "";
			$this->year = "";
			$this->file_name = "";
		}
	}
}

?>