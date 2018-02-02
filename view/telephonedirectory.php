<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
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
                        <li class="active">Телефонный справочник</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                    <form action="/phone_list.php" method="POST" name="View" target="_blank">
                <!-- Your Page Content Here -->
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="text-right">
                                    <a href="javascript:void(0);" onclick="document.View.submit();" type="button" class="btn btn-app"><i class="fa fa-print"></i> Печать</a>
                                    <!--<a href="javascript:void(0);" onclick="document.View.submit();" type="button" class="btn btn-app"><i class="fa fa-print"></i> Справочник</a>-->
                                </p>
                            </div><!-- /.col -->
                        </div>
                        <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Телефонный справочник</h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-1 text-center">Печать</th>
                                                <th>Наименование</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">
                                       <?php
                                            if (!is_null($request)) {
                                                $department_tree = $request->getProperty('department_tree');

                                                $id = null;
                                                $id_parent = null;
                                                $end_html = "";
                                                $padding = 1;

                                                foreach ($department_tree as $department) {
                                                    if (!is_null($id_parent) && $id != $department->parent) {
                                                        if ($id_parent != $department->parent)
                                                            $padding = 0;
                                                    }
                                                    else if (!is_null($id))
                                                        $padding += 2;

                                                    echo  '<tr>
                                                        <td class="text-center"><input type="checkbox" name="active[]" value="' . $department->id . '" /></td>
                                                        <td style="padding-left: ' . (8 * $padding) . 'px;">
                                                        <a href="/?cmd=TelephoneDirectoryDepartment&id_department=' . $department->id . '">' . $department->fullname . '</a></td></tr>';
                                                    
                                                    if ($id_parent != $department->parent)
                                                        $id_parent = $department->parent;
                                                    $id = $department->id;
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                 </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>
                    </form>

                </section><!-- /.content -->
            </div><!-- /.content-wrapper -->
        <?php
            include_once $_SERVER['DOCUMENT_ROOT'] . '/mainfooter.inc.php';
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

        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            $(document).ready(function(){
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });
                // setInterval(function() {$("#items").load("/phonelist.func.php");}, 5000);
            });
        /*]]>*/
        </script>
    </body>
</html>
