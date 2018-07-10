<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php") ;
    $request = \view\ViewHelper::getRequest();
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
                        <li class="active">Руководящие документы</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <div class="form-horizontal">
                        <div class="form-group">
                            <label for="inputSearch" class="col-xs-1 control-label">Поиск</label>
                            <div class="col-lg-3">
                                  <input type="text" class="form-control search" id="inputSearch" placeholder="Введите номер приказа или наименование документа" 
                                  onkeyup="filterSearch(this.value)">
                            </div>
                        </div>
                    </div>
                    <!-- Your Page Content Here -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Руководящие документы</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-1">№</th>
                                                <th>Приказы и директивы</th>
                                                <th class="col-xs-1 text-center">Редактировать</th>
                                                <th class="col-xs-1 text-center">Удалить</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">
                                        <?php
                                            $document_list = $request->getProperty('document_list');
                                            $count = 1;
                                            if (!is_null($document_list)) {
                                                foreach ($document_list as $document) {
                                                    echo '<tr>
                                                        <td>'. $count++ .'</td>';
                                                    if (file_exists($document->file_name))
                                                        echo '<td><a href="/?cmd=Download&file=' . $document->file_name . '" target="_blank">' . $document->name . '</a></td>';
                                                    else
                                                        echo '<td>' . $document->name . '</td>';
                                                    echo '<td class="col-xs-1 text-center"><a href="/?cmd=EditDocument&id=' . $document->id . '" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                                        <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete(' . $document->id . ', \'' . basename($document->file_name) . '\');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                        </tr>';
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <p class="text-right"><a href="/?cmd=AddDocument" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>
                        </div><!-- /.col -->
                    </div>
                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
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

        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            function ConfirmDelete(id, fileName)
            {
                var ObjectId = id;
                var FileName = fileName;
                if(confirm("Вы действительно хотите удалить запись?")) {
                    document.location = "./?cmd=DeleteDocument&id="+ObjectId+"&fileName="+FileName;
                }
            }
            function filterSearch(text) {
                    var table = document.getElementById("items");
                    var rows = table.getElementsByTagName("tr");
                    var nums = rows.length;
                    var i = 0;
                    var n = 1;
                    while (i < nums) {
                        var rowIndex = rows[i];
                        var cols = rowIndex.getElementsByTagName("td");
                        if (cols[1].innerText.indexOf(text) >= 0) {
                            rows[i].style.display = "";
                            cols[0].innerText = n;
                            n += 1;
                        }
                        else {
                            rows[i].style.display = "none";
                        }
                        i += 1;
                    }
                }
        /*]]>*/
        </script>
    </body>
</html>
