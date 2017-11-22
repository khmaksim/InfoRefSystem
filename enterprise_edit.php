<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $enterpriseInterface = new EnterpriseInterface($dbo);
    $page = 'enterprise';
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
                    <li><a href="/enterprise.php">Предприятия</a></li>
                    <li class="active"><?= ($_GET['action'] == 'add') ? 'Добавление' : 'Редактирование'; ?></li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php
                $alertMessage = 'Укажите название предприятия!';
                ?>
                <!-- Your Page Content Here -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?= ($_GET['action'] == 'add') ? 'Добавление' : 'Редактирование'; ?></h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <form name="editform" role="form" action="/assets/inc/process.inc.php" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="action" value="edit" />
                                <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>" />
                                <input type="hidden" name="object" value="EnterpriseInterface" />
                                <div class="box-body">
                                    <?php
                                        $id = NULL;
                                        if ($_GET['action'] == 'edit')
                                            $id = $_GET['id'];
                                        echo $enterpriseInterface->displayById($id);
                                    ?>
                                </div>
                                <div class="box-footer">
                                    <a href="/enterprise.php" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.col -->
                </div>
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
             <script language="JavaScript" type="text/javascript">
                /*<![CDATA[*/
                function checkForm()
                {
                    if (document.editform.name.value != '') {
                        document.editform.submit();
                    } else {
                        alert('<?= $alertMessage ?>');
                    }
                }
                /*]]>*/
            </script>
        </body>
</html>
