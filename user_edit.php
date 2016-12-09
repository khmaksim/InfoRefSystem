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
                                            <label for="exampleInputFile">Роль</label>
                                            <select class="form-control" name="role_id">
                                                <?php
                                                    $sql = "SELECT * FROM public.role ORDER BY title";
                                                    foreach ($dbconn->query($sql) as $row) {
                                                ?>
                                                <option value="<?= $row['id']; ?>"<?= ($_GET['act'] == 'edit' && $arUser['role_id'] == $row['id']) ? ' selected="selected"' : ''; ?>><?= $row['title']; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Имя</label>
                                            <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Имя для входа в систему"<?= ($_GET['act'] == 'edit') ? ' value="' . $arUser['name'] . '"' : ''; ?>>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputPassword1">Пароль</label>
                                            <input type="password" name="passwd" class="form-control" id="exampleInputPassword1" placeholder="Указать при создании пользователя или если необходимо поменять при редактировании">
                                        </div>

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
      		    $("#items").load("/role.func.php");
                setInterval(function() {$("#items").load("/role.func.php");}, 5000);

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
                if (document.role.title.value != '') {
                    document.role.submit();
                } else {
                    alert('Укажите название роли безопасности!');
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
