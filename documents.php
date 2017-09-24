<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'structure';
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
                        <li class="active">Руководящие документы</li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

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
