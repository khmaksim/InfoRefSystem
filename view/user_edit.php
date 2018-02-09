<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php") ;
    $request = \view\ViewHelper::getRequest();
    $edit_user = $request->getProperty('user');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'AddUser') ? 'Добавление' : 'Редактирование';
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
                        <li><a href="/?cmd=User">Пользователи</a></li>
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
                                <form name="role" role="form" method="post" enctype="multipart/form-data">
                                    <!-- <input type="hidden" name="act" value="<?= $_GET['act']; ?>User" /> -->
                                    <!-- <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" /> -->
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="inputFIO">ФИО</label>
                                            <input type="text" name="title" class="form-control" id="inputFIO" placeholder="Фамилия Имя Отчество пользователя"<?= ($action == 'EditUser') ? ' value="' . $edit_user->title . '"' : ''; ?> required autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputLogin">Имя</label>
                                            <input type="text" name="name" class="form-control" id="inputLogin" placeholder="Имя для входа в систему"<?= ($action == 'EditUser') ? ' value="' . $edit_user->name . '"' : ''; ?> required>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputPassword">Пароль</label>
                                            <input type="password" name="passwd" class="form-control" id="inputPassword" placeholder="Указать при создании пользователя или если необходимо поменять при редактировании">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputGroup">Принадлежит к группе</label>
                                            <select class="form-control" id="inputGroup">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputRole">Роль</label>
                                            <select class="form-control" id="inputRole">
                                                <option>1</option>
                                                <option>2</option>
                                                <option>3</option>
                                                <option>4</option>
                                                <option>5</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputActiveUntil">Активен до</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="adate" placeholder="Дата до которой пользователь активен (формат 01-01-1979)" class="form-control"<?= ($action == 'EditUser') ? ' value="' . DateFromENtoRU(mb_substr($edit_user->adate, 0, 10), '-') . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputBirthday">Дата рождения</label>
                                            <div class="input-group date">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-calendar"></i>
                                                </div>
                                                <input type="text" name="bdate" placeholder="Дата рождения пользователя (формат 01-01-1979)" class="form-control"<?= ($action == 'EditUser') ? ' value="' . DateFromENtoRU(mb_substr($edit_user->bdate, 0, 10), '-') . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <?= ($action == 'EditUser' && $edit_user->img_ext != '') ? '<img src="/upload/face/' . $edit_user->id . '_thumb.' . $edit_user->img_ext . '" border="0" alt="" class="img-thumbnail" /><br />' : ''; ?>
                                            <label for="inputPhoto">Фото</label>
                                            <input type="file" name="face" id="inputPhoto">
                                            <p class="help-block">Размер файла не более 2 Мб.</p>
                                        </div>
                                        <div class="form-group">
                                            <label for="inputActive">Активен</label><br />
                                            <input type="checkbox" name="active" value="1"<?= ($action == 'EditUser' && $edit_user->active != 'true') ? '' : ' checked="checked"'; ?>>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <a href="./?cmd=User" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
