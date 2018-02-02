<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php") ;
    $request = \view\ViewHelper::getRequest();
?>
    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="./">ИСС СЗГТ</a>
            </div>
            <div class="login-box-body">
                <p class="login-box-msg">Для работы с Информационной системой Вам необходимо указать свои Имя и Пароль</p>
                <form action="/?cmd=Login" method="POST">
                    <!-- <input type="hidden" name="act" value="login" /> -->
                    <div class="form-group has-feedback">
                        <input type="text" class="form-control" placeholder="Имя" name="name" required autofocus>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <input type="password" class="form-control" placeholder="Пароль" name="passwd" required>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-8"></div>
                        <div class="col-xs-4">
                            <button type="submit" class="btn btn-primary btn-block btn-flat">Войти</button>
                        </div>
                        <p class="text-center">
                            <?php echo $request->getProperty('error'); ?>
                        </p>
                    </div>
                </form>
            </div><!-- /.login-box-body -->
        </div><!-- /.login-box -->
        <script src="/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <script src="/bootstrap/js/bootstrap.min.js"></script>
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
