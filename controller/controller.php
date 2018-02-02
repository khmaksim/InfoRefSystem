<?php
namespace controller;

class Controller {
	private $applicationHelper;
	
	private function __construct() {}
	
	static function run() {
		$instance = new Controller();
		$instance->init();
		$instance->handleRequest();
	}
	function init() {
		$applicationHelper = ApplicationHelper::instance();
		$applicationHelper->init();
	}
	function handleRequest() {
		$request = \base\RequestRegistry::getRequest();
		$appController = \base\ApplicationRegistry::appController();
		$manager = \base\RequestRegistry::getAccessManager();

		$user = $manager->auth();
		if (!is_null($user))
			$request->setProperty('user', $user);
		else
			$request->setProperty('cmd', 'Login');

		while ($cmd = $appController->getCommand($request)) {
			$cmd->execute($request);
		}
		$this->invokeView($appController->getView($request));
	}

	function invokeView($target) {
		include("view/$target.php");
		exit;
	}
}
?>