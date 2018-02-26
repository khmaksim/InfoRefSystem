<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php");
    $request = \view\ViewHelper::getRequest();
    $edit_person = $request->getProperty('person');
    $department = $request->getProperty('department');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'Add{Person}') ? 'Добавление' : 'Редактирование';
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
                        <li><a href="/?cmd=Person&id_department=<?= $department->id; ?>">Личный состав - <?= $department->fullname; ?></a></li>
                        <li class="active"><?php echo $action_name; ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                <!-- Your Page Content Here -->
                    <div class="row">
                            <div class="col-xs-12">
                                <p class="text-right">
                                    <a href="/person_view.php?id=<?= $edit_person->id; ?>&id_departments=<?= $department->id; ?>" target="_blank" type="button" class="btn btn-app"><i class="fa fa-print"></i> Печать</a>
                                </p>
                            </div><!-- /.col -->
                        </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo $action_name; ?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form name="editform" role="form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                    <input type="hidden" name="id_departments" value="<?= (isset($_GET['id_departments'])) ? $_GET['id_departments'] : ''; ?>" />
                                    <div class="box-body">
                                        <div class="form-group">
                                            <?= ($action == 'EditPerson' && $edit_person->img_ext != '') ? '<img src="./upload/user/' . $edit_person->id . '_thumb.' . $edit_person->img_ext . '" border="0" alt="" class="img-thumbnail" /><br />' : ''; ?>
                                            <label for="exampleInputFile">Фото</label>
                                            <input type="file" name="face" id="exampleInputFile">
                                            <p class="help-block">Размер файла не более 2 Мб.</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPersonalnumber">Личный номер</label>
                                            <input type="text" name="personalnumber" class="form-control" id="inputPersonalnumber" placeholder="Личный номер"<?= ($action == 'EditPerson') ? ' value="' . $edit_person->personalnumber . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputLastname">Фамилия</label>
                                            <input type="text" name="lastname" class="form-control" id="inputLastname" placeholder="Фамилия"<?= ($action == 'EditPerson') ? ' value="' . $edit_person->lastname . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputFirstname">Имя</label>
                                            <input type="text" name="firstname" class="form-control" id="inputFirstname" placeholder="Имя"<?= ($action == 'EditPerson') ? ' value="' . $edit_person->firstname . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPatronymic">Отчество</label>
                                            <input type="text" name="patronymic" class="form-control" id="inputPatronymic" placeholder="Отчество"<?= ($action == 'EditPerson') ? ' value="' . $edit_person->patronymic . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputUnit">Должность</label>
                                            <select class="form-control" name="id_tunit">
                                                <option value="0"<?= ($action == 'EditPerson' && $edit_person->id_unit == '') ? ' selected="selected"' : ''; ?>>За штатом</option>
                                                <?php
                                                    $unit_list = $request->getProperty('unit_list');
                                                    foreach ($unit_list as $unit) {
                                                        if ($action == 'EditPerson' && $edit_person->id_unit == $unit->id)
                                                            echo '<option value="' . $unit->id . '" selected="selected">' . $unit->position . '</option>';
                                                        else
                                                            echo '<option value="' . $unit->id . '">' . $unit->position . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputMilitaryRank">Звание</label>
                                            <select class="form-control" name="id_militaryrank">
                                                <option value="0">Нет</option>
                                                <?php
                                                    $military_rank_list = $request->getProperty('military_rank_list');
                                                    foreach ($military_rank_list as $military_rank) {
                                                        if ($action == 'EditPerson' && $edit_person->id_military_rank == $military_rank->id)
                                                            echo '<option value="' . $military_rank->id . '" selected="selected">' . $military_rank->name . '</option>';
                                                        else
                                                            echo '<option value="' . $military_rank->id . '">' . $military_rank->name . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputAccessType">Форма допуска</label>
                                            <select class="form-control" name="id_accesstype">
                                                <?php
                                                    $access_type_list = $request->getProperty('access_type_list');
                                                    foreach ($access_type_list as $access_type) {
                                                        if ($action == 'EditPerson' && $edit_person->id_access_type == $access_type->id)
                                                            echo '<option value="' . $access_type->id . '" selected="selected">' . $access_type->name . '</option>';
                                                        else
                                                            echo '<option value="' . $access_type->id . '">' . $access_type->name . '</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputMilitary">Военный</label><br />
                                            <input type="checkbox" name="military" value="1"<?= ($action == 'EditPerson' && $edit_person->military != 'true') ? '' : ' checked="checked"'; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputBirthday">Дата рождения</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="birthday" placeholder="Дата рождения (формат 01-01-1979)" class="form-control"<?= ($action == 'EditPerson')? ' value="' . DateFromENtoRU(mb_substr($edit_person->birthday, 0, 10), '-') . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputTelephone">Телефон</label>
                                        </div>
                                        <?php
                                            if ($action == 'EditPerson') {
                                                $collection = $edit_person->phone_number_collection;
                                                $phone_number_list = $collection->getGenerator();
                                                foreach ($phone_number_list as $phone_number)
                                                    echo '<div class="form-inline">
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="person-phone[]" value="'. $phone_number->number .'" required="required">
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="person-phone[]" value="'. $phone_number->number .'" required="required">
                                                            </div>
                                                        </div>';
                                            }
                                            else {
                                                echo '<div class="form-group">
                                                        <div class="form-inline">
                                                             <div class="form-group">
                                                                <select class="form-control" name="id_accesstype">
                                                                    <option selected="selected">access_type->name</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="text" class="form-control" name="person-phone[]" value="" required="required">
                                                            </div>
                                                        </div>
                                                    </div>';
                                            }
                                        ?>
                                        <div class="form-group" style="overflow: hidden;">
                                            <a href="javascript:void(0);" onclick="addPersonPhone($(this));" type="button" class="btn btn-default pull-right btn-flat add-person-phone">Добавить телефон</a>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Город</label>
                                            <select class="form-control" name="id_city">
                                                <option value="0">Не определён</option>
                                                <?php
                                                    $city_list = $request->getProperty('city_list');
                                                    foreach ($city_list as $city) {
                                                        if ($action == 'EditPerson' && $edit_person->id_city == $city->id)
                                                            echo '<option value="'. $city->id .'" selected="selected">'. $city->name .'</option>';
                                                        else 
                                                            echo '<option value="'. $city->id .'>'. $city->name .'</option>';
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Адрес</label>
                                            <textarea name="address" class="form-control" rows="3"><?= ($action == 'EditPerson') ? ' value="' . $edit_person->address . '"' : ''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Комментарий</label>
                                            <textarea name="note" class="form-control" rows="3"><?= ($action == 'EditPerson') ? ' value="' . $edit_person->note . '"' : ''; ?></textarea>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                        <a href="/?cmd=Person&id_department=<?= $department->id; ?>" type="submit" class="btn btn-default">Отмена</a> <a onclick="javascript:checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
                if (document.editform.personalnumber.value == '') {
                    alert('Укажите личный номер!');
                    document.editform.personalnumber.focus();
                } else if (document.editform.lastname.value == '') {
                    alert('Укажите фамилию!');
                    document.editform.lastname.focus();
                } else if (document.editform.firstname.value == '') {
                    alert('Укажите имя!');
                    document.editform.firstname.focus();
                } else if (document.editform.patronymic.value == '') {
                    alert('Укажите отчество!');
                    document.editform.patronymic.focus();
                } else {
                    document.editform.submit();
                }
            }

            function addPersonPhone(el) {
                $clone = $(el).parent().prev().clone();
                if ($clone.children().first().children().last().children().last().attr('type') != 'button') {
                    $clone.children().first().children().last().append('<button type="button" class="btn btn-danger" onclick="$(this).parent().parent().parent().remove();">Удалить</button>');
                }
                $clone.fadeIn('slow').insertBefore($(el).parent());
                // fadeIn('slow').insertBefore($(el).parent());
                // $('<div class="form-inline"><div class="form-group"><select class="form-control" name="id_accesstype"><option selected="selected">access_type->name</option></select></div><div class="form-group"><input type="text" class="form-control" name="person-phone[]" value="" required="required"></div><button type="button" class="btn btn-danger" onclick="$(this).parent().parent().parent().remove();">Удалить</button></div>').fadeIn('slow').insertBefore($(el).parent());
            }

            function addPersonEmail(el) {
                $('<div class="form-group"><div class="input-group"><input type="text" class="form-control" name="person-email[]" value=""><div class="input-group-btn"><button type="button" class="btn btn-danger" onclick="$(this).parent().parent().parent().remove();">Удалить</button></div><!-- /btn-group --></div></div>').fadeIn('slow').insertBefore($(el).parent());
            }
        /*]]>*/
        </script>
    </body>
</html>
