<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'departments';
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
                        <li><a href="/structure.php">Cтруктура ЧНП ВКС</a></li>
                        <li><a href="/departments.php">Подразделения</a></li>
                        <li class="active"><?= ($_GET['act'] == 'add') ? 'Добавление' : 'Редактирование'; ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                <?php
                    if ($_GET['act'] == 'edit') {
                        $arDepartments = getDepartmentsById($_GET['id']);
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
                                    <input type="hidden" name="act" value="<?= $_GET['act']; ?>Departments" />
                                    <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Полное наименование</label>
                                            <input type="text" name="fullname" class="form-control" id="exampleInputEmail1" placeholder="Полное наименование"<?= ($_GET['act'] == 'edit') ? ' value="' . $arDepartments['fullname'] . '"' : ''; ?> required autofocus>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Сокращенное наименование</label>
                                            <input type="text" name="shortname" class="form-control" id="exampleInputEmail1" placeholder="Сокращенное наименование"<?= ($_GET['act'] == 'edit') ? ' value="' . $arDepartments['shortname'] . '"' : ''; ?> required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Индекс исходящего документа</label>
                                            <input type="text" name="dep_index" class="form-control" id="exampleInputEmail1" placeholder="Индекс исходящего документа"<?= ($_GET['act'] == 'edit') ? ' value="' . $arDepartments['dep_index'] . '"' : ''; ?> required>
                                        </div>

                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Адрес сервера</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-laptop"></i>
                                                </div>
                                                <input type="text" name="server_addr" class="form-control" id="exampleInputEmail1" data-inputmask="'alias': 'ip'" data-mask=""<?= ($_GET['act'] == 'edit') ? ' value="' . $arDepartments['server_addr'] . '"' : ''; ?> required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label>Примечания</label>
                                            <textarea name="note" class="form-control" rows="3" placeholder="Текст..."><?= ($_GET['act'] == 'edit') ? $arDepartments['note'] : ''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Кому подчиняется</label>
                                            <select class="form-control" name="parent">
                                                <option value="0">Никому</option>
                                                <?php
                                                    $sql = ($_GET['act'] == 'edit') ? "SELECT * FROM public.tdepartments WHERE id != '" . $arDepartments['id'] . "' ORDER BY fullname" : "SELECT * FROM public.tdepartments ORDER BY fullname";
                                                    foreach ($dbconn->query($sql) as $row) {
                                                ?>
                                                <option value="<?= $row['id']; ?>"<?= ($_GET['act'] == 'edit' && $arDepartments['parent'] == $row['id']) ? ' selected="selected"' : ''; ?>><?= $row['fullname']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Активно</label><br />
                                            <input type="checkbox" name="active" value="1"<?= ($_GET['act'] == 'edit' && $arDepartments['active'] != 'true') ? '' : ' checked="checked"'; ?>>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <a href="/departments.php" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
