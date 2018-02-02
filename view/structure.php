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
                        <li class="active">Cтруктура ЧНП ВКС</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <!-- <form action="/phone_list.php" method="POST" name="View" target="_blank"> -->

                <!-- Your Page Content Here -->
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="text-right">
                                    <a href="/departments.php" type="button" class="btn btn-app"><i class="glyphicon glyphicon-edit"></i> Редактировать</a>
                                    <a href="javascript:void(0);" onclick="document.View.submit();" type="button" class="btn btn-app"><i class="fa fa-print"></i> Печать</a>
                                    <!--<a href="javascript:void(0);" onclick="document.View.submit();" type="button" class="btn btn-app"><i class="fa fa-print"></i> Справочник</a>-->
                                </p>
                            </div><!-- /.col -->
                        </div>

                        <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Cтруктура ЧНП ВКС</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <!-- sidebar: style can be found in sidebar.less -->
                                    <section class="sidebar">
                                       <!-- Sidebar Menu -->
                                      <ul class="sidebar-menu">
                                        <li class="header">Оргштатная структура</li>
                                        <!-- Optionally, you can add icons to the links -->
                                        <?php
                                            showDepartmentsNavTree();
                                        ?>
                                      </ul><!-- /.sidebar-menu -->
                                    </section>
                                    <!-- /.sidebar -->
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
