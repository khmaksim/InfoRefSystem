<?php
namespace domain;

class Person extends DomainObject {
	public $id;	
	public $firstname;	
	public $lastname;
	public $patronymic;
	public $military;
	public $personalnumber;
	public $birthday;
	public $id_accesslevel;
	public $id_unit;
	public $id_department;
	public $editable;
	public $id_militaryrank;
	public $img_ext;
	public $address;
	public $id_city;
	public $note;
	public $deleted;

	function __construct($id=null, $firstname=null, $lastname=null, $patronymic=null, $military=null, $personalnumber=null, $birthday=null, $id_accesslevel=null, $id_unit=null, $id_department=null, $editable=null, $id_militaryrank=null, $img_ext=null, $address=null, $id_city=null, $note=null) {
		$this->$id = $id;	
		$this->firstname = $firstname;	
		$this->lastname = $lastname;
		$this->patronymic = $patronymic;
		$this->military = $military;
		$this->personalnumber = $personalnumber;
		$this->birthday = $birthday;
		$this->id_accesslevel = $id_accesslevel;
		$this->id_unit = $id_unit;
		$this->id_department = $id_department;
		$this->editable = $editable;
		$this->id_militaryrank = $id_militaryrank;
		$this->img_ext = $img_ext;
		$this->address = $address;
		$this->id_city = $id_city;
		$this->note = $note;
	}
}
?>