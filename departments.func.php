<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getdepartmentsbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getaccessrightbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/showdepartmentstree.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/havechilde.func.php';

    ConnectDatabase();
    global $arAccessRifht;
    $arAccessRight = getAccessRightById($_SESSION['user_id']);
    // Выполним SQL запрос
    try {
        showDepartmentsTree(0);
    }   catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br />";
    }