<?php
    if (!isset($_GET['id_departments'])) {
        header('Location: /phonelist.php');
    }

    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'phonelistperson';

    // $arPerson = getPersonById($_GET['id']);
    $arDepartments = getDepartmentsById($_GET['id_departments']);
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
                <section class="content-header">
                    <h1>
                        <small></small>
                    </h1>
                    <ol class="breadcrumb">
                        <li><a href="/departments.php"><i class="glyphicon glyphicon-home"></i> Главная</a></li>
                        <li><a href="/phonelist.php">Телефонный справочник</a></li>
                        <li class="active"><?= $arDepartments['fullname'] ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                    <form action="/person_view_list.php" method="POST" name="View" target="_blank">

                <!-- Your Page Content Here -->
                        <div class="row">
                            <div class="col-xs-12">
                                <p class="text-right">
                                    <a href="javascript:void(0);" onclick="document.View.submit();" type="button" class="btn btn-app"><i class="fa fa-print"></i> Печать</a>
                                </p>
                            </div><!-- /.col -->
                        </div>

                        <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title"><?= $arDepartments['fullname'] ?></h3>
                                </div><!-- /.box-header -->
                                    <div id="data" class="box-body" style="display: none;">
                                        <table id="Person" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="col-md-1 text-center">Печать</th>
                                                    <th>Фото</th>
                                                    <th class="col-md-2 text-center">Подразделение</th>
                                                    <th>Звание</th>
                                                    <th>Фамилия</th>
                                                    <th>Имя</th>
                                                    <th>Отчество</th>
                                                    <th>Телефоны</th>
                                                    <th>E-Mail</th>
                                                    <th>Печать</th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <?php
                                                    $sql = "SELECT * FROM tperson WHERE id_departments = " . $_GET['id_departments'] . " ORDER BY lastname, firstname, patronymic";
                                                    foreach ($dbconn->query($sql) as $arPerson) {
                                                ?>

                                                <tr>
                                                    <td class="text-center"><input type="checkbox" name="active[]" value="<?= $arPerson['id']; ?>" /></td>
                                                    <td>
                                                        <?php
                                                            if (file_exists('./user/' . $arPerson['id'] . '_thumb.' . $arPerson['img_ext'])) {
                                                        ?>
                                                        <img src="/user/<?= $arPerson['id']; ?>_thumb.<?= $arPerson['img_ext']; ?>" border="0" alt="" class="img-circle" />
                                                        <?php
                                                            } else {
                                                        ?>
                                                        Нет
                                                        <?php
                                                            }
                                                        ?>
                                                    </td><td class="col-md-2"><?= getDepartmentsById($arPerson['id_departments'])['shortname']; ?></td>

                                                    <td><?= getMilitaryRankById($arPerson['id_militaryrank'])['name']; ?></td>
                                                    <td><?= $arPerson['lastname']; ?></td>
                                                    <td><?= $arPerson['firstname']; ?></td>
                                                    <td><?= $arPerson['patronymic']; ?></td>
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
                                                    <td class="col-xs-1 text-center"><a href="/person_view.php?id=<?= $arPerson['id']; ?>&id_departments=<?= $arPerson['id_departments']; ?>" target="_blank" class="button btn-warning btn-sm"><span class="glyphicon glyphicon-print"></span></a></td>
                                                </tr>

                                                <?php
                                                    }
                                                ?>

                                            </tbody>

                                        </table>

                                    </div><!-- /.box-body -->
                                    <!-- Loading (remove the following to stop the loading)-->
                                    <div class="overlay">
                                        <i class="fa fa-refresh fa-spin"></i>
                                    </div>
                                    <!-- end loading -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>
                    </form>
                </section><!-- /.content -->
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
        <!-- iCheck -->
        <script src="/plugins/iCheck/icheck.min.js"></script>
        <script src="/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="/plugins/datatables/dataTables.bootstrap.min.js"></script>

        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            $(document).ready(function(){
                $("#items").load("/phonelist.func.php", function( response, status, xhr ) {
                    $('input').iCheck({
                        checkboxClass: 'icheckbox_square-blue',
                        radioClass: 'iradio_square-blue',
                        increaseArea: '20%' // optional
                    });
                });
                // setInterval(function() {$("#items").load("/phonelist.func.php");}, 5000);
                $('input').iCheck({
                    checkboxClass: 'icheckbox_square-blue',
                    radioClass: 'iradio_square-blue',
                    increaseArea: '20%' // optional
                });

                var table = $('#Person').DataTable({
                        'language': {
                            'url': '/dist/Russian.json'
                        }
                });

                $('#data').show();
                $('.overlay').hide();

            });
        /*]]>*/
        </script>
    </body>
</html>
