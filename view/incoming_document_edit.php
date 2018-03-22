<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php") ;
    $request = \view\ViewHelper::getRequest();
    $edit_incoming_document = $request->getProperty('incoming_document');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'AddIncomingDocument') ? 'Добавление' : 'Редактирование';
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
                        <li><a href="/?cmd=IncomingDocument">Документооборот</a></li>
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
                                    <input type="hidden" name="code" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                   <label for="number_in">Входящий номер</label>
                                                   <input tabindex="1" type="text" name="number_in" class="form-control" id="number_in" placeholder="Входящий номер"<?= ($action == 'EditIncomingDocument') ? ' value="'. $edit_incoming_document->number_in .'"' : ''; ?> required autofocus>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="date_in">Дата регистрации</label>
                                                    <div class="input-group date">
                                                        <div class="input-group-addon">
                                                            <i class="fa fa-calendar"></i>
                                                        </div>
                                                        <input tabindex="2" type="text" name="date_in" placeholder="формат 01-01-1979" class="form-control"<?= ($action == 'EditIncomingDocument') ? ' value="'. $edit_incoming_document->date_registration .'"' : ' value="'. (new \DateTime())->format('d-m-Y') .'"' ?> required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="grif">Гриф</label>
                                                    <select tabindex="3" class="form-control" name="grif" required>
                                                        <?php
                                                            $access_type_list = $request->getProperty('access_type_list');
                                                            foreach ($access_type_list as $access_type) {
                                                                echo '<option value="'. $access_type->id .'" '. (($action == 'EditIncomingDocument' && $edit_incoming_document->security_label == $access_type->id) ? 'selected="selected"' : '') .'>'. $access_type->name .'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="control">Контроль</label>
                                                    <select tabindex="4" class="form-control" name="control">
                                                        <option value="0"<?= ($action == 'EditIncomingDocument' && $edit_incoming_document->control == 0) ? ' selected="selected"' : ''; ?>>Нет</option>
                                                        <option value="1"<?= ($action == 'EditIncomingDocument' && $edit_incoming_document->control == 1) ? ' selected="selected"' : ''; ?>>Предварительный</option>
                                                        <option value="2"<?= ($action == 'EditIncomingDocument' && $edit_incoming_document->control == 2) ? ' selected="selected"' : ''; ?>>На контроль</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="senders_numbers">Отправители и номера документа</label>
                                                    <textarea tabindex="5" name="senders_numbers" class="form-control" rows="3" placeholder="Отправители и номера документа"><?= ($action == 'EditIncomingDocument') ? $edit_incoming_document->senders_numbers : ''; ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="number_sheets">Количество листов</label>
                                                    <input tabindex="6" type="text" name="number_sheets" class="form-control" id="number_sheets" placeholder="Количество листов"<?= ($action == 'EditIncomingDocument') ? ' value="' . $edit_incoming_document->number_sheets . '"' : ''; ?>>
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
                                                                        <textarea tabindex="7" name="subject" class="form-control" rows="3" placeholder="Содержание"><?= ($action == 'EditIncomingDocument') ? $edit_incoming_document->subject : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <div class="form-group">
                                                                        <label for="orders">Поручения вышестоящего органа</label>
                                                                        <textarea tabindex="8" name="orders" class="form-control" rows="3" placeholder="Поручения вышестоящего органа"><?= ($action == 'EditIncomingDocument') ? $edit_incoming_document->order : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <div class="form-group">
                                                                        <label for="instructions">Указания руководства</label>
                                                                        <textarea tabindex="9" name="instructions" class="form-control" rows="3" placeholder="Указания руководства"><?= ($action == 'EditIncomingDocument') ? $edit_incoming_document->instructions : ''; ?></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div><!-- /.tab-pane -->
                                                        <div class="tab-pane" id="tab_2">
                                                            <textarea tabindex="10" name="notes" class="form-control" rows="3" placeholder="Комментарии"><?= ($action == 'EditIncomingDocument') ? $edit_incoming_document->note : ''; ?></textarea>
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
                                                                    <!-- <input type="hidden" name="incoming" value="" /> -->
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
                                                                            // echo '<option value="'. $row['code'] .'"'. ($action == 'EditIncomingDocument' && $edit_incoming_document->out_where == $row['code']) ? ' selected="selected"' : ''; .'>'. $row['short_name']; .'</option>';
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
                                                                        <input tabindex="12" type="text" name="out_date" placeholder="Дата отправки (формат 01-01-1979)" class="form-control"<?= ($action == 'EditIncomingDocument') ? ' value="' . $edit_incoming_document->out_date . '"' : ''; ?>>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="form-group">
                                                                    <div class="form-group">
                                                                        <label for="out_details">Подробно</label>
                                                                        <textarea tabindex="13" name="out_details" class="form-control" rows="3" placeholder="Подробно"><?= ($action == 'EditIncomingDocument') ? $edit_incoming_document->out_details : ''; ?></textarea>
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
                                        <a href="/?cmd=IncomingDocument" type="submit" class="btn btn-default">Отмена</a><a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
            <!-- Add the sidebar's background. This div must be placed
            immediately after the control sidebar -->
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
      		    // $("#items").load("/incoming_file.func.php?id=");
            //     setInterval(function() {$("#items").load("/incoming_file.func.php?id=");}, 5000);

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

                // function saveFile() {
                //     var form = document.forms.role;
                //     var formData = new FormData(form);
                //     var xhr = new XMLHttpRequest();
                //     xhr.open("POST", "incoming_file_save.php");
                //     xhr.onreadystatechange = function () {
                //         if (xhr.readyState == 4) {
                //             if (xhr.status == 200) {
                //                 $("#items").load("/incoming_file.func.php?id=");
                //                 $("#addFileName").val('');
                //                 //data = xhr.responseText;
                //                 //alert(data);
                //             }
                //         }
                //     };
                //     xhr.send(formData);
                // }
            });

            function checkForm()
            {
                if (document.editform.number_in.value != '') {
                    document.editform.submit();
                } else {
                    alert('Укажите номер входящего документа!');
                }
            }

            // function ConfirmDelete(code)
            // {
            //     var ObjectId = code;
            //     if (confirm("Вы действительно хотите удалить запись?")) {
            //         $.ajax({
            //             type: "POST",
            //             url: "/incoming_file_del.php",
            //             data: "code=" + ObjectId,
            //             success: function(msg){
            //                 $("#items").load("/incoming_file.func.php?id=");
            //             }
            //         });
            //     }
            // }
        /*]]>*/
        </script>
    </body>
</html>
