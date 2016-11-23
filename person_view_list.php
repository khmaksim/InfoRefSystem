<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'phonelist';
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
                  <i class="fa fa-user"> Телефонный справочник</i>
                  <small class="pull-right">Дата печати: <?= date('d-m-Y'); ?></small>
                </h2>
              </div>
              <!-- /.col -->
            </div>
            <!-- Table row -->
            <div class="row">
              <div class="col-xs-12 table-responsive">
                <table class="table table-striped">
                  <thead>
                  <tr>
                    <th class="col-xs-1">Номер п.п.</th>
                    <th class="col-xs-3">Подразделение</th>
                    <th>ФИО</th>
                    <th>Телефоны</th>
                    <th>E-Mail</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $count = 1;
                    if (!empty($_POST['active'])) {
                    foreach ($_POST['active'] as $key => $val) {
                        $arPerson = getPersonById($val);
                        $arDepartment = getDepartmentsById($arPerson['id_departments']);
                  ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td><?= $arDepartment['fullname']; ?></td>
                    <td><?= $arPerson['lastname'] . ' ' . $arPerson['firstname'] . ' ' . $arPerson['patronymic']; ?></td>
                    <td>
                        <?php
                            $sql = "SELECT * FROM tphone WHERE id_person = '" . $arPerson['id'] . "' ORDER BY id";
                            foreach ($dbconn->query($sql) as $row) {
                                echo $row['name'] . '<br />';
                            }
                          ?>
                    </td>
                    <td>
                        <?php
                            $sql = "SELECT * FROM temail WHERE id_person = '" . $arPerson['id'] . "' ORDER BY id";
                            foreach ($dbconn->query($sql) as $row) {
                                echo $row['name'] . '<br />';
                            }
                          ?>
                    </td>
                  </tr>
                  <?php

                    }
                  }
                  ?>

                  </tbody>
                </table>
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
