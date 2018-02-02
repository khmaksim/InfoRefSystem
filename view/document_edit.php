<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php") ;
    $request = \view\ViewHelper::getRequest();
    $edit_document = $request->getProperty('document');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'AddDocument') ? 'Добавление' : 'Редактирование';
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
                        <li><a href="/?cmd=Document">Руководящие документы</a></li>
                        <li class="active"><?php echo $action_name; ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                <?php
                    $alertMessage = 'Укажите наименование документа!';
                ?>
                <!-- Your Page Content Here -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?php echo $action_name; ?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form name="editform" role="form" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="act" value="<?= $_GET['act']; ?>Document" />
                                    <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputDocuments">Наименование документа</label>
                                            <input type="text" name="name" class="form-control" id="exampleInputDocuments" placeholder="Наименование документа"<?= ($action == 'EditDocument') ? ' value="' . $edit_document->name . '"' : ''; ?> required autofocus>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile">Раздел отображения</label>
                                            <select class="form-control" name="section">
                                                <option value="0">-</option>
                                                <?php
                                                    $arSection = ['Защита информации от НСД', 'Кадровая работа', 'Научно-исследовательская работа', 'Режим секретности', 'Техническая защита информации', 'Шифровальная работа'];
                                                    foreach ($arSection as $row) {
                                                ?>
                                                <option value="<?= $row; ?>" <?= ($action == 'EditDocument' && $edit_document->section == $row) ? ' selected="selected"' : ''; ?>><?= $row; ?></option>
                                                <?php
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputFile"><?= ($action == 'EditDocument' && $edit_document->file_name != '') ? '<a href="download.php?file=' . $edit_document->file_name . '" target="_blank">Файл</a><br />' : 'Файл'; ?></label>
                                            <input type="file" name="document_file" id="exampleInputFile">
                                            <p class="help-block">Размер файла не более 2 Мб.</p>
                                        </div>
                                    </div><!-- /.box-body -->
                                    <div class="box-footer">
                                        <a href="/documents.php" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
        <!-- select2 -->
        <script src="/plugins/select2/select2.full.min.js"></script>
        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            $(document).ready(function(){
                $('select').select2();
            });

            function checkForm()
            {
                if (document.editform.name.value != '') {
                    document.editform.submit();
                } else {
                    alert('<?= $alertMessage ?>');
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
