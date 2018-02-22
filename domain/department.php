<?php
namespace domain;

class Department extends DomainObject {
	public $id;	
	public $fullname;	
	public $shortname;
	public $dep_index;
	public $server_addr;
	public $note;
	public $parent;
	public $active;

	function __construct($id=null, $fullname=null, $shortname=null, $dep_index=null, $server_addr=null, $note=null, $parent=null, $active=null) {
		$this->id = $id;	
		$this->fullname = $fullname;	
		$this->shortname = $shortname;
		$this->dep_index = $dep_index;
		$this->server_addr = $server_addr;
		$this->note = $note;
		$this->parent = $parent;
		$this->active = $active;
	}
}
?>