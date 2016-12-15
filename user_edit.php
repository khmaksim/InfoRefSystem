<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'user';
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
    <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
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
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/departments.php"><i class="fa fa-dashboard"></i> Главная</a></li>
                        <li><a href="/user.php">Пользователи</a></li>
                        <li class="active"><?= ($_GET['act'] == 'add') ? 'Добавление' : 'Редактирование'; ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                <?php
                    if ($_GET['act'] == 'edit') {
                        $arUser = getUserById($_GET['id']);
                        $arAccessRight = getAccessRightById($_GET['id']);
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
                                <form name="role" role="form" action="/save.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="act" value="<?= $_GET['act']; ?>User" />
                                    <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">ФИО</label>
                                            <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="Фамилия Имя Отчество пользователя"<?= ($_GET['act'] == 'edit') ? ' value="' . $arUser['title'] . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Имя</label>
                                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Имя для входа в систему"<?= ($_GET['act'] == 'edit') ? ' value="' . $arUser['name'] . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Пароль</label>
                                            <input type="password" name="passwd" class="form-control" id="exampleInputPassword1" placeholder="Указать при создании пользователя или если необходимо поменять при редактировании">
                                        </div>
                                        <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                            <thead>
                                                <tr>
                                                    <th>Наименование программного модуля</th>
                                                    <th>Просмотр</th>
                                                    <th>Редактирование</th>
                                                    <th>Удаление</th>
                                                </tr>
                                            </thead>
                                        <tbody>
                                            <tr>
                                                <td>Администрирование</td>
                                                <td class="text-center"><input type="checkbox" name="adminView" value="1"<?= ($_GET['act'] == 'edit' && $arAccessRight['admin'] < 4) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="adminEdit" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['admin'], array(2, 3, 6, 7))) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="adminRemove" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['admin'], array(1, 3, 5, 7))) ? '' : ' checked="checked"'; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>Организационно-мобилизационное управление</td>
                                                <td class="text-center"><input type="checkbox" name="omuView" value="1"<?= ($_GET['act'] == 'edit' && $arAccessRight['omu'] < 4) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="omuEdit" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['omu'], array(2, 3, 6, 7))) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="omuRemove" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['omu'], array(1, 3, 5, 7))) ? '' : ' checked="checked"'; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>Кадры</td>
                                                <td class="text-center"><input type="checkbox" name="kadrView" value="1"<?= ($_GET['act'] == 'edit' && $arAccessRight['kadr'] < 4) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="kadrEdit" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['kadr'], array(2, 3, 6, 7))) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="kadrRemove" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['kadr'], array(1, 3, 5, 7))) ? '' : ' checked="checked"'; ?>></td>
                                            </tr>
                                            <tr>
                                                <td>Телефонный справочник</td>
                                                <td class="text-center"><input type="checkbox" name="telephoneView" value="1"<?= ($_GET['act'] == 'edit' && $arAccessRight['telephone'] < 4) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="telephoneEdit" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['telephone'], array(2, 3, 6, 7))) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="telephoneRemove" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['telephone'], array(1, 3, 5, 7))) ? '' : ' checked="checked"'; ?>></td>
                                            </tr>
                                            <tr>
                                                <td><s>ЗГТ</s></td>
                                                <td class="text-center"><input type="checkbox" name="zgtView" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="zgtEdit" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="zgtRemove" value="1" disabled></td>
                                            </tr>
                                            <tr>
                                                <td>Входящие документы</td>
                                                <td class="text-center"><input type="checkbox" name="incomingView" value="1"<?= ($_GET['act'] == 'edit' && $arAccessRight['incoming'] < 4) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="incomingEdit" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['incoming'], array(2, 3, 6, 7))) ? '' : ' checked="checked"'; ?>></td>
                                                <td class="text-center"><input type="checkbox" name="incomingRemove" value="1"<?= ($_GET['act'] == 'edit' && !in_array($arAccessRight['incoming'], array(1, 3, 5, 7))) ? '' : ' checked="checked"'; ?>></td>
                                            </tr>
                                            <tr>
                                                <td><s>Контроль исполнения документов</s></td>
                                                <td class="text-center"><input type="checkbox" name="controlView" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="controlEdit" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="controlRemove" value="1" disabled></td>
                                            </tr>
                                            <tr>
                                                <td><s>Исходящие документы</s></td>
                                                <td class="text-center"><input type="checkbox" name="outgoingView" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="outgoingEdit" value="1" disabled></td>
                                                <td class="text-center"><input type="checkbox" name="outgoingRemove" value="1" disabled></td>
                                            </tr>
                                        </tbody>
                                        </table>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Активен до</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="adate" placeholder="Дата до которой пользователь активен (формат 01-01-1979)" class="form-control"<?= ($_GET['act'] == 'edit') ? ' value="' . DateFromENtoRU(mb_substr($arUser['adate'], 0, 10), '-') . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Дата рождения</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="bdate" placeholder="Дата рождения пользователя (формат 01-01-1979)" class="form-control"<?= ($_GET['act'] == 'edit') ? ' value="' . DateFromENtoRU(mb_substr($arUser['bdate'], 0, 10), '-') . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?= ($_GET['act'] == 'edit' && $arUser['img_ext'] != '') ? '<img src="/face/' . $arUser['id'] . '_thumb.' . $arUser['img_ext'] . '" border="0" alt="" class="img-thumbnail" /><br />' : ''; ?>
                                            <label for="exampleInputFile">Фото</label>
                                            <input type="file" name="face" id="exampleInputFile">
                                            <p class="help-block">Размер файла не более 2 Мб.</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Активен</label><br />
                                            <input type="checkbox" name="active" value="1"<?= ($_GET['act'] == 'edit' && $arUser['active'] != 'true') ? '' : ' checked="checked"'; ?>>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <a href="/user.php" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
      		    // $("#items").load("/role.func.php");
            //     setInterval(function() {$("#items").load("/role.func.php");}, 5000);

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

                $('#data').show();
                $('.overlay').hide();
            });

            function checkForm()
            {
                if (document.role.adate.value == '') {
                    alert('Укажите дату до которой пользователь активен!');
                    document.role.adate.focus();
                } else if (document.role.bdate.value == '') {
                    alert('Укажите дату рождения пользователя!');
                    document.editform.ordernumber.focus();
                } else {
                    document.role.submit();
                }
                // if (document.role.title.value != '') {

                // } else {
                //     alert('Укажите название роли безопасности!');
                // }
            }
        /*]]>*/
        </script>
    </body>
</html>
