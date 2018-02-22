<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php") ;
    $request = \view\ViewHelper::getRequest();
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
                        <li class="active">Подразделения</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                <!-- Your Page Content Here -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary collapsed-box">
                                <div class="box-header with-border">
                                    <i class="fa fa-search"></i>
                                    <h3 class="box-title">Поиск подразделения</h3>
                                    <div class="box-tools pull-right">
                                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                                    </div>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                        <div class="form-group">
                                            <label for="departments_search">Наименование подразделения</label>
                                            <input type="text" id="departments_search" name="departments_search" class="form-control" id="" placeholder="Название подразделения для поиска">
                                        </div>
                                        <div class="form-group">
                                            <label for="">Результаты поиска</label>
                                            <div class="box-body table-responsive no-padding">
                                              <table class="table table-hover" id="departments_searched"></table>
                                            </div>
                                        </div>
                                </div>
                                <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                        </div><!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Подразделения</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-1">Номер</th>
                                                <th>Наименование</th>
                                                <!--<th>Кому подчиняется</th>-->
                                                <th class="col-xs-1 text-center">Редактировать</th>
                                                <th class="col-xs-1 text-center">Удалить</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">
                                        <?php
                                            $department_list = $request->getProperty('department_list');
                                            if (!is_null($department_list)) {
                                                $id = null;
                                                $id_parent = [];
                                                $padding = 2;
                                                
                                                foreach ($department_list as $department) {
                                                    if (empty($id_parent))
                                                        $id_parent[] = $department->id;
                                                    else if ($id_parent[count($id_parent) - 1] == $department->parent) {
                                                        $id_parent[] = $department->id;
                                                        $padding += 2;
                                                    }
                                                    else {
                                                        $padding = 2;
                                                        for ($i = 0; $i < count($id_parent); $i++) {
                                                            if ($id_parent[$i] == $department->parent) {
                                                                $id_parent[] = $department->id;
                                                                $padding = ($i + 2) * 2;
                                                                break;
                                                            }
                                                        }
                                                    }
                                                    echo '<tr>
                                                            <td></td>
                                                            <td style="padding-left: ' . (8 * $padding) . 'px;">' . $department->fullname . '</td>
                                                            <td class="col-xs-1 text-center"><a href="/?cmd=EditDepartment&id=' . $department->id . '" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete(' . $department->id . ');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
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
                            <p class="text-right"><a href="/?cmd=AddDepartment" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>
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
        <script src="/dist/js/app.js"></script>
        <!-- Optionally, you can add Slimscroll and FastClick plugins.
             Both of these plugins are recommended to enhance the
             user experience. Slimscroll is required when using the
             fixed layout. -->
        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            $(document).ready(function(){
                $('#departments_search').bind('keyup', function(){
                    $('#departments_search').keypress();
                });

                $('#departments_search').keypress(function() {
                    $('#departments_searched').load('/departments_search.func.php', {departments_search: $('#departments_search').val()});
                });
            });
            function ConfirmDelete(id)
            {
                var ObjectId = id;
                if(confirm("Вы действительно хотите удалить запись?")) {
                    document.location = "./?cmd=DeleteDepartment&id="+ObjectId;
                }
            }
        /*]]>*/
        </script>
    </body>
</html>