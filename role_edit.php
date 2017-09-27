                        <li><a href="/role.php">Роли безопасности</a></li>
                        <li class="active"><?= ($_GET['act'] == 'add') ? 'Добавление' : 'Редактирование'; ?></li>
                    </ol>
                </section>

                <!-- Main content -->
                <section class="content">
                <?php
                    $alertMessage = 'Укажите название роли безопасности!';
                    if ($_GET['act'] == 'edit') {
                        $arRole = getRoleById($_GET['id']);
                    }
                ?>
                <!-- Your Page Content Here -->
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box box-primary">
                                <div class="box-header with-border">
                                    <h3 class="box-title"><?= ($_GET['act'] == 'add') ? 'Добавление' : 'Редактирование'; ?></h3>
                                </div><!-- /.box-header -->
                                <!-- form start -->
                                <form name="role" role="form" action="/save.php" method="post" enctype="multipart/form-data">
                                    <input type="hidden" name="act" value="<?= $_GET['act']; ?>Role" />
                                    <input type="hidden" name="id" value="<?= (isset($_GET['id'])) ? $_GET['id'] : ''; ?>" />
                                    <div class="box-body">
                                        <div class="form-group">
                                            <label for="exampleInputEmail1">Наименование</label>
                                            <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="Наименование роли безопасности"<?= ($_GET['act'] == 'edit') ? ' value="' . $arRole['title'] . '"' : ''; ?> required autofocus>
                                        </div>
                                    </div><!-- /.box-body -->

