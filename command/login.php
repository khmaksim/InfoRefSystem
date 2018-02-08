<?php
namespace command;

class Login extends Command {
	function doExecute(\controller\Request $request) {
		$manager = \base\RequestRegistry::getAccessManager();
		$session = \base\SessionRegistry::instance();

		// $user = $manager->auth();
		// if (!is_null($user)) {
		// 	$request->setProperty('user', $user);
		// 	return self::statuses('CMD_OK');
		// }

		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$username = $request->getProperty('name');
			$passwd = $request->getProperty('passwd');
			
			if (is_null($username) || is_null($passwd)) {
				$request->setProperty('error', 'Введите логин и пароль');
				return self::statuses('CMD_ERROR');
			}
			$user = $manager->login($username, $passwd);
			if (is_null($user)) {
				$request->setProperty('error', $manager->getError());
				return self::statuses('CMD_ERROR');
			}
			else {
				$request->setProperty('authorized_user', $user);

				$session->setIdUser($user->id);
				return self::statuses('CMD_OK');
			}
		}
		return self::statuses('CMD_DEFAULT');
	}
}
?>