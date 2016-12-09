<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();
    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';
    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
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
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getphonenumbertypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getcitybyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getaddresstypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getemailtypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getmedaltypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getinterpassporttypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getaccesstypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getdepartmentsbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/showdepartmentsnavtree.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/showphonelisttree.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/havechilde.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getunitbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getactivearray.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getpersonbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getincomingbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/date.func.php';

    // Проверка авторизации
    if ( !AuthUser() )
        header('Location: /login.php');
    ConnectDatabase();
    $arUser = getUserById($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>ИСC СЗГТ</title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="/dist/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="/dist/css/ionicons.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="/plugins/iCheck/square/blue.css">
        <!-- select2 -->
        <link rel="stylesheet" href="/plugins/select2/select2.min.css">
        <!-- datepicker -->
        <link rel="stylesheet" href="/plugins/datepicker/datepicker3.css">
        <link rel="stylesheet" href="/plugins/datatables/dataTables.bootstrap.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="/dist/css/AdminLTE.css">
        <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
              page. However, you can choose any other skin. Make sure you
              apply the skin class to the body tag so the changes take effect.
        -->
        <link rel="stylesheet" href="/dist/css/skins/skin-blue.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>