<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
$scientificResearchDesignWorkInterface = new ScientificResearchDesignWorkInterface($dbo);
$title = 'Сопровождаемые НИОКР';
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
                    <li><a href="/researchwork.php">Научно-исследовательская работа</a></li>
                    <li class="active"><?php echo $title; ?></li>
                </ol>
            </section>
            <!-- Main content -->
            <section class="content">
                  <!-- Your Page Content Here -->
                <div class="form-horizontal">
                    <div class="form-group">
                        <label for="inputSearch" class="col-xs-1 control-label">Поиск</label>
                        <div class="col-md-3">
                              <input type="text" class="form-control search" id="inputSearch" placeholder="Индекс или шифр изделия" onkeyup="filterSearch(this.value)">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="box">
                            <div class="box-header">
                                <h3 class="box-title"><?php echo $title; ?></h3>
                            </div><!-- /.box-header -->
                            <div class="box-body">
                                <div class="col-xs-12">
                                    <table id="product_table" class="table table-hover table-bordered" cellspacing="0" width="100%">
                                        <?php
                                            echo $scientificResearchDesignWorkInterface->display();
                                        ?>
                                    </table>
                                </div>
                            </div><!-- /.box-body -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div>
                <div class="row">
                    <div class="col-xs-12">
                        <p class="text-right"><a href="./scientificresearchdesignwork_edit.php?action=add" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>
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
                        document.location = "./assets/inc/delete.inc.php?object=ScientificResearchDesignWorkInterface&id=" + ObjectId;
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
                        if (cols[1].innerText.indexOf(text) >= 0 || cols[2].innerText.indexOf(text) >= 0) {
                            rows[i].style.display = "";
                            rows[i+1].style.display = "";
                            cols[0].innerText = n;
                            n += 1;
                        }
                        else {
                            rows[i].style.display = "none";
                            rows[i+1].style.display = "none";
                        }
                        i += 2;
                    }
                }
                /*]]>*/
            </script>
    </body>
</html>
