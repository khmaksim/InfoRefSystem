<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'incoming';
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
                        <li><a href="/incoming.php">Учёт входящих</a></li>
                        <li class="active"><?= ($_GET['act'] == 'add') ? 'Добавление' : 'Редактирование'; ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">

                <?php
                    if ($_GET['act'] == 'edit') {
                        $arIncoming = getIncomingById($_GET['id']);
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
                                <form name="role" id="role" role="form" action="/save.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="act" value="<?= $_GET['act']; ?>Incoming" />
                                    <input type="hidden" name="code" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                   <label for="number_in">Входящий номер</label>
                                                   <input tabindex="1" type="text" name="number_in" class="form-control" id="number_in" placeholder="Входящий номер"<?= ($_GET['act'] == 'edit') ? ' value="' . $arIncoming['number_in'] . '"' : ''; ?>>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="date_in">Дата регистрации</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input tabindex="2" type="text" name="date_in" placeholder="Дата регистрации (формат 01-01-1979)" class="form-control"<?= ($_GET['act'] == 'edit') ? ' value="' . DateFromENtoRU(mb_substr($arIncoming['date_in'], 0, 10), '-') . '"' : ''; ?> autofocus>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="grif">Гриф</label>
                                                    <select tabindex="3" class="form-control" name="grif">
                                                        <?php
                                                            $sql = "SELECT * FROM public.taccesstype ORDER BY id";
                                                            foreach ($dbconn->query($sql) as $row) {
                                                        ?>
                                                        <option value="<?= $row['id']; ?>"<?= ($_GET['act'] == 'edit' && $arIncoming['grif'] == $row['id']) ? ' selected="selected"' : ''; ?>><?= $row['name']; ?></option>
                                                        <?php
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="control">Контроль</label>
                                                    <select tabindex="4" class="form-control" name="control">
                                                        <option value="0"<?= ($_GET['act'] == 'edit' && $arIncoming['control'] == 0) ? ' selected="selected"' : ''; ?>>Нет</option>
                                                        <option value="1"<?= ($_GET['act'] == 'edit' && $arIncoming['control'] == 1) ? ' selected="selected"' : ''; ?>>Предварительный</option>
                                                        <option value="2"<?= ($_GET['act'] == 'edit' && $arIncoming['control'] == 2) ? ' selected="selected"' : ''; ?>>На контроль</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="senders_numbers">Отправители и номера документа</label>
                                                    <textarea tabindex="5" name="senders_numbers" class="form-control" rows="3" placeholder="Отправители и номера документа"><?= ($_GET['act'] == 'edit') ? $arIncoming['senders_numbers'] : ''; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="sheets">Количество листов</label>
                                                    <input tabindex="6" type="text" name="sheets" class="form-control" id="sheets" placeholder="Количество листов"<?= ($_GET['act'] == 'edit') ? ' value="' . $arIncoming['sheets'] . '"' : ''; ?>>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <!-- Custom Tabs -->
                                                <div class="nav-tabs-custom">
                                                    <ul class="nav nav-tabs">
                                                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Содержание, поручения, указания</a></li>
                                                        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Комментарии</a></li>
                                                        <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Прикреплённые файлы</a></li>
                                                    </ul>
                                                    <div class="tab-content">
                                                        <div class="tab-pane active" id="tab_1">
                                                            <div class="row">
                                                                <div class="col-md-3">
                                                                    <div class="form-group">
                                                                        <label for="subject">Содержание</label>
                                                                        <textarea tabindex="7" name="subject" class="form-control" rows="3" placeholder="Содержание"><?= ($_GET['act'] == 'edit') ? $arIncoming['subject'] : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label for="orders">Поручения вышестоящего органа</label>
                                                                        <textarea tabindex="8" name="orders" class="form-control" rows="3" placeholder="Поручения вышестоящего органа"><?= ($_GET['act'] == 'edit') ? $arIncoming['orders'] : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="instructions">Указания руководства</label>
                                                                        <textarea tabindex="9" name="instructions" class="form-control" rows="3" placeholder="Указания руководства"><?= ($_GET['act'] == 'edit') ? $arIncoming['instructions'] : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- /.tab-pane -->
                                                        <div class="tab-pane" id="tab_2">
                                                            <textarea tabindex="10" name="notes" class="form-control" rows="3" placeholder="Комментарии"><?= ($_GET['act'] == 'edit') ? $arIncoming['notes'] : ''; ?></textarea>
                                                        </div><!-- /.tab-pane -->
                                                        <div class="tab-pane" id="tab_3">
                                                            <div class="row">
                                                                <div class="col-md-8">
                                                                    <table id="attached" class="table table-striped table-hover table-bordered" cellspacing="0" width="100%">
                                                                        <thead>
                                                                            <tr>
                                                                                <th>Наименование</th>
                                                                                <th class="col-xs-1 text-center">Удалить</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody id="items"></tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input type="hidden" name="incoming" value="<?= $_GET['id']; ?>" />
                                                                    <div class="form-group">
                                                                        <label for="addFileName">Прикрепление файла</label>
                                                                        <input type="file" name="file" id="addFileName" />
                                                                        <p class="help-block">Выбереите файл и нажмите кнопку "Добавить"</p>
                                                                    </div>
                                                                    <a type="file" id="addfile" onclick="javascript:void(0);" class="btn btn-block btn-primary">Добавить</a>
                                                                </div>
                                                            </div>
                                                        </div><!-- /.tab-pane -->
                                                    </div><!-- /.tab-content -->
                                                </div><!-- nav-tabs-custom -->
                                            </div><!-- /.col -->
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="box">
                                                    <div class="box-header">
                                                        <h3 class="box-title">Документ отправлен (подшит)</h3>
                                                    </div>
                                                    <div class="box-body">
                                                        <div class="row">
                                                            <div class="col-md-2">
                                                                <div class="form-group">
                                                                    <label for="out_where">Куда</label>
                                                                    <select tabindex="11" class="form-control" name="out_where">
                                                                        <?php
                                                                            $sql = "SELECT * FROM public.addressees ORDER BY short_name";
                                                                            foreach ($dbconn->query($sql) as $row) {
                                                                        ?>
                                                                        <option value="<?= $row['code']; ?>"<?= ($_GET['act'] == 'edit' && $arIncoming['out_where'] == $row['code']) ? ' selected="selected"' : ''; ?>><?= $row['short_name']; ?></option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3">
                                                                <div class="form-group">
                                                                    <label for="out_date">Дата</label>
                                                                    <div class="input-group date">
                                                                        <div class="input-group-addon">
                                                                            <i class="fa fa-calendar"></i>
                                                                        </div>
                                                                        <input tabindex="12" type="text" name="out_date" placeholder="Дата отправки (формат 01-01-1979)" class="form-control"<?= ($_GET['act'] == 'edit') ? ' value="' . DateFromENtoRU(mb_substr($arIncoming['out_date'], 0, 10), '-') . '"' : ''; ?>>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label for="out_details">Подробно</label>
                                                                        <textarea tabindex="13" name="out_details" class="form-control" rows="3" placeholder="Подробно"><?= ($_GET['act'] == 'edit') ? $arIncoming['out_details'] : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                  </div>
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <a href="/incoming.php" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
      		    $("#items").load("/incoming_file.func.php?id=<?= $_GET['id']; ?>");
                setInterval(function() {$("#items").load("/incoming_file.func.php?id=<?= $_GET['id']; ?>");}, 5000);

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

                $('#addfile').click(function() {
//                    var formData = new FormData($('#role')[0]); //Получение данных из формы
//                    alert(formData);
                    saveFile();
                });

                function saveFile() {
                    var form = document.forms.role;
                    var formData = new FormData(form);
                    var xhr = new XMLHttpRequest();
                    xhr.open("POST", "incoming_file_save.php");
                    xhr.onreadystatechange = function () {
                        if (xhr.readyState == 4) {
                            if (xhr.status == 200) {
                                $("#items").load("/incoming_file.func.php?id=<?= $_GET['id']; ?>");
                                $("#addFileName").val('');
                                //data = xhr.responseText;
                                //alert(data);
                            }
                        }
                    };
                    xhr.send(formData);
                }
            });

            function checkForm()
            {
                if (document.role.title.value != '') {
                    document.role.submit();
                } else {
                    alert('Укажите название роли безопасности!');
                }
            }

            function ConfirmDelete(code)
            {
                var ObjectId = code;
                if (confirm("Вы действительно хотите удалить запись?")) {
                    $.ajax({
                        type: "POST",
                        url: "/incoming_file_del.php",
                        data: "code=" + ObjectId,
                        success: function(msg){
                            $("#items").load("/incoming_file.func.php?id=<?= $_GET['id']; ?>");
                        }
                    });
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
