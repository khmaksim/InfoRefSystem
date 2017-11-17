<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $objectInterface = new ProductInterface($dbo);
    $page = 'product_view';
?>
<body onload="window.print();">
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                  <h2 class="page-header">Карточка изделия
                    <small class="pull-right">Дата печати: <?= date('d.m.Y'); ?></small>
                </h2>
                </div>
             <!-- /.col -->
            </div>
            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12">
                    <?php
                        $id = NULL;
                        if (isset($_GET['id'])) {
                            $id = $_GET['id'];
                        }
                        echo $objectInterface->view_print($id);
                    ?>
                </div>
            <!-- /.col -->
            </div>
        <!-- /.row -->
        </section>
    <!-- /.content -->
    </div>
<!-- ./wrapper -->
</body>
</html>
