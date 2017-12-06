<?php

namespace isszgt\domain;

class User extends DomainObject
{
	private $id;	
	private $name;	
	private $active;
  	private $title;
  	private $bdate;
  	private $adate;
  	private $img_ext;
	private $editable;

	function __construct($id=null, $name=null, $active=null, $title=null, $bdate=null, $adate=null, $img_ext=null, $ditable=null) {
		$this->id = $id;
		$this->name = $name;
		$this->active = $active;
		$this->title = $title;
		$this->bdate = $bdate;
		$this->adate = $adate;
		$this->img_ext = $img_ext;
		$this->editable = $editable;
		parent::__construct($this->id)
	}
	
	function getId() {
		return $this->id;
	}

	function getName() {
		return $this->name;
	}

	function getActive() {
		return $this->active;
	}

	function getTitle() {
		return $this->title;
	}

	function getBdate() {
		return $this->bdate;
	}

	function getaAdate() {
		return $this->adate;
	}

	function getImg() {
		return $this->img_ext;
	}

	function getEditable() {
		return $this->editable;
	}

	function setId($id) {
		$this->id = $id;
	}

	function setName($name) {
		$this->name = $name;
	}

	function setActive($active) {
		$this->active = $active;
	}

	function setTitle($title) {
		$this->title = $title;
	}

	function setBdate($bdate) {
		$this->bdate = $bdate;
	}

	function setAdate($adate) {
		$this->adate = $adate;
	}

	function setImg($img_ext) {
		$this->img_ext = $img_ext;
	}

	function setEditable($editable) {
		$this->editable = $editable;
	}
}

?>