<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();
    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';
    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    // Проверка авторизации
    if ( !AuthUser() )
        header('Location: /login.php');

    ConnectDatabase();

    if (isset($_GET['info_id']) && intval($_GET['info_id']) != 0) {
        $dbconn->query("DELETE FROM public.infoblock WHERE user_id = '" . $_SESSION['user_id'] . "' AND info_id = '" . intval($_GET['info_id']) . "'");
        echo "\n<META http-equiv='REFRESH' content='0; url=/'>";
    }