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
                        <li><a href="/?cmd=ProtectionInformation">Защита информации от НСД</a></li>
                        <li class="active">Объекты КИИ</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                  <!-- Your Page Content Here -->
                  <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title">Объекты КИИ</h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="col-xs-3">
                                    <section class="sidebar">
                                       <!-- Sidebar Menu -->
                                      <ul class="sidebar-menu">
                                        <li class="header">Оргштатная структура</li>
                                        <!-- Optionally, you can add icons to the links -->
                                        <?php
                                            include_once $_SERVER['DOCUMENT_ROOT'] . '/structure_department.inc.php';
                                        ?>
                                      </ul><!-- /.sidebar-menu -->
                                    </section>
                                </div>
                                <div class="col-xs-9">
                                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="col-xs-1">№</th>
                                                <th>Наименование КВИТО</th>
                                                <th>Регистрационный №</th>
                                                <th>Аттестат</th>
                                                <th>Приказ</th>
                                                <th class="col-xs-1 text-center">Редактировать</th>
                                                <th class="col-xs-1 text-center">Удалить</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">
                                        <?php
                                            $object_kii_list = $request->getProperty('object_kii_list');
                                            $count = 1;
                                            foreach ($object_kii_list as $object_kii) {
                                               $row_html = '<tr>
                                                            <td>' . $count++ . '</td>
                                                            <td>' . $object_kii->name_kvito . '</td>
                                                            <td>' . $object_kii->reg_number . '</td>
                                                            <td>' . $object_kii->certificate . '</td>
                                                            <td>' . $object_kii->order . '</td>
                                                            <td class="col-xs-1 text-center"><a href="./objectskii_edit.php?action=edit&id='. $object_kii->id .'" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                                            <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('. $object_kii->id .');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
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
                    <p class="text-right"><a onclick="addObjectKii();" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>
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
            var SelectedIdDepartment = null;
            // $(document).ready(function(){
      		    // $("#items").load("/objectskii.func.php");
            //     setInterval(function() {$("#items").load("/objectskii.func.php");}, 5000);
            // });
            $(document).ready(function() {
                SelectedIdDepartment = $("li.treeview > a").first().attr("href").match(/\d+/)[0];

                $("li.treeview > a").click(function() {
                    SelectedIdDepartment = $(this).attr("href").match(/\d+/)[0];
                    $request = "/display.func.php?object=ObjectKiiInterface&department[]="+$(this).attr("href").match(/\d+/)[0];

                    $.each($(this).next().find("a"), function() {
                        $request += "&department[]="+$(this).attr("href").match(/\d+/)[0];
                    })
                    $("#example").load($request);
                });
            });
            function addObjectKii()
            {
                if (SelectedIdDepartment != null) {
                    document.location = "/?cmd=AddObjectKii&id_department=" + SelectedIdDepartment;
                }
            }  
            function ConfirmDelete(id)
            {
                var ObjectId = id;
                if(confirm("Вы действительно хотите удалить запись?")) {
                    document.location = "./assets/inc/delete.inc.php?object=ObjectKiiInterface&id=" + ObjectId;
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
