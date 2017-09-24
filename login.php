<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    echo session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    
    ConnectDatabase();
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ИС СЗГТ | Авторизация</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/dist/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/dist/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/dist/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="/plugins/iCheck/square/blue.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="/js/html5shiv.min.js"></script>
        <script src="/js/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class="hold-transition login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="/departments.php">ИСС СЗГТ</a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <p class="login-box-msg">Для работы с Информационной системой Вам необходимо указать свои Имя и Пароль</p>
        <form action="/lib/login.php" method="POST">
          <input type="hidden" name="act" value="login" />
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="Имя" name="name" required autofocus>
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Пароль" name="passwd" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8"></div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat">Войти</button>
            </div><!-- /.col -->
            <p class="text-center">
                <?php 
                    if (isset($_SESSION['error'])) {
                        $_SESSION['error']; 
                    }
                ?>
            </p>
          </div>
        </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->

    <!-- jQuery 2.1.4 -->
    <script src="/plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.5 -->
    <script src="/bootstrap/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="/plugins/iCheck/icheck.min.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>
