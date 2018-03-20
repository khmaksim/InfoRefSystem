<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    require_once ("view/ViewHelper.php");
    $request = \view\ViewHelper::getRequest();
    $person = $request->getProperty('person');
    $military_rank = $request->getProperty('military_rank');
    $unit = $request->getProperty('unit');
    $department = $request->getProperty('department');
    $position = $request->getProperty('position');
?>
    <body onload="window.print();">
        <div class="wrapper">
          <!-- Main content -->
          <section class="invoice">
            <!-- title row -->
            <div class="row">
              <div class="col-xs-12">
                <h2 class="page-header">
                  <i class="fa fa-user"></i> <?= $military_rank->name .' '. $person->getFullName() .' ('. $person->personal_number .')'; ?>
                  <small class="pull-right">Дата печати: <?= date('d-m-Y'); ?></small>
                </h2>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <strong>Фото</strong><br />
                <?= ($person->img_ext != '') ? '<img src="./upload/user/'. $person->id .'_thumb.'. $person->img_ext .'" border="0" alt="" class="img-thumbnail" /><br /><br />' : ''; ?>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <strong>Подразделение</strong>
                <address>
                  <?= $department->fullname; ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <strong>Должность</strong>
                <address>
                  <?= $position->name; ?>
                </address>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <strong>Дата рождения</strong>
                <address>
                  <?= \DateTime::createFromFormat('Y-m-d', $person->birthday)->format('m-d-Y'); ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <strong>Форма допуска</strong>
                <address>
                  <?= $request->getProperty('access_type')->name; ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col"></div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <strong>Адрес</strong>
                <address>
                  <?= $request->getProperty('city')->name; ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <strong>Телефоны</strong>
                <address>
                  <?php
                    $phone_number_list = $request->getProperty('phone_number_list');
                    $phone_number_type_list = $request->getProperty('phone_number_type_list');
                    foreach ($phone_number_list as $phone_number) {
                        foreach ($phone_number_type_list as $phone_number_type) {
                            if ($phone_number_type->id == $phone_number->id_phone_number_type) {
                                echo $phone_number_type->name .' - '. $phone_number->number . '<br>';
                                break;
                            }
                        }
                    }
                  ?>
                </address>
              </div>
              <!-- /.col -->
             <!--  <div class="col-sm-4 invoice-col">
                <strong>E-Mail</strong>
                <address>
                 //
                </address>
              </div> -->
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row invoice-info">
              <div class="col-sm-12 invoice-col">
                <strong>Комментарий</strong>
                <address>
                  <?= $person->note; ?>
                </address>
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
