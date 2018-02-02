<?php
namespace domain;

class Document extends DomainObject {
	public $id;	
	public $name;	
	public $section;
	public $file_name;

	function __construct($id=null, $name=null, $section=null, $file_name=null) {
		$this->id = $id;
		$this->name = $name;
		$this->section = $section;
		$this->file_name = $file_name;
	}
}
?>