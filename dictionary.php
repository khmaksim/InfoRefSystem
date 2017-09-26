<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'dictionary';
    $nameDictionary = $_GET['name'];
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
                <?php
                    include_once $_SERVER['DOCUMENT_ROOT'] . '/' . $nameDictionary . '.php';
                ?>
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="text-right"><a href="/<?= $nameDictionary ?>_edit.php?act=add" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>
                            </div><!-- /.col -->
                        </div>
                    </section><!-- /.content -->
                </div><!-- /.content-wrapper -->
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
        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            $(document).ready(function(){
      		    $("#items").load("/<?= $nameDictionary ?>.func.php");
                setInterval(function() {$("#items").load("/<?= $nameDictionary ?>.func.php");}, 5000);
            });

            function ConfirmDelete(id)
            {
                var ObjectId = id;
                if(confirm("Вы действительно хотите удалить запись?")) {
                    document.location = "./save.php?id="+ObjectId+"&act=del<?= ucfirst($nameDictionary) ?>";
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
