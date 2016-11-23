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
  |---------------------------------------------------------|    onload="window.print();"
  -->
    <body >
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
                    <th>ФИО</th>
                    <th>Телефоны</th>
                    <th>E-Mail</th>
                  </tr>
                  </thead>
                  <tbody>
                  <?php
                    $count = 1;
                    $sql = "SELECT * FROM tdepartments WHERE id IN (" . implode(',', $_POST['active']) . ") ORDER BY fullname";
                    foreach ($dbconn->query($sql) as $row) {
                        echo '<tr><td colspan="4" class="success">' . getDepartmentsById($row['id'])['fullname'] . '</td></tr>';
                        $sql_person = "SELECT * FROM tperson WHERE id_departments = " . $row['id'] . " ORDER BY lastname, firstname, patronymic";
                        foreach ($dbconn->query($sql_person) as $row_person) {
                    ?>
                  <tr>
                    <td><?= $count++; ?></td>
                    <td><?= $row_person['lastname'] . ' ' . $row_person['firstname'] . ' ' . $row_person['patronymic']; ?></td>
                    <td>
                        <?php
                            $sql = "SELECT * FROM tphone WHERE id_person = '" . $row_person['id'] . "' ORDER BY id";
                            foreach ($dbconn->query($sql) as $row_phone) {
                                echo $row_phone['name'] . '<br />';
                            }
                          ?>
                    </td>
                    <td>
                        <?php
                            $sql = "SELECT * FROM temail WHERE id_person = '" . $row_person['id'] . "' ORDER BY id";
                            foreach ($dbconn->query($sql) as $row_email) {
                                echo $row_email['name'] . '<br />';
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
