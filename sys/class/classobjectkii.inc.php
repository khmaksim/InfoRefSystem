<?php

class ObjectKii extends DatabaseConnect 
{
	private $name_kvito;	
	private $reg_number;
	private $certificate;
	private $order;

	public fuction __construct($dbo=NULL) {
		parent::__construct($dbo);
	}
}

?>