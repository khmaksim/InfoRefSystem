<?php
namespace domain;

class Person extends DomainObject {
	public $id;	
	public $firstname;	
	public $lastname;
	public $patronymic;
	public $military;
	public $personal_number;
	public $birthday;
	public $id_access_type;
	public $id_unit;
	public $id_military_rank;
	public $img_ext;
	public $address;
	public $id_city;
	public $note;
	public $deleted;

	function __construct($id=null, $firstname=null, $lastname=null, $patronymic=null, $military=null, $personal_number=null, $birthday=null, $id_access_type=null, $id_unit=null, $id_military_rank=null, $img_ext=null, $address=null, $id_city=null, $note=null) {
		$this->$id = $id;	
		$this->firstname = $firstname;	
		$this->lastname = $lastname;
		$this->patronymic = $patronymic;
		$this->military = $military;
		$this->personal_number = $personal_number;
		$this->birthday = $birthday;
		$this->id_access_type = $id_access_type;
		$this->id_unit = $id_unit;
		$this->id_military_rank = $id_military_rank;
		$this->img_ext = $img_ext;
		$this->address = $address;
		$this->id_city = $id_city;
		$this->note = $note;
	}

	function getFullName() {
		return $this->lastname .' '. $this->firstname .' '. $this->patronymic;  
	}
}
?>