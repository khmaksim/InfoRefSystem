<?php
    include_once $_SERVER['DOCUMENT_ROOT'] . '/head.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/date.func.php';
    $request = \view\ViewHelper::getRequest();
?>
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
                        <li><a href="./"><i class="glyphicon glyphicon-home"></i> Главная</a></li>
                        <li><a href="/?cmd=Administration">Администрирование</a></li>
                        <li class="active">Пользователи</li>
                    </ol>
                </section>
                <!-- Main content -->
                <section class="content">
                <!-- Your Page Content Here -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header">
                                    <h3 class="box-title">Пользователи<small><i class="fa fa-info-circle"></i> На данной странице происходит администрирование пользователей системы</small></h3>
                                </div><!-- /.box-header -->
                                <div class="box-body">
                                    <table id="example" class="table table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="col-md-1">Номер</th>
                                                <th>Фото</th>
                                                <th>ФИО</th>
                                                <th>Имя</th>
                                                <th>Блокировка</th>
                                                <th>Активен до</th>
                                                <th>Дата рождения</th>
                                                <th class="col-md-1">Редактировать</th>
                                                <th class="col-md-1">Удалить</th>
                                            </tr>
                                        </thead>
                                        <tbody id="items">
                                        <?php
                                            $user_list = $request->getProperty('user_list');
                                            $count = 1;
                                            if (!is_null($user_list)) {
                                                foreach ($user_list as $user) {
                                                    $file_face = '/upload/face/' . $user->id . '.' . $user->img_ext;
                                                    $img_html = "";
                                                    if (file_exists($_SERVER['DOCUMENT_ROOT'] . $file_face)) {
                                                        $img_html = '<img src="' . $file_face . '" border="0" alt="" class="img-responsive" />';
                                                    }
                                                    else
                                                        $img_html = 'Нет';

                                                    echo '<tr>
                                                            <td class="col-md-1">' . $count++ . '</td>
                                                            <td class="col-md-1">' . $img_html . '</td>
                                                            <td>' . $user->name . '</td>
                                                            <td>' . $user->title . '</td>
                                                            <td>' . ($user->active ? 'Нет' : 'Да') . '</td>
                                                            <td>' . DateFromENtoRU(mb_substr($user->adate, 0, 10), '-') . '</td>
                                                            <td>' . DateFromENtoRU(mb_substr($user->bdate, 0, 10), '-') . '</td>';
                                                    echo '<td class="col-md-1 text-center"><a href="/?cmd=EditUser&id=' . $user->id . '" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                                            <td class="col-md-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete(' . $user->id . ');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>';
                                                    // echo '<td class="col-md-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                                                    //         <td class="col-md-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td></tr>';
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>

                                 </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div><!-- /.col -->
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <p class="text-right"><a href="/?cmd=AddUser" type="button" class="btn btn-primary"><span class="glyphicon glyphicon-plus"></span> Добавить</a></p>
                        </div><!-- /.col -->
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
        <script language="JavaScript" type="text/javascript">
        /*<![CDATA[*/
            function ConfirmDelete(id)
            {
                var ObjectId = id;
                if(confirm("Вы действительно хотите удалить запись?")) {
                    document.location = "./?cmd=DeleteUser&id="+ObjectId;
                }
            }
        /*]]>*/
        </script>
    </body>
</html>
