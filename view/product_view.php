<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php");
    $request = \view\ViewHelper::getRequest();
    $product = $request->getProperty('product');
?>
<body onload="window.print();">
    <div class="wrapper">
        <!-- Main content -->
        <section class="invoice">
          <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">Карточка изделия <small class="pull-right">Дата печати: <?= date('d.m.Y'); ?></small></h2>
                </div>
             <!-- /.col -->
            </div>
            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12">
                    <div class="row">
                        <big>
                        <div class="col-xs-6 col-xs-offset-4 col-md-4 col-md-offset-4 col-lg-3 col-lg-offset-5">
                            Изделие <b><?= $product->index ?></b>, шифр <b><?= $product->cipher ?></b>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-md-12 col-lg-12"><?= $product->description ?></div>
                    </div>
                    <div class="row">
                        <div class="col-xs-4 col-xs-offset-8 col-md-2 col-md-offset-10">
                            <img src="<?= $product->image_file_name ?>" alt="<?= $product->index ?>" class="img-thumbnail" width=100% height=100%>
                        </div>
                        </big>
                    </div>
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
