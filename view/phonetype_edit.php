<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php");
    $request = \view\ViewHelper::getRequest();
    $edit_phone_type = $request->getProperty('phone_type');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'AddPhoneType') ? 'Добавление' : 'Редактирование';
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
                        <li><a href="/?cmd=Administration">Администрирование</a></li>
                        <li><a href="/?cmd=PhoneType">Типы телефонной связи</a></li>
                        <li class="active"><?php echo $action_name; ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                <?php
                    $alerMessage = 'Укажите наименование типа телефонной связи!';
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
                                    <!-- <input type="hidden" name="act" value="<?= $_GET['act']; ?>Phonetype" />
                                    <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" /> -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="inputName">Наименование</label>
                                            <input type="text" name="name" class="form-control" id="inputName" placeholder="Наименование типа телефонной связи"<?= ($action == 'EditPhoneType') ? ' value="' . $edit_phone_type->name . '"' : ''; ?> required autofocus>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                        <a href="/?cmd=PhoneType" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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