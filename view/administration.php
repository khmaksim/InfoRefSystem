<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
?>
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
                                        <li class="active"><a href="#account" data-toggle="tab"><span class="glyphicon glyphicon-user"></span> Учетные записи</a></li>
                                        <li><a href="#access_right" data-toggle="tab"><span class="glyphicon glyphicon-lock"></span> Права доступа</a></li>
                                        <li><a href="#dictionary" data-toggle="tab"><span class="glyphicon glyphicon-book"></span> Словари</a></li>
                                    </ul>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="account">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li><a href="/?cmd=User">Пользователи</a></li>
                                                <li><a href="/group.php">Группы</a></li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane" id="access_right">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li><a href="/role.php">Роли</a></li>
                                                <li><a href="#">Группы</a></li>
                                            </ul>
                                        </div>
                                        <div class="tab-pane" id="dictionary">
                                            <ul class="nav nav-pills nav-stacked">
                                                <li><a href="/dictionary.php?name=militaryrank">Воинские звания</a></li>
                                                <li><a href="/dictionary.php?name=militaryposition">Должности</a></li>
                                                <li><a href="/dictionary.php?name=phonetype">Типы телефонной связи</a></li>
                                                <li><a href="/dictionary.php?name=phonenumbertype">Типы телефонных номеров</a></li>
                                                <li><a href="/dictionary.php?name=medaltype">Типы наград</a></li>
                                                <li><a href="/dictionary.php?name=interpassporttype">Типы заграничных паспортов</a></li>
                                                <li><a href="/dictionary.php?name=accesstype">Формы допуска</a></li>
                                                <li><a href="/dictionary.php?name=city">Города</a></li>
                                                <li><a href="/dictionary.php?name=addresstype">Типы адресов</a></li>
                                                <li><a href="/dictionary.php?name=emailtype">Типы email</a></li>
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
        ?>
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
