<?php
namespace view;

class ViewHelper {
	static function getRequest() {
		return \base\RequestRegistry::getRequest();
	}	
}

?> 