<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $internetInterface = new InternetInterface($dbo);
    $title = 'Интернет';
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
                        <li><a href="/protectioninformation.php">Защита информации от НСД</a></li>
                        <li class="active"><?php echo $title; ?></li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                  <!-- Your Page Content Here -->
                  <div class="row">
                    <div class="col-xs-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo $title; ?></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="col-xs-3">
                                    <section class="sidebar">
                                       <!-- Sidebar Menu -->
                                      <ul class="sidebar-menu">
                                        <li class="header">Оргштатная структура</li>
                                        <!-- Optionally, you can add icons to the links -->
                                        <?php
                                            showDepartmentsNavTree();
                                        ?>
                                      </ul><!-- /.sidebar-menu -->
                                    </section>
                                </div>
                                <div class="col-xs-9">
                                    <table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <?php
                                           echo $internetInterface->displayByIdDepartment();
                                        ?>
                                    </table>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-xs-12">
                    <p class="text-right"><a onclick="addObject();" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>
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
                SelectedIdDepartment = $("li.treeview > a").first().attr("href").match(/\d+/);

                $("li.treeview > a").click(function() {
                    SelectedIdDepartment = $(this).attr("href").match(/\d+/);
                    $("table").load("/display.func.php?object=InternetInterface&id_department=" + SelectedIdDepartment);
                });
            });
            function addObject()
            {
                if (SelectedIdDepartment != null)
                    document.location = "/internet_edit.php?action=add&id_department=" + SelectedIdDepartment;
            }  
            function ConfirmDelete(id)
            {
                var ObjectId = id;
                if(confirm("Вы действительно хотите удалить запись?")) {
                    document.location = "./assets/inc/delete.inc.php?object=InternetInterface&id=" + ObjectId;
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
