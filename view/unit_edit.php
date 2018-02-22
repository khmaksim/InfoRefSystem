<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php");
    $request = \view\ViewHelper::getRequest();
    $edit_unit = $request->getProperty('unit');
    $department = $request->getProperty('department');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'AddUnit') ? 'Добавление' : 'Редактирование';
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
                        <li>Штатное расписание</li>
                        <li><a href="/?cmd=Unit&id_department=<?= $department->id ?>"><?= $department->fullname ?></a></li>
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
                                            <label for="inputPosition">Должность</label>
                                            <select class="form-control" name="position" id="inputPosition">
                                                <?php
                                                    $position_list = $request->getProperty('position_list');
                                                    foreach ($position_list as $position) {
                                                        if ($action == 'EditUnit' && $edit_unit->id_position == $position->id)
                                                            echo '<option value="' . $position->id . '" selected="selected">' . $position->name . '</option>';
                                                        else
                                                            echo '<option value="' . $position->id . '">' . $position->name . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTariffcategory">Тарифный разряд</label>
                                            <input type="text" name="tariffcategory" class="form-control" id="inputTariffcategory" placeholder="Тарифный разряд"<?= ($action == 'EditUnit') ? ' value="' . $edit_unit->tariff_category . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputMilitaryRank">Воинское звание</label>
                                            <select class="form-control" name="militaryrank" id="inputMilitaryRank">
                                                <?php
                                                    $military_rank_list = $request->getProperty('military_rank_list');
                                                    foreach ($military_rank_list as $military_rank) {
                                                        if ($action == 'EditUnit' && $edit_unit->id_military_rank == $military_rank->id)
                                                            echo '<option value="' . $military_rank->id . '" selected="selected">' . $military_rank->name . '</option>';
                                                        else
                                                            echo '<option value="' . $military_rank->id . '">' . $military_rank->name . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAccessType">Форма допуска</label>
                                            <select class="form-control" name="accesslevel" id="inputAccessType">
                                                 <?php
                                                    $access_type_list = $request->getProperty('access_type_list');
                                                    foreach ($access_type_list as $access_type) {
                                                        if ($action == 'EditUnit' && $edit_unit->id_access_type == $access_type->id)
                                                            echo '<option value="' . $access_type->id . '" selected="selected">' . $access_type->name . '</option>';
                                                        else
                                                            echo '<option value="' . $access_type->id . '">' . $access_type->name . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputOrderNumber">Номер приказа</label>
                                            <input type="text" name="ordernumber" class="form-control" id="inputOrderNumber" placeholder="Номер приказа"<?= ($action == 'EditUnit') ? ' value="' . $edit_unit->order_number . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputOrderOwner">Подписан</label>
                                            <input type="text" name="orderowner" class="form-control" id="inputOrderOwner" placeholder="Кем подписан приказ"<?= ($action == 'EditUnit') ? ' value="' . $edit_unit->order_owner . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDateorderstart">Дата приказа</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="dateorderstart" placeholder="Дата приказа (формат 01-01-1979)" class="form-control"<?= ($action == 'EditUnit') ? ' value="' . $edit_unit->dateorderstart . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputDateorderend">Упразднена</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="dateorderend" placeholder="Дата когда должность упразднена (формат 01-01-1979)" class="form-control"<?= ($action == 'EditUnit') ? ' value="' . $edit_unit->dateorderend . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Вакантна</label><br />
                                            <input type="checkbox" name="vacant" value="1"<?= ($action == 'EditUnit' && $edit_unit->vacant != 'true') ? '' : ' checked="checked"'; ?>>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <a href="/?cmd=Unit&id_department=<?= $department->id ?>" type="submit" class="btn btn-default">Отмена</a> <a onclick="javascript:checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
