<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/showdocument.func.php';

    ConnectDatabase();
    
    // Выполним SQL запрос
    try {
        showDocument();
    }   catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br />";
    }