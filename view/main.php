<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    $request = \view\ViewHelper::getRequest();
?>
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
                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=Secrecy"><h4 class="text-center">Режим секретности</h4></a>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=EncryptionWork"><h4 class="text-center">Шифровальная работа</h4></a>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=PersonnelWork"><h4 class="text-center">Кадровая работа</h4></a>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=IncomingDocument"><h4 class="text-center">Документооборот</h4></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=ProtectionInformation"><h4 class="text-center">Защита информации от НСД</h4></a>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=TechnicalProtectedInformation"><h4 class="text-center">Техническая защита информации</h4></a>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=ResearchWork"><h4 class="text-center">Научно-исследовательская работа</h4></a>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=Administration"><h4 class="text-center">Администрирование</h4></a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=Document"><h4 class="text-center">Руководящие документы</h4></a>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=TelephoneDirectory"><h4 class="text-center">Телефонный справочник</h4></a>
                            </div>
                        </div>
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <a href="/?cmd=Structure"><h4 class="text-center">Cтруктура ЧНП ВКС</h4></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section><!-- /.content -->
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
    </body>
</html>
