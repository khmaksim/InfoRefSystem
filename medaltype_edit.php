<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'medaltype';
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
    <body class="hold-transition skin-blue sidebar-mini">
        <div class="wrapper">


        <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/mainheader.inc.php';
            include_once $_SERVER['DOCUMENT_ROOT'] . '/leftcolumn.inc.php';
        ?>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        Типы наград
                        <small><?= ($_GET['act'] == 'add') ? 'Добавление.' : 'Редактирование.'; ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/departments.php"><i class="fa fa-dashboard"></i> Главная</a></li>
                        <li><a href="/medaltype.php">Типы наград</a></li>
                        <li class="active"><?= ($_GET['act'] == 'add') ? 'Добавление' : 'Редактирование'; ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                <?php
                    if ($_GET['act'] == 'edit') {
                        $arMedalType = getMedalTypeById($_GET['id']);
                    }
                ?>
                <!-- Your Page Content Here -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?= ($_GET['act'] == 'add') ? 'Добавление' : 'Редактирование'; ?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form name="editform" role="form" action="/save.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="act" value="<?= $_GET['act']; ?>Medaltype" />
                                    <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Наименование</label>
                                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Наименование типа награды"<?= ($_GET['act'] == 'edit') ? ' value="' . $arMedalType['name'] . '"' : ''; ?> required autofocus>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <a href="/medaltype.php" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
                                    </div>
                                </form>
                            </div>
                        </div><!-- /.col -->
                    </div>
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
        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            function checkForm()
            {
                if (document.editform.name.value != '') {
                    document.editform.submit();
                } else {
                    alert('Укажите наименование типа награды!');
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
