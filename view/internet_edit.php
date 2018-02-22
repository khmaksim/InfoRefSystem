<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php");
    $request = \view\ViewHelper::getRequest();
    $edit_internet = $request->getProperty('internet');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'AddInternet') ? 'Добавление' : 'Редактирование';
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
                        <li><a href="/?cmd=ProtectionInformation">Защита информации от НСД</a></li>
                        <li><a href="/?cmd=Internet">Интернет</a></li>
                        <li class="active"><?php echo $action_name; ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                <?php
                    $alertMessage = 'Укажите наименование КВИТО!';
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
<!--                                     <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>" />
                                    <input type="hidden" name="id_department" value="<?= (isset($_GET['id_department'])) ? $_GET['id_department'] : ''; ?>" /> -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="inputLocation">Местонахождение</label>
                                            <input type="text" name="location" class="form-control" id="inputLocation" placeholder="Местонахождение"<?= ($action == 'EditInternet') ? ' value="' . $edit_internet->location . '"' : ''; ?> required autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPermission">Разрешение об открытии</label>
                                            <input type="text" name="permission" class="form-control" id="inputPermission" placeholder="Разрешение об открытии"<?= ($action == 'EditInternet') ? ' value="' . $edit_internet->permission . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputRegNumber">Регистрационный номер</label>
                                            <input type="text" name="reg_number" class="form-control" id="inputRegNumber" placeholder="Регистрационный номер"<?= ($action == 'EditInternet') ? ' value="' . $edit_internet->reg_number . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputComposition">Состав АРМ/Сервер</label>
                                            <input type="text" name="composition" class="form-control" id="inputComposition" placeholder="Состав АРМ/Сервер"<?= ($action == 'EditInternet') ? ' value="' . $edit_internet->composition . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputOrder">Приказ</label>
                                            <input type="text" name="order" class="form-control" id="inputOrder" placeholder="Приказ"<?= ($action == 'EditInternet') ? ' value="' . 
                                            $edit_internet->order . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputEmail">Адрес электронной почты</label>
                                            <input type="text" name="email" class="form-control" id="inputEmail" placeholder="email@email.mil"<?= ($action == 'EditInternet') ? ' value="' . $edit_internet->email . '"' : ''; ?>>
                                        </div>
                                    </div>
                                    <div class="box-footer">
                                        <a href="/?cmd=Internet" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
