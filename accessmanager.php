<?php
class AccessManager {
    private $error;
    private $num_attempts = 3;
    private $userMapper;

    function __construct() {
        $this->userMapper = \base\RequestRegistry::getUserMapper();
    }

	function login($username, $passwd) {
        $collection = $this->userMapper->findAll();
        $gen = $collection->getGenerator();

        foreach ($gen as $user) {
            echo $user->name;
            if ($user && $user->name == $username) {
                if ($user->passwd == md5($passwd)) {                
                    $user->success_login = true;
                }
                if (!$this->checkBan($user)) {
                    $user->success_login = false;   
                }

                $this->userMapper->insertLogin($user);
                if ($user->success_login) {
                    return $user;
                }
            }
        }
        return null;
	}

    function logout() {
        unset ($_SESSION['id_user']);
    }

	function auth() {
        $session = \base\SessionRegistry::instance();
        $user = $this->userMapper->find($session->getIdUser());

        if (!is_null($user)) {
            return $user;
        }
		return null;
	}

    function checkBan($user) {
        $ban_day = $user->ban_before_day;        // день снятия запрета

        if ($user->success_login) {
            if (is_null($ban_day) && is_null($user->num_login))
                return true;
            else if (!is_null($ban_day) && (int)date("d") < $ban_day) {
                $this->error = 'Исчерпан лемит попыток авторизации.<br />Зайдите завтра';
                unset($_SESSION['user_id']);
                return false;
            }
            else if (!is_null($user->num_login) || (!is_null($ban_day) && (int)date("d") >= $ban_day)) {
                $this->userMapper->deleteAntibrutforce($user);
                return true;
            }
        }
        else {
            if (!is_null($user->num_login)) {
                $user->num_login = $user->num_login + 1;
                if ($user->num_login < $this->num_attempts)
                    $this->error = 'Логин или пароль не верны<br/> Осталось ' .($this->num_attempts - $user->num_login). ' попыток';
                else {
                    $user->setBanBeforeDay((int)date("d") + 1);
                    $this->error = 'Логин или пароль не верны<br/> Исчерпан лемит попыток авторизации<br />Зайдите завтра';    
                }
                $this->userMapper->updateAntibrutforce($user);
            }
            else if (is_null($user->num_login)) {
                $user->num_login = 1;
                $this->error = 'Логин или пароль не верны<br/> Осталось ' .($this->num_attempts - $user->num_login). ' попыток';
                $this->userMapper->insertAntibrutforce($user);
            }
        }
        return false;
    }

    function getError() {
        return $this->error;
    }
}
?>