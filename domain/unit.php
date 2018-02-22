<?php
namespace domain;

class Unit extends DomainObject {
	public $id;
	public $id_department;
	public $department;
    public $id_position;
    public $position;
    public $tariff_category;
    public $id_military_rank;
    public $military_rank;
    public $id_access_type;
    public $access_type;
    public $order_number;
    public $order_owner;
    public $dateorderstart;
    public $dateorderend;
    public $vacant;

    function __construct($id=null, $id_department=null, $department=null, $id_position=null, $position=null, $tariff_category=null, $id_military_rank=null, $military_rank=null, $id_access_type=null, $access_type=null, $order_number=null, $order_owner=null, $dateorderstart=null, $dateorderend=null, $vacant=null) {
    	$this->id = $id;
		$this->id_department = $id_department;
		$this->department = $department;
    	$this->id_position = $id_position;
    	$this->position = $position;
    	$this->tariff_category = $tariff_category;
    	$this->id_military_rank = $id_military_rank;
    	$this->military_rank = $military_rank;
    	$this->id_access_type = $id_access_type;
    	$this->access_type = $access_type;
    	$this->order_number = $order_number;
    	$this->order_owner = $order_owner;
    	$this->dateorderstart = $dateorderstart;
    	$this->dateorderend = $dateorderend;
    	$this->vacant = $vacant;
    }
}

?>
