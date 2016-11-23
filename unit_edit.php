<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    if (isset($_GET['id_departments']))
        $arDepartment = getDepartmentsById($_GET['id_departments']);
    else
        $arDepartment = array();
    $page = 'unit';
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
                        Редактирование штатного расписания подразделения
                        <small><?= ($_GET['act'] == 'add') ? 'Добавление.' : 'Редактирование.'; ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/departments.php"><i class="fa fa-dashboard"></i> Главная</a></li>
                        <li>Штатное расписание</li>
                        <li><a href="/unit.php?id=<?= $arDepartment['id']; ?>"><?= $arDepartment['fullname']; ?></a></li>
                        <li class="active"><?= ($_GET['act'] == 'add') ? 'Добавление' : 'Редактирование'; ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                <?php
                    if ($_GET['act'] == 'edit') {
                        $arUnit = getUnitById($_GET['id']);
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
                                    <input type="hidden" name="act" value="<?= $_GET['act']; ?>Unit" />
                                    <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                    <input type="hidden" name="id_departments" value="<?= (isset($_GET['id_departments'])) ? $_GET['id_departments'] : ''; ?>" />
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputFile">Должность</label>
                                            <select class="form-control" name="id_militaryposition">
                                                <?php
                                                    $sql = "SELECT * FROM public.tmilitaryposition ORDER BY id";
                                                    foreach ($dbconn->query($sql) as $row) {
                                                ?>
                                                <option value="<?= $row['id']; ?>"<?= ($_GET['act'] == 'edit' && $arUnit['id_militaryposition'] == $row['id']) ? ' selected="selected"' : ''; ?>><?= $row['name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Тарифный разряд</label>
                                            <input type="text" name="tariffcategory" class="form-control" id="exampleInputEmail1" placeholder="Тарифный разряд"<?= ($_GET['act'] == 'edit') ? ' value="' . $arUnit['tariffcategory'] . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Воинское звание</label>
                                            <select class="form-control" name="id_militaryrank">
                                                <?php
                                                    $sql = "SELECT * FROM public.tmilitaryrank ORDER BY id";
                                                    foreach ($dbconn->query($sql) as $row) {
                                                ?>
                                                <option value="<?= $row['id']; ?>"<?= ($_GET['act'] == 'edit' && $arUnit['id_militaryrank'] == $row['id']) ? ' selected="selected"' : ''; ?>><?= $row['name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Форма допуска</label>
                                            <select class="form-control" name="id_accesslevel">
                                                <?php
                                                    $sql = "SELECT * FROM public.taccesstype ORDER BY id";
                                                    foreach ($dbconn->query($sql) as $row) {
                                                ?>
                                                <option value="<?= $row['id']; ?>"<?= ($_GET['act'] == 'edit' && $arUnit['id_accesslevel'] == $row['id']) ? ' selected="selected"' : ''; ?>><?= $row['name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Номер приказа</label>
                                            <input type="text" name="ordernumber" class="form-control" id="exampleInputEmail1" placeholder="Номер приказа"<?= ($_GET['act'] == 'edit') ? ' value="' . $arUnit['ordernumber'] . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Подписан</label>
                                            <input type="text" name="orderowner" class="form-control" id="exampleInputEmail1" placeholder="Кем подписан приказ"<?= ($_GET['act'] == 'edit') ? ' value="' . $arUnit['orderowner'] . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Дата приказа</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="dateorderstart" placeholder="Дата приказа (формат 01-01-1979)" class="form-control"<?= ($_GET['act'] == 'edit') ? ' value="' . DateFromENtoRU(mb_substr($arUnit['dateorderstart'], 0, 10), '-') . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Упразднена</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="dateorderend" placeholder="Дата когда должность упразднена (формат 01-01-1979)" class="form-control"<?= ($_GET['act'] == 'edit' && mb_substr($arUnit['dateorderend'], 0, 10) != '1970-01-01') ? ' value="' . DateFromENtoRU(mb_substr($arUnit['dateorderend'], 0, 10), '-') . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Вакантна</label><br />
                                            <input type="checkbox" name="vacant" value="1"<?= ($_GET['act'] == 'edit' && $arUnit['vacant'] != 'true') ? '' : ' checked="checked"'; ?>>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <a href="/unit.php?id=<?= $_GET['id_departments']?>" type="submit" class="btn btn-default">Отмена</a> <a onclick="javascript:checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
                if (document.editform.tariffcategory.value == '') {
                    alert('Укажите тарифный разряд!');
                    document.editform.tariffcategory.focus();
                } else if (document.editform.ordernumber.value == '') {
                    alert('Укажите номер приказа!');
                    document.editform.ordernumber.focus();
                } else if (document.editform.orderowner.value == '') {
                    alert('Укажите кем подписан приказ!');
                    document.editform.orderowner.focus();
                } else if (document.editform.dateorderstart.value == '') {
                    alert('Укажите дату приказа!');
                    document.editform.dateorderstart.focus();
                } else {
                    document.editform.submit();
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
