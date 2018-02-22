<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php");
    $request = \view\ViewHelper::getRequest();
    $edit_technique = $request->getProperty('technique');
    $department = $request->getProperty('department');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'AddTechnique') ? 'Добавление' : 'Редактирование';
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
                        <li><a href="/?cmd=Structure">Cтруктура ЧНП ВКС</a></li>
                        <li><a href="/?cmd=Technique&id_department=<?= $department->id; ?>">Техника - <?= $department->fullname; ?></a></li>
                        <li class="active"><?php echo $action_name; ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                <!-- Your Page Content Here -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo $action_name; ?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form name="editform" role="form" method="post" enctype="multipart/form-data">
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="inputFullname">Полное наименование техники</label>
                                            <input type="text" name="fullname" class="form-control" id="inputFullname" placeholder="Полное наименование"<?= ($action == 'EditTechnique') ? ' value="' . $edit_technique->fullname . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputShortname">Сокращенное наименование техники</label>
                                            <input type="text" name="shortname" class="form-control" id="inputShortname" placeholder="Сокращенное наименование"<?= ($action == 'EditTechnique') ? ' value="' . $edit_technique->shortname . '"' : ''; ?> required>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                        <a href="/?cmd=Technique&id_department=<?= $department->id ?>" type="submit" class="btn btn-default">Отмена</a> <a onclick="javascript:checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
        <!-- iCheck -->
        <script src="/plugins/iCheck/icheck.min.js"></script>
        <!-- select2 -->
        <script src="/plugins/select2/select2.full.min.js"></script>
        <!-- datepicker -->
        <script src="/plugins/datepicker/bootstrap-datepicker.js"></script>
        <script src="/plugins/datepicker/locales/bootstrap-datepicker.ru.js" charset="UTF-8"></script>
        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            $(document).ready(function(){
      		    $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });

                $('select').select2();

                $('.input-group.date').datepicker({
                    format: "dd-mm-yyyy",
                    todayBtn: "linked",
                    language: "ru",
                    autoclose: true,
                    todayHighlight: true
                });
            });

            function checkForm()
            {
                if (document.editform.fullname.value == '') {
                    alert('Укажите полное наименование техники!');
                    document.editform.fullname.focus();
                } else if (document.editform.shortname.value == '') {
                    alert('Укажите сокращенное наименование техники!');
                    document.editform.shortname.focus();
                } else {
                    document.editform.submit();
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
