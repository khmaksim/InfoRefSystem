<?php

class Wrapper extends DatabaseConnect 
{
	public function __construct($dbo=NULL) 
	{
		parent::__construct($dbo);
	}

	// public function getTitle($name) {
	// 	switch ($name) {
	// 		case 'objectskii':
	// 			$title = 'Объекты КИИ';
	// 			break;
	// 		default:
	// 			$title = '';
	// 	}
	// 	return $title;
	// }

	
}

?>