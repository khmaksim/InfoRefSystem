<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php");
    $request = \view\ViewHelper::getRequest();
    $edit_product = $request->getProperty('product');
    $action = $request->getProperty('cmd');
    $action_name = ($action == 'AddProduct') ? 'Добавление' : 'Редактирование';
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
                <ol class="breadcrumb">
                    <li><a href="./"><i class="glyphicon glyphicon-home"></i> Главная</a></li>
                    <li><a href="/?cmd=ResearchWork">Научно-исследовательская работа</a></li>
                    <li><a href="/?cmd=Product">Шифр</a></li>
                    <li class="active"><?php echo $action_name; ?></li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                <?php
                    $alertMessage = 'Укажите индекс изделия!';
                ?>
                <!-- Your Page Content Here -->
                <div class="row">
                    <div class="col-xs-12">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <h3 class="box-title"><?php echo $action_name; ?></h3>
                            </div><!-- /.box-header -->
                            <?php 
                                if (!is_null($request->getProperty('error')))
                                    echo '<div class="alert alert-warning"><p class="text-left">Внимание:'. $request->getProperty('error') .'</p></div>';
                            ?>
                            <!-- form start -->
                            <form name="editform" role="form" method="post" enctype="multipart/form-data">
                                <!-- <input type="hidden" name="token" value="<?= $_SESSION['token'] ?>" /> -->
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group <?= (!is_null($request->getProperty('error'))) ? 'has-warning' : ''?>">
                                                <label for="inputCipher">Шифр</label>
                                                <input type="text" name="cipher" class="form-control" id="inputCipher" placeholder="Шифр"<?= ($action == 'EditProduct' || 
                                                !is_null($edit_product->cipher)) ? ' value="' . $edit_product->cipher . '"' : ''; ?>>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="inputIndex">Индекс</label>
                                                <input type="text" name="index" class="form-control" id="inputIndex" placeholder="Индекс"<?= ($action == 'EditProduct' || 
                                                !is_null($edit_product->index)) ? ' value="' . $edit_product->index . '"' : ''; ?> required autofocus>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputDescription">Назначение</label>
                                        <textarea class="form-control" rows="3" name="description" id="inputDescription" placeholder="Описание"><?= ($action == 'EditProduct' || 
                                                !is_null($edit_product->description)) ? '' . $edit_product->description . '' : ''; ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputCreator">Разработчик</label>
                                        <input type="text" name="creator" class="form-control" id="inputCreator" placeholder="Разработчик"<?= ($action == 'EditProduct' || 
                                                !is_null($edit_product->creator)) ? ' value="' . $edit_product->creator . '"' : ''; ?>>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputSecurityLabel">Гриф обрабатываемой информации</label>
                                        <select class="form-control" name="security-label" id="inputSecurityLabel">
                                            <option <?= ($action == 'EditProduct' && $edit_product->security_label == 'ДСП') ? 'selected="selected"' : '' ?>>ДСП</option>
                                            <option <?= ($action == 'EditProduct' && $edit_product->security_label == 'С') ? 'selected="selected"' : '' ?>>С</option>
                                            <option <?= ($action == 'EditProduct' && $edit_product->security_label == 'СС') ? 'selected="selected"' : '' ?>>СС</option>
                                            <option <?= ($action == 'EditProduct' && $edit_product->security_label == 'ОВ') ? 'selected="selected"' : '' ?>>ОВ</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputImageFile">Изображение</label>
                                        <input type="file" name="image-file" id="inputImageFile">
                                        <p class="help-block">Размер файла не более 2 Мб.</p>
                                        <div class="col-md-1"><?= ($action == 'EditProduct') ? '<img src="' . $edit_product->image_file_name . '" border="0" alt="" class="img-thumbnail" /><br />' : ''; ?></div>
                                    </div>
                                </div>
                                <div class="box-footer">
                                    <a href="/?cmd=Product" type="submit" class="btn btn-default">Отмена</a> <a onclick="checkForm();" type="submit" class="btn btn-primary">Сохранить</a>
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
             <script language="JavaScript" type="text/javascript">
                /*<![CDATA[*/
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
