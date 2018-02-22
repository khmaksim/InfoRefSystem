<?php
namespace domain;

class Technique extends DomainObject {
	public $id;
    public $fullname;
    public $shortname;
	public $id_department;

    function __construct($id=null, $fullname=null, $shortname=null, $id_department=null) {
    	$this->id = $id;
        $this->fullname = $fullname;
        $this->shortname = $shortname;
		$this->id_department = $id_department;
    }
}

?>
