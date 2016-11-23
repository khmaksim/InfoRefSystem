<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    if (isset($_GET['id_departments']))
        $arDepartment = getDepartmentsById($_GET['id_departments']);
    else
        $arDepartment = array();
    $page = 'person';
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
                        Редактирование личного состава подразделения
                        <small><?= ($_GET['act'] == 'add') ? 'Добавление.' : 'Редактирование.'; ?></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/departments.php"><i class="fa fa-dashboard"></i> Главная</a></li>
                        <li>Личный состав</li>
                        <li><a href="/unit.php?id=<?= $arDepartment['id']; ?>"><?= $arDepartment['fullname']; ?></a></li>
                        <li class="active"><?= ($_GET['act'] == 'add') ? 'Добавление' : 'Редактирование'; ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                <?php
                    if ($_GET['act'] == 'edit') {
                        $arPerson = getPersonById($_GET['id']);
                    }
                ?>
                <!-- Your Page Content Here -->
                <?php
                    if ($_GET['act'] == 'edit') {
                ?>
                    <div class="row">
                            <div class="col-xs-12">
                                <p class="text-right">
                                    <a href="/person_view.php?id=<?= $_GET['id']; ?>&id_departments=<?= $_GET['id_departments']; ?>" target="_blank" type="button" class="btn btn-app"><i class="fa fa-print"></i> Печать</a>
                                </p>
                            </div><!-- /.col -->
                        </div>

                <?php
                    }
                ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?= ($_GET['act'] == 'add') ? 'Добавление' : 'Редактирование'; ?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form name="editform" role="form" action="/save.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="act" value="<?= $_GET['act']; ?>Person" />
                                    <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                    <input type="hidden" name="id_departments" value="<?= (isset($_GET['id_departments'])) ? $_GET['id_departments'] : ''; ?>" />
                                    <div class="box-body">
                                        <div class="form-group">
                                            <?= ($_GET['act'] == 'edit' && $arPerson['img_ext'] != '') ? '<img src="/user/' . $arPerson['id'] . '_thumb.' . $arPerson['img_ext'] . '" border="0" alt="" class="img-thumbnail" /><br />' : ''; ?>
                                            <label for="exampleInputFile">Фото</label>
                                            <input type="file" name="face" id="exampleInputFile">
                                            <p class="help-block">Размер файла не более 2 Мб.</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Личный номер</label>
                                            <input type="text" name="personalnumber" class="form-control" id="exampleInputEmail1" placeholder="Личный номер"<?= ($_GET['act'] == 'edit') ? ' value="' . $arPerson['personalnumber'] . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Фамилия</label>
                                            <input type="text" name="lastname" class="form-control" id="exampleInputEmail1" placeholder="Фамилия"<?= ($_GET['act'] == 'edit') ? ' value="' . $arPerson['lastname'] . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Имя</label>
                                            <input type="text" name="firstname" class="form-control" id="exampleInputEmail1" placeholder="Имя"<?= ($_GET['act'] == 'edit') ? ' value="' . $arPerson['firstname'] . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Отчество</label>
                                            <input type="text" name="patronymic" class="form-control" id="exampleInputEmail1" placeholder="Отчество"<?= ($_GET['act'] == 'edit') ? ' value="' . $arPerson['patronymic'] . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Должность</label>
                                            <select class="form-control" name="id_tunit">
                                                <option value="0"<?= ($_GET['act'] == 'edit' && $arPerson['id_tunit'] == $row['id']) ? ' selected="selected"' : ''; ?>>За штатом</option>
                                                <?php
                                                    $sql = "SELECT * FROM public.tunit WHERE id_departments = '" . $_GET['id_departments'] . "' AND vacant = 'true' AND dateorderend = '1970-01-01' ORDER BY id";
                                                    foreach ($dbconn->query($sql) as $row) {
                                                ?>
                                                <option value="<?= $row['id']; ?>"<?= ($_GET['act'] == 'edit' && $arPerson['id_tunit'] == $row['id']) ? ' selected="selected"' : ''; ?>><?= getMilitaryPositionById($row['id_militaryposition'])['name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Звание</label>
                                            <select class="form-control" name="id_militaryrank">
                                                <option value="0">Нет</option>
                                                <?php
                                                    $sql = "SELECT * FROM public.tmilitaryrank ORDER BY name";
                                                    foreach ($dbconn->query($sql) as $row) {
                                                ?>
                                                <option value="<?= $row['id']; ?>"<?= ($_GET['act'] == 'edit' && $arPerson['id_militaryrank'] == $row['id']) ? ' selected="selected"' : ''; ?>><?= getMilitaryRankById($row['id'])['name']; ?></option>
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
                                                <option value="<?= $row['id']; ?>"<?= ($_GET['act'] == 'edit' && $arPerson['id_accesslevel'] == $row['id']) ? ' selected="selected"' : ''; ?>><?= $row['name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Военный</label><br />
                                            <input type="checkbox" name="military" value="1"<?= ($_GET['act'] == 'edit' && $arPerson['military'] != 'true') ? '' : ' checked="checked"'; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Дата рождения</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="birthday" placeholder="Дата рождения (формат 01-01-1979)" class="form-control"<?= ($_GET['act'] == 'edit') ? ' value="' . DateFromENtoRU(mb_substr($arPerson['birthday'], 0, 10), '-') . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Телефон</label>
                                        </div>
                                        <?php
                                            if ($_GET['act'] == 'edit') {
                                                $sql = "SELECT * FROM public.tphone WHERE id_person = '" . $arPerson['id'] . "' ORDER BY id";
                                                foreach ($dbconn->query($sql) as $row) {
                                        ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="person-phone[]" value="<?= $row['name']; ?>" required="required">
                                        </div>
                                        <?php
                                                }
                                            } else {
                                        ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="person-phone[]" value="" required="required">
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        <div class="form-group" style="overflow: hidden;">
                                            <a href="javascript:void(0);" onclick="addPersonPhone($(this));" type="button" class="btn btn-default pull-right btn-flat add-person-phone">Добавить телефон</a>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Email</label>
                                        </div>
                                        <?php
                                            if ($_GET['act'] == 'edit') {
                                                $sql = "SELECT * FROM public.temail WHERE id_person = '" . $arPerson['id'] . "' ORDER BY id";
                                                foreach ($dbconn->query($sql) as $row) {
                                        ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="person-email[]" value="<?= $row['name']; ?>" required="required">
                                        </div>
                                        <?php
                                                }
                                            } else {
                                        ?>
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="person-email[]" value="" required="required">
                                        </div>
                                        <?php
                                            }
                                        ?>
                                        <div class="form-group" style="overflow: hidden;">
                                            <a href="javascript:void(0);" onclick="addPersonEmail($(this));" type="button" class="btn btn-default pull-right btn-flat add-person-email">Добавить email</a>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Город</label>
                                            <select class="form-control" name="id_city">
                                                <option value="0">Не определён</option>
                                                <?php
                                                    $sql = "SELECT * FROM public.tcity ORDER BY id";
                                                    foreach ($dbconn->query($sql) as $row) {
                                                ?>
                                                <option value="<?= $row['id']; ?>"<?= ($_GET['act'] == 'edit' && $arPerson['id_city'] == $row['id']) ? ' selected="selected"' : ''; ?>><?= $row['name']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>Адрес</label>
                                            <textarea name="address" class="form-control" rows="3" placeholder="Адрес..."><?= ($_GET['act'] == 'edit') ? $arPerson['address'] : ''; ?></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>Комментарий</label>
                                            <textarea name="comment" class="form-control" rows="3" placeholder="Текст..."><?= ($_GET['act'] == 'edit') ? $arPerson['comment'] : ''; ?></textarea>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <a href="/person.php?id=<?= $_GET['id_departments']?>" type="submit" class="btn btn-default">Отмена</a> <a onclick="javascript:checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
                $('<div class="form-group"><div class="input-group"><input type="text" class="form-control" name="person-phone[]" value=""><div class="input-group-btn"><button type="button" class="btn btn-danger" onclick="$(this).parent().parent().parent().remove();">Удалить</button></div><!-- /btn-group --></div></div>').fadeIn('slow').insertBefore($(el).parent());
            }

            function addPersonEmail(el) {
                $('<div class="form-group"><div class="input-group"><input type="text" class="form-control" name="person-email[]" value=""><div class="input-group-btn"><button type="button" class="btn btn-danger" onclick="$(this).parent().parent().parent().remove();">Удалить</button></div><!-- /btn-group --></div></div>').fadeIn('slow').insertBefore($(el).parent());
            }
        /*]]>*/
        </script>
    </body>
</html>
