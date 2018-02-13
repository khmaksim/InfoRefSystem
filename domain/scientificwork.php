<?php
namespace domain;

class ScientificWork extends DomainObject {
	public $id;	
	public $year;
	public $file_name;
	
	function __construct($id=null, $year=null, $file_name=null)
	{
		$this->id = $id;
		$this->year = $year;
		$this->file_name = $file_name;
	}
}

?>