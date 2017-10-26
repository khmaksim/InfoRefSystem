<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'structure';
    $section = 'Защита информации от НСД';
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
                        <li class="active">Защита информации от НСД</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                 <!-- Your Page Content Here -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Защита информации от НСД</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <div class="col-xs-2">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li class="disabled"><a href="#">Подразделения по ЗИ</a></li>
                                            <li class="disabled"><a href="#">Объекты информатизации</a></li>
                                            <li><a href="./objectkii.php">Объекты КИИ</a></li>
                                            <li class="disabled"><a href="#">Паспорт</a></li>
                                            <li class="disabled"><a href="#">СЭД</a></li>
                                            <li class="disabled"><a href="#">ЗС СПД</a></li>
                                            <li class="disabled"><a href="#">Алушта</a></li>
                                            <li><a href="./view_data.php?name=internet">Интернет</a></li>
                                            <li class="disabled"><a href="#">Дистанционное обучение</a></li>
                                            <li class="disabled"><a href="#">Разбирательства</a></li>
                                            <li class="disabled"><a href="#">Программное обеспечение</a></li>
                                        </ul>
                                    </div>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>
                    <?php
                        include_once $_SERVER['DOCUMENT_ROOT'] . '/documents.inc.php';
                    ?>
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
