<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php") ;
    $request = \view\ViewHelper::getRequest();
    $department = $request->getProperty('department');
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
                        <li><a href="/?cmd=Structure">Cтруктура ЧНП ВКС</a></li>
                        <li class="active">Штатное расписание - <?= $department->fullname; ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                <!-- Your Page Content Here -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Штатное расписание подразделения</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-1">№</th>
                                                <th>Должность</th>
                                                <th>В/звание</th>
                                                <th>Тариф</th>
                                                <th>Форма допуска</th>
                                                <th>Номер приказа</th>
                                                <th>Дата</th>
                                                <th>Подписан</th>
                                                <th>Упразднена</th>
                                                <th class="col-xs-1 text-center">Редактировать</th>
                                                <th class="col-xs-1 text-center">Удалить</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">
                                        <?php 
                                            $unit_list = $request->getProperty('unit_list');
                                            $count = 0;
                                            foreach ($unit_list as $unit) {
                                                echo '<tr>
                                                        <td>' . ++$count . '</td>
                                                        <td>' . $unit->position . '</td>
                                                        <td>' . $unit->military_rank . '</td>
                                                        <td>' . $unit->tariff_category . '</td>
                                                        <td>' . $unit->access_type . '</td>
                                                        <td>' . $unit->order_number . '</td>
                                                        <td>' . $unit->dateorderstart . '</td>
                                                        <td>' . $unit->order_owner . '</td>
                                                        <td>' . $unit->dateorderend . '</td>
                                                        <td class="col-xs-1 text-center"><a href="/?cmd=EditUnit&id=' . $unit->id . '" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                                        <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete(' . $unit->id . ');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                                                    </tr>';
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
                            <p class="text-right"><a href="/?cmd=AddUnit&id_department=<?= $department->id; ?>" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>
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
            function ConfirmDelete(id)
            {
                var ObjectId = id;
                if(confirm("Вы действительно хотите удалить запись?")) {
                    document.location = "./?cmd=DeleteUnit&id="+ObjectId;
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
