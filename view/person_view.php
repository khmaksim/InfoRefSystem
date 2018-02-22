<?php
    if (!isset($_GET['id'])) {
        header('Location: /departments.php');
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'phonelist';

    $arPerson = getPersonById($_GET['id']);
    $arDepartment = getDepartmentsById($_GET['id_departments']);
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
    <body onload="window.print();">
        <div class="wrapper">
          <!-- Main content -->
          <section class="invoice">
            <!-- title row -->
            <div class="row">
              <div class="col-xs-12">
                <h2 class="page-header">
                  <i class="fa fa-user"></i> <? $t1 = getMilitaryRankById($arPerson['id_militaryrank']); print mb_strtolower($t1['name'], 'utf-8') . ' ' . $arPerson['lastname'] . ' ' . $arPerson['firstname'] . ' ' . $arPerson['patronymic'] . ' (' . $arPerson['personalnumber'] . ')'; ?>
                  <small class="pull-right">Дата печати: <?= date('d-m-Y'); ?></small>
                </h2>
              </div>
              <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <strong>Фото</strong><br />
                <?= ($arPerson['img_ext'] != '') ? '<img src="/user/' . $arPerson['id'] . '_thumb.' . $arPerson['img_ext'] . '" border="0" alt="" class="img-thumbnail" /><br /><br />' : ''; ?>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <strong>Подразделение</strong>
                <address>
                  <?= $arDepartment['fullname']; ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <strong>Должность</strong>
                <address>
                  <?php
                    $sql = "SELECT * FROM public.tunit WHERE id = '" . $arPerson['id_tunit'] . "' ORDER BY id";
                    foreach ($dbconn->query($sql) as $row) {
						$t1 = getMilitaryPositionById($row['id_militaryposition']);
                        echo $t1['name'];
                    }
                  ?>
                </address>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row invoice-info">
              <div class="col-sm-4 invoice-col">
                <strong>Дата рождения</strong>
                <address>
                  <?= DateFromENtoRU(mb_substr($arPerson['birthday'], 0, 10), '-'); ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <strong>Форма допуска</strong>
                <address>
                  <? $t1 = getAccessTypeById($arPerson['id_accesslevel']); print $t1['name']; ?>
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
                  <? $t1 = getCityById($arPerson['id_city']); print $t1['name'] . ', ' . $arPerson['address']; ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <strong>Телефоны</strong>
                <address>
                  <?php
                    $sql = "SELECT * FROM tphone WHERE id_person = '" . $arPerson['id'] . "' ORDER BY id";
                    foreach ($dbconn->query($sql) as $row) {
                        echo $row['name'] . '<br>';
                    }
                  ?>
                </address>
              </div>
              <!-- /.col -->
              <div class="col-sm-4 invoice-col">
                <strong>E-Mail</strong>
                <address>
                  <?php
                    $sql = "SELECT * FROM temail WHERE id_person = '" . $arPerson['id'] . "' ORDER BY id";
                    foreach ($dbconn->query($sql) as $row) {
                        echo $row['name'] . '<br>';
                    }
                  ?>
                </address>
              </div>
              <!-- /.col -->
            </div>
            <!-- /.row -->
            <div class="row invoice-info">
              <div class="col-sm-12 invoice-col">
                <strong>Комментарий</strong>
                <address>
                  <?= $arPerson['comment']; ?>
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
