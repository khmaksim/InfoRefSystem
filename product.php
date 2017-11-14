<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $productInterface = new ProductInterface($dbo);
    $title = 'Индексы изделий';
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
                        <li><a href="/researchwork.php">Научно-исследовательская работа</a></li>
                        <li class="active"><?php echo $title; ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                  <!-- Your Page Content Here -->
                  <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo $title; ?></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="col-xs-12">
                                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <?php
                                           echo $productInterface->display();
                                        ?>
                                    </table>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-xs-12">
                    <p class="text-right"><a href="./product_edit.php?action=add" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>
                    </div><!-- /.col -->
                </div>
            </section><!-- /.content -->
        </div><!-- /.content-wrapper -->
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
        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            function ConfirmDelete(id)
            {
                var ObjectId = id;
                if(confirm("Вы действительно хотите удалить запись?")) {
                    document.location = "./assets/inc/delete.inc.php?object=ProductInterface&id=" + ObjectId;
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
