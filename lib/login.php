<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getuseridbyname.func.php';

    ConnectDatabase();

    define('PASS_ATTEMPTS', 3);

	//очищаем ошибки
	unset ($_SESSION['error']);

    // Пользователь пытается войти
	if ( $_POST['act'] == 'login' ) {
  	    //создаем переменные для хранения логина и пароля введенных пользователем
  	    $username = $_POST['name'];
        $userpwd = $_POST['passwd'];
        // Если логин и пароль не пусты ищем такого пользователя
  	    if ($username && $userpwd) {

  	        // Логин и пароль есть в БД
  	        if (login($username, $userpwd, $dbconn)) {
  	            //проверяем, не в бане ли пользователь
                $sql = "SELECT * FROM public.antibrutforce WHERE user_name = '" . $username . "' LIMIT 1;";
                $res = $dbconn->query($sql);
                // Пользователь с таким именем в БД есть
                if ($res->rowCount() != 0) {
                    //если этот пользователь уже есть в БД, то сравниваем значение поля unban и сегодняшний календарный день
                    $res = $res->fetchAll();
                    //получаем количество совершенных попыток
                    $unban = $res[0]['unban'];
                    $day = (int)date("d");
                    if ($day < $unban && $unban != 0) {
                        //день разбана еще не наступил и в unban не 0 (значение по умолчанию)
                        $_SESSION['error'] = 'Для Вашего IP исчерпан лемит попыток авторизации.<br />Зайдите завтра.';
                        unset ($_SESSION['user_id']);
                        $dbconn->query("INSERT INTO public.user_login(user_id, success, ldate) VALUES(" . getUserIdByName($username) . ", false, '" . date('Y-m-d H:i:s e') . "')");
                    } else {
                        // Удаляем попытки входа ранее
                        $dbconn->query("DELETE FROM public.antibrutforce WHERE user_name = '" . $username . "'");
                        // Фиксируем вход пользователя
                        $dbconn->query("INSERT INTO public.user_login(user_id, success, ldate) VALUES(" . getUserIdByName($username) . ", true, '" . date('Y-m-d H:i:s e') . "')");
                    }
                // Пользователя с таким именем в БД нет
                } else {
                    // Удаляем попытки входа ранее
                    $dbconn->query("DELETE FROM public.antibrutforce WHERE user_name = '" . $username . "'");
                    // Фиксируем вход пользователя
                    $dbconn->query("INSERT INTO public.user_login(user_id, success, ldate) VALUES(" . getUserIdByName($username) . ", true, '" . date('Y-m-d H:i:s e') . "')");
                    $_SESSION['error'] = "Здравствуйте!";
                }
            // Логин или пароль не верны
  		    } else {
  		        if (getUserIdByName($username)) {
  		            $dbconn->query("INSERT INTO public.user_login(user_id, success, ldate) VALUES(" . getUserIdByName($username) . ", false, '" . date('Y-m-d H:i:s e') . "')");
  		        }
                $sql = "SELECT col FROM public.antibrutforce WHERE user_name = '" . $username . "';";
                $res = $dbconn->query($sql, PDO::FETCH_ASSOC);
                // Пользователь с таким именем в БД есть
                if ($res->rowCount() != 0) {
                    $res = $res->fetchAll();
                    //получаем количество совершенных попыток
                    $col = $res[0]['col'];
                    if ($col < PASS_ATTEMPTS) {
                        //если их меньше, чем константа PASS_ATTEMPTS (макс. колич. попыток)
                        //то просто записываем в БД, что попыток стало на 1 больше
                        $dbconn->query("UPDATE public.antibrutforce SET col = '" . ($col + 1) . "' WHERE user_name = '" . $username . "'");
                        //а в переменную $error добавляем сколько осталось, чтобы показать ее пользователю
                        $_SESSION['error'] .= ' Осталось ' .(PASS_ATTEMPTS - ($col+1)). ' попыток.';
                    } else {
                        //больше нет попыток - в бан на 1 день
                        $date = (int)date("d") + 1;
                        $dbconn->query("UPDATE public.antibrutforce SET unban = '" . $date . "' WHERE user_name = '" . $username . "'");
                        $_SESSION['error'] = 'Для Вашего Имени исчерпан лимит попыток авторизации.<br />Зайдите завтра.';
                    }
                } else {
                    //если ip отсутствует в БД, добавляем его туда
                    // Выполним SQL запрос
                    try {
                        $dbconn->query("INSERT INTO public.antibrutforce(user_name, col, unban) VALUES('" . $username . "', 1, 0)");
                    } catch (PDOException $e) {
                        print "Error!: " . $e->getMessage() . "<br />";
                    }
                    $_SESSION['error'] .= ' Осталось ' .(PASS_ATTEMPTS - 1). ' попыток.';
                }
  		    }
        // Пользователь не заполнил поля
  	    } else {
  	        $_SESSION['error'] = "Введите логин и пароль!";
  	    }
    // Пользователь осуществляет выход
	} else if ( $_POST['act'] == 'logout' ) {
	    unset ($_SESSION['user_id']);
		unset ($_SESSION['error']);
	}

    //чистим таблицу банов от разбаненых при каждой попытке авторизации...
    $dbconn->query("DELETE FROM public.antibrutforce WHERE unban <= '" . (int)date("d") . "' AND unban > '0'");

    echo "\n<META http-equiv='REFRESH' content='0; url=/index.php'>";