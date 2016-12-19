        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Create the tabs -->
            <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
                <li class="active"><a href="#control-sidebar-table-tab" data-toggle="tab"><i class="fa fa-table"></i></a></li>
                <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-book"></i></a></li>
                <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-info"></i></a></li>
            </ul>
            <!-- Tab panes -->
            <div class="tab-content">
                <!-- Table tab content -->
                <div class="tab-pane active" id="control-sidebar-table-tab">
                    <?php
                        // получение прав доступа на ПМ пользователя
                        $arAccessRight = getAccessRightById($_SESSION['user_id']);
                    ?>
                    <ul class="control-sidebar-menu">
                        <?php
                            if ($arAccessRight['admin'] > 0) {
                        ?>
                        <li>
                            <a href="/user.php">
                                <i class="menu-icon fa fa-table bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Пользователи</h4>
                                    <p>Таблица данных</p>
                                </div>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                        <?php
                            if ($arAccessRight['omu'] > 0) {
                        ?>
                        <li>
                            <a href="/departments.php">
                                <i class="menu-icon fa fa-table bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Подразделения</h4>
                                    <p>Таблица данных</p>
                                </div>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                        <?php
                            if ($arAccessRight['incoming'] > 0) {
                        ?>
                        <li>
                            <a href="/incoming.php">
                                <i class="menu-icon fa fa-table bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Учет входящих несекретных документов</h4>
                                    <p>Таблица данных</p>
                                </div>
                            </a>
                        </li>
                        <?php
                            }
                        ?>
                        <?php
                            if ($arAccessRight['telephone'] > 0) {
                        ?>
                        <li>
                            <a href="/phonelist.php">
                                <i class="menu-icon fa fa-table bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Телефонный справочник подразделений</h4>
                                    <p>Представление</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/phonelistperson.php">
                                <i class="menu-icon fa fa-table bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Телефонный справочник людей</h4>
                                    <p>Представление</p>
                                </div>
                            </a>
                        </li>
                         <?php
                            }
                        ?>
                    </ul><!-- /.control-sidebar-menu -->
                </div><!-- /.tab-pane -->
                <!-- Settings tab content -->
                <div class="tab-pane" id="control-sidebar-settings-tab">
                    <ul class="control-sidebar-menu">
                        <?php
                            if ($arAccessRight['admin'] > 0) {
                        ?>
                        <li>
                            <a href="/role.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Роли безопасности</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="/militaryrank.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Воинские звания</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="/militaryposition.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Должности</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="/phonetype.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Типы телефонной связи</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="/phonenumbertype.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Типы телефонных номеров</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="/medaltype.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Типы наград</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="/interpassporttype.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Типы заграничных паспортов</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="/accesstype.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Формы допуска</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="/city.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Города</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="/addresstype.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Типы адресов</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>

                        <li>
                            <a href="/emailtype.php">
                                <i class="menu-icon fa fa-book bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading">Типы email</h4>
                                    <p>Словарь</p>
                                </div>
                            </a>
                        </li>
                         <?php
                            }
                        ?>
                    </ul><!-- /.control-sidebar-menu -->
                </div><!-- /.tab-pane -->
                <!-- Home tab content -->
                <div class="tab-pane" id="control-sidebar-home-tab">
                    <ul class="control-sidebar-menu">
                        <li>
                            <a href="javascript::;">
                                <i class="menu-icon fa fa-thumbs-o-up bg-green"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading"><?= getUserNumLoginById($_SESSION['user_id']); ?></h4>
                                    <p>удачных входов</p>
                                </div>
                            </a>
                        </li>
                    </ul><!-- /.control-sidebar-menu -->

                    <ul class="control-sidebar-menu">
                        <li>
                            <a href="javascript::;">
                                <i class="menu-icon fa fa-thumbs-o-down bg-red"></i>
                                <div class="menu-info">
                                    <h4 class="control-sidebar-subheading"><?= getUserNumLoginById($_SESSION['user_id'], 0); ?></h4>
                                    <p>неудачных входов</p>
                                </div>
                            </a>
                        </li>
                    </ul><!-- /.control-sidebar-menu -->

                    <ul class="control-sidebar-menu">
                        <li>
                            <a href="javascript::;">
                                <i class="menu-icon fa fa-info bg-yellow"></i>
                                <div class="menu-info">
                                    <?= ($date = getUserPrevLoginById($_SESSION['user_id'])) ? '<h4 class="control-sidebar-subheading">' . $date . '</h4><p>последний вход</p>' : '<p>Первый вход в систему</p>'; ?>
                                </div>
                            </a>
                        </li>
                    </ul><!-- /.control-sidebar-menu -->
                </div><!-- /.tab-pane -->

            </div>
        </aside><!-- /.control-sidebar -->