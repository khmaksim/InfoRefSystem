<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php");
    $request = \view\ViewHelper::getRequest();
    $edit_enterprise = $request->getProperty('enterprise');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'AddEnterprise') ? 'Добавление' : 'Редактирование';
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
                    <li class="active"><?php echo $action_name; ?></li>
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
                                <h3 class="box-title"><?php echo $action_name; ?></h3>
                            </div><!-- /.box-header -->
                            <!-- form start -->
                            <form name="editform" role="form" method="post" enctype="multipart/form-data">
                                <!-- <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>" /> -->
                                <div class="box-body">
                                    <div class="form-group">
                                        <label for="inputName">Наименование</label>
                                        <input type="text" name="name" class="form-control" id="inputName" placeholder="Наименование"<?= ($action == 'EditEnterprise') ? ' value="' . $edit_enterprise->name . '"' : ''; ?> required autofocus>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputLocation">Место дислокации</label>
                                        <input type="text" name="location" class="form-control" id="inputLocation" placeholder="Место дислокации"<?= ($action == 'EditEnterprise') ? ' value="' . $edit_enterprise->location . '"' : ''; ?>>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="inputHead">Руководитель</label>
                                                <input type="text" name="head" class="form-control" id="inputHead" placeholder="Руководитель"<?= ($action == 'EditEnterprise') ? ' value="' . $edit_enterprise->head . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="inputPost">Должность</label>
                                                <input type="text" name="post" class="form-control" id="inputPost" placeholder="Должность"<?= ($action == 'EditEnterprise') ? ' value="' . $edit_enterprise->post . '"' : ''; ?>>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <a href="/?cmd=Enterprise" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
