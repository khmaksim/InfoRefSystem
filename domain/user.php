<?php
namespace domain;

class User extends DomainObject {
	public $id;
	public $name;	
	public $active;
  	public $title;
  	public $bdate;
  	public $adate;
  	public $img_ext;
	public $passwd;
	public $success_login;
	public $num_login;
	public $ban_before_day;
	public $role;
	public $id_role;

	function __construct($id=null, $name=null, $active=null, $title=null, $bdate=null, $adate=null, $img_ext=null, $passwd=null, $role=null, $id_role=null) {
		$this->id = $id;
		$this->name = $name;
		$this->active = $active;
		$this->title = $title;
		$this->bdate = $bdate;
		$this->adate = $adate;
		$this->img_ext = $img_ext;
		$this->passwd = $passwd;
		$this->success_login = false;
		$this->role = $role;
		$this->id_role = $id_role;
		parent::__construct($this->id);
	}
}

?>