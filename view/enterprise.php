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
                <h1>
                    <small></small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="./"><i class="glyphicon glyphicon-home"></i> Главная</a></li>
                    <li><a href="/?cmd=ResearchWork">Научно-исследовательская работа</a></li>
                    <li class="active">Предприятия</li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                  <!-- Your Page Content Here -->
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Предприятия</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="col-xs-12">
                                    <table id="product_table" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-1">№</th>
                                                <th>Название</th>
                                                <th>Место дислокации</th>
                                                <th>Руководитель</th>
                                                <th>Должность</th>
                                                <th class="col-xs-1 text-center">Редактировать</th>
                                                <th class="col-xs-1 text-center">Удалить</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">
                                        <?php
                                            $enterprise_list = $request->getProperty('enterprise_list');
                                            $count = 1;
                                            foreach ($enterprise_list as $enterprise) {
                                               $row_html = '<tr>
                                                            <td>' . $count++ . '</td>
                                                            <td>' . $enterprise->name . '</td>
                                                            <td>' . $enterprise->location . '</td>
                                                            <td>' . $enterprise->head . '</td>
                                                            <td>' . $enterprise->post . '</td>
                                                            <td class="col-xs-1 text-center"><a href="./?cmd=EditEnterprise&id='. $enterprise->id .'" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('. $enterprise->id .');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                            </tr>';
                                                echo $row_html;
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <p class="text-right"><a href="./?cmd=AddEnterprise" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>
                    </div><!-- /.col -->
                </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
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
                function ConfirmDelete(id)
                {
                    var ObjectId = id;
                    if(confirm("Вы действительно хотите удалить запись?")) {
                        document.location = "./?cmd=DeleteEnterprise&id=" + ObjectId;
                    }
                }
                /*]]>*/
            </script>
    </body>
</html>
