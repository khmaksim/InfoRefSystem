<?php
namespace controller;

class Request {
	private $properties;
	private $feedback = array();
	private $lastCommand;

	function __construct() {
		$this->init();
	}

	function init() {
		if (isset($_SERVER['REQUEST_METHOD'])) {
			$this->properties = $_REQUEST;
			if (isset($_SERVER['REQUEST_URI'])) {
				$this->setProperty('url', $_SERVER['REQUEST_URI']);
			}
			return;
		}
		// foreach ($_SERVER['argv'] as $arg) {
		// 	if (strpos($arg, '=')) {
		// 		list($key, $val) = explode("=", $arg);
		// 		$this->setProperty($key, $val);
		// 	}
		// }
	}

	function getProperty($key) {
		if (isset($this->properties[$key]))
			return $this->properties[$key];
		return null;
	}

	function setProperty($key,$val) {
		$this->properties[$key] = $val;
	}

	// function addFeedback($msg) {
	// 	array_push($this->feedback, $msg);
	// }

	// function getFeedback() {
	// 	return $this->feedback;
	// }

	// function getFeedbackString($separator="\n") { 
	// 	return implode($separator, $this->feedback);
	// }

	function clearLastCommand( ) {
        $this->lastCommand = null;
    }

    function setCommand(\command\Command $command) {
        $this->lastCommand = $command;
    }

    function getLastCommand() {
        return $this->lastCommand;
    }
}
?>