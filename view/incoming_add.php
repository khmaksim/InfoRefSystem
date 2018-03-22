<?php
    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getusernumloginbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getuserprevloginbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getuserrolebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getroletitlebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getusertitlebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getuserbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getrolebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getinfobyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getinfoblockbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getmilitaryrankbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getmilitarypositionbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getphonetypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getmedaltypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getinterpassporttypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getaccesstypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getdepartmentsbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/showdepartmentsnavtree.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/havechilde.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getunitbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getactivearray.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getpersonbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getincomingbyid.func.php';

    // Проверка авторизации
    if ( !AuthUser() )
        header('Location: /login.php');
    ConnectDatabase();

    $sql = "INSERT INTO public.incomings ( number_in, date_in ) VALUES ( 'temp', NOW() ) RETURNING code";
    $res = $dbconn->query($sql);
    $res = $res->fetch();

    $id = $res['code'];
    $sql = "UPDATE public.incomings SET number_in = 'Н-" . $id . "' WHERE code = " . $id;
    $res = $dbconn->query($sql);

    header('Location: /incoming_edit.php?act=edit&id=' . $id);


