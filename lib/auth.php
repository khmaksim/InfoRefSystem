<?php
    function login($username, $userpwd, $dbconn = false) {
	    // Проверка наличия такого пользователя и его пароля в БД, при удаче возвращает true в противном случае false
	    // подключаемя к БД
	    // Ошибка подключения к БД
		if (!$dbconn) {
		    return false;
		    exit;
		} else {
            try {
                $sql = "SELECT * FROM public.user WHERE name = '" . $username . "' LIMIT 1;";
                $res = $dbconn->query($sql);
                // Пользователя с таким именем в БД нет
                if ($res->rowCount() == 0) {
                    return false;
                    exit;
                } else {
                    $res = $res->fetchAll();
                    // Пароль совпал
                    if ($res[0]['passwd'] == md5($userpwd)) {
                        // $_SESSION['user_id'] = $res[0]['id'];
                        
                        return true;
                    // Пароль не подошел
              		} else {
                        return false;
              		    exit;
                    }
                }
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br />";
            }
		}
	}

	function AuthUser() {
	// Проверяем вошёл ли пользователь в систему и если да выводим сообщение об этом
		if (isset($_SESSION['user_id'])) {
			return true;
		}
		else {
		  return false;
		}
	}


