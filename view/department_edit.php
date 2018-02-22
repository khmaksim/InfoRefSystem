<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php");
    $request = \view\ViewHelper::getRequest();
    $edit_department = $request->getProperty('department');
    $department_list = $request->getProperty('department_list');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'AddDepartment') ? 'Добавление' : 'Редактирование';
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
                        <li><a href="/?cmd=Structure">Cтруктура ЧНП ВКС</a></li>
                        <li><a href="/?cmd=Department">Подразделения</a></li>
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
                                            <label for="inputFullname">Полное наименование</label>
                                            <input type="text" name="fullname" class="form-control" id="inputFullname" placeholder="Полное наименование"<?= ($action == 'EditDepartment') ? ' value="' . $edit_department->fullname . '"' : ''; ?> required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputShortname">Сокращенное наименование</label>
                                            <input type="text" name="shortname" class="form-control" id="inputShortname" placeholder="Сокращенное наименование"<?= ($action == 'EditDepartment') ? ' value="' . $edit_department->shortname . '"' : ''; ?> required>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputDepIndex">Индекс исходящего документа</label>
                                            <input type="text" name="dep_index" class="form-control" id="inputDepIndex" placeholder="Индекс исходящего документа"<?= ($action == 'EditDepartment') ? ' value="' . $edit_department->dep_index . '"' : ''; ?> required>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputServerAddr">Адрес сервера</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-laptop"></i>
                                                </div>
                                                <input type="text" name="server_addr" class="form-control" id="inputServerAddr" data-inputmask="'alias': 'ip'" data-mask=""<?= ($action == 'EditDepartment') ? ' value="' . $edit_department->server_addr . '"' : ''; ?> required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="inputNote">Примечания</label>
                                            <textarea name="note" class="form-control" id="inputNote" rows="3" placeholder=""><?= ($action == 'EditDepartment') ? $edit_department->note : ''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputParentDepatrment">Кому подчиняется</label>
                                            <select class="form-control" name="parent" id="inputParentDepatrment">
                                                <option value="0">Никому</option>
                                                <?php
                                                    foreach ($department_list as $item) {
                                                        if ($edit_department->id == $item->id)
                                                            continue;
                                                        if ($action == 'EditDepartment' && $edit_department->parent == $item->id)
                                                            echo '<option value="' . $item->id . '" selected="selected">' . $item->fullname . '</option>';
                                                        else
                                                            echo '<option value="' . $item->id . '">' . $item->fullname . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputActive">Активно</label><br />
                                            <input type="checkbox" name="active" id="inputActive" value="1"<?= ($action == 'EditDepartment' && $edit_department->active != 'true') ? '' : ' checked="checked"'; ?>>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                        <a href="/?cmd=Department" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
        <!-- InputMask -->
        <script src="/plugins/input-mask/jquery.inputmask.js"></script>
        <script src="/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
        <script src="/plugins/input-mask/jquery.inputmask.extensions.js"></script>
        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            $(document).ready(function(){
      		    $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });

                $('select').select2();
                //Money Euro
                $("[data-mask]").inputmask();
            });
            function checkForm()
            {
                if (document.editform.fullname.value != '') {
                    document.editform.submit();
                } else {
                    alert('Укажите наименование подразделения!');
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
