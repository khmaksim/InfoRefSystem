<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'phonelist';
?>
  <!--
  BODY TAG OPTIONS:
  =================
  Apply one or more of the following classes to get the
  desired effect
  |---------------------------------------------------------|
  | SKINS         | skin-blue                               |
  |               | skin-black                              |
  |               | skin-purple                             |
  |               | skin-yellow                             |
  |               | skin-red                                |
  |               | skin-green                              |
  |---------------------------------------------------------|
  |LAYOUT OPTIONS | fixed                                   |
  |               | layout-boxed                            |
  |               | layout-top-nav                          |
  |               | sidebar-collapse                        |
  |               | sidebar-mini                            |
  |---------------------------------------------------------|
  -->
    <body class="hold-transition skin-blue sidebar-mini fixed">
        <div class="wrapper">
        <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/mainheader.inc.php';
        ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="./"><i class="glyphicon glyphicon-home"></i> Главная</a></li>
                        <li class="active">Администрирование</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <form action="/phone_list.php" method="POST" name="View" target="_blank">

                <!-- Your Page Content Here -->
                        <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Администрирование</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <!-- Nav tabs -->
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a href="#admin" data-toggle="tab"><i class="glyphicon glyphicon-user"></i> Учетная информация</a></li>
                                        <li><a href="#dictionary" data-toggle="tab"><i class="fa fa-book"></i> Словари</a></li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="admin">
                                            <?php
                                                // получение прав доступа на ПМ пользователя
                                                $arAccessRight = getAccessRightById($_SESSION['user_id']);
                                            ?>
                                            <ul class="nav nav-pills nav-stacked">
                                                <?php
                                                    if ($arAccessRight['admin'] > 0) {
                                                ?>
                                                <li>
                                                    <a href="/user.php">Пользователи</a>
                                                </li>
                                                <?php
                                                    }
                                                ?>
                                                <?php
                                                    if ($arAccessRight['omu'] > 0) {
                                                ?>
                                                <li>
                                                    <a href="/departments.php">Подразделения</a>
                                                </li>
                                                <?php
                                                    }
                                                ?>
                                                <?php
                                                    if ($arAccessRight['incoming'] > 0) {
                                                ?>
                                                <li>
                                                    <a href="/incoming.php">Учет входящих несекретных документов</a>
                                                </li>
                                                <?php
                                                    }
                                                ?>
                                                <?php
                                                    if ($arAccessRight['telephone'] > 0) {
                                                ?>
                                                <li>
                                                    <a href="/phonelist.php">Телефонный справочник подразделений</a>
                                                </li>
                                                <li>
                                                    <a href="/phonelistperson.php">Телефонный справочник людей</a>
                                                </li>
                                                 <?php
                                                    }
                                                ?>
                                            </ul><!-- /.control-sidebar-menu -->
                                        </div>
                                        <div class="tab-pane" id="dictionary">
                                            <ul class="nav nav-pills nav-stacked">
                                                <?php
                                                    if ($arAccessRight['admin'] > 0) {
                                                ?>
                                                <li>
                                                    <a href="/dictionary.php?name=role">Роли безопасности</a>
                                                </li>
                                                <li>
                                                    <a href="/dictionary.php?name=militaryrank">Воинские звания</a>
                                                </li>
                                                <li>
                                                    <a href="/dictionary.php?name=militaryposition">Должности</a>
                                                </li>
                                                <li>
                                                    <a href="/dictionary.php?name=phonetype">Типы телефонной связи</a>
                                                </li>
                                                <li>
                                                    <a href="/dictionary.php?name=phonenumbertype">Типы телефонных номеров</a>
                                                </li>

                                                <li>
                                                    <a href="/dictionary.php?name=medaltype">Типы наград</a>
                                                </li>
                                                <li>
                                                    <a href="/dictionary.php?name=interpassporttype">Типы заграничных паспортов</a>
                                                </li>
                                                <li>
                                                    <a href="/dictionary.php?name=accesstype">Формы допуска</a>
                                                </li>
                                                <li>
                                                    <a href="/dictionary.php?name=city">Города</a>
                                                </li>

                                                <li>
                                                    <a href="/dictionary.php?name=addresstype">Типы адресов</a>
                                                </li>

                                                <li>
                                                    <a href="/dictionary.php?name=emailtype">Типы email</a>
                                                </li>
                                                 <?php
                                                    }
                                                ?>
                                            </ul><!-- /.control-sidebar-menu -->
                                        </div>
                                    </div>
                                 </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>
                    </form>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
        <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/mainfooter.inc.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/controlsidebar.inc.php';
        ?>
            <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
            <div class="control-sidebar-bg"></div>
        </div><!-- ./wrapper -->

        <!-- REQUIRED JS SCRIPTS -->

        <!-- jQuery 2.1.4 -->
        <script src="/plugins/jQuery/jQuery-2.1.4.min.js"></script>
        <!-- Bootstrap 3.3.5 -->
        <script src="/bootstrap/js/bootstrap.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/dist/js/app.min.js"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. Slimscroll is required when using the
             fixed layout. -->
        <!-- iCheck -->
        <script src="/plugins/iCheck/icheck.min.js"></script>

        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            $(document).ready(function(){
                $("#items").load("/phonelist.func.php", function( response, status, xhr ) {
                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_square-blue',
                        increaseArea: '20%' // optional
                    });
                });
                // setInterval(function() {$("#items").load("/phonelist.func.php");}, 5000);
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });

            });
        /*]]>*/
        </script>
    </body>
</html>
