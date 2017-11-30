<?php

class ControlScientificResearchDesignWork extends DatabaseConnect 
{
	public $id;	
	public $date;	
	public $incomingNumber;
	public $name;
	public $result;
	
	public function __construct($product=NULL)
	{
		if (is_array($product)) {
			$this->id = $product['id'];
			$this->date = $product['date'];
			$this->incomingNumber = $product['incoming_number'];
			$this->name = $product['name'];
			$this->result = $product['result'];
		}
		else {
			$this->id = "";
			$this->date = "";
			$this->incomingNumber = "";
			$this->name = "";
			$this->result = "";
		}
	}
}

?>