<?php
namespace domain;

class Enterprise extends DomainObject
{
	public $id;	
	public $name;	
	public $location;
	public $head;
	public $post;
	
	public function __construct($id=null, $name=null, $location=null, $head=null, $post=null)
	{
		$this->id = $id;
		$this->name = $name;
		$this->location = $location;
		$this->head = $head;
		$this->post = $post;
	}
}

?>