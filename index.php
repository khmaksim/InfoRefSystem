<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $page = 'index';
    $arUser = getUserById($_SESSION['user_id']);
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
            <div class="fixed content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1>
                        <small></small>
                    </h1>
                </section>
                <!-- Main content -->
                <section class="content">
                    <?php
                        // получение прав доступа на ПМ пользователя
                        $arAccessRight = getAccessRightById($_SESSION['user_id']);
                    ?>
                    <div class="row">
                        <div class="col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="/secrecy.php">
                                        <h4 class="text-center">Режим секретности</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="{% url 'research-activities' %}">
                                        <h4 class="text-center">Шифровальная работа</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="#">
                                        <h4 class="text-center">Кадровая работа</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                             <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="{% url 'research-activities' %}">
                                        <h4 class="text-center">Защита информации от НСД</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="{% url 'research-activities' %}">
                                        <h4 class="text-center">Техническая защита информации</h4>
                                    </a>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="{% url 'research-activities' %}">
                                        <h4 class="text-center">Научно-исследовательская работа</h4>
                                    </a>
                                </div>
                            </div>
                            <?php
                                if ($arAccessRight['admin'] == 7) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="/administration.php">
                                        <h4 class="text-center">Администрирование</h4>
                                    </a>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                        <div class="col-lg-4">
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="/documents.php">
                                        <h4 class="text-center">Руководящие документы</h4>
                                    </a>
                                </div>
                            </div>
                            <?php
                                if ($arAccessRight['telephone'] > 0) {
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="/phonelist.php">
                                        <h4 class="text-center">Телефонный справочник</h4>
                                    </a>
                                </div>
                            </div>
                            <?php 
                                } 
                            ?>
                            <div class="panel panel-default">
                                <div class="panel-body">
                                    <a href="/structure.php">
                                        <h4 class="text-center">Cтруктура ЧНП ВКС</h4>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
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
    </body>
</html>
