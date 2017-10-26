<?php
    function showDepartmentsNavTree($id = 0) {
        global $dbconn;

        $arActive = getActiveArray(isset($_GET['id']) ? $_GET['id'] : 0);

        $sql = "SELECT * FROM tdepartments WHERE parent = '" . $id . "' ORDER BY id, parent";
        foreach ($dbconn->query($sql) as $row) {
            if (haveChilde($row['id'])) {
                echo '
                    <li class="' . ((in_array($row['id'], $arActive)) ? 'active ' : '') . 'treeview"><a href="/unit.php?id=' . $row['id'] . '"><i class="fa fa-angle-right text-yellow"></i> <span>' . $row['fullname'] . '</span> </a>
                    <ul class="treeview-menu">
                        <li><a href="/unit.php?id=' . $row['id'] . '"><i class="fa fa-circle-o text-red"></i> <span>Штатное расписание</span></a></li>
                        <li><a href="/person.php?id=' . $row['id'] . '"><i class="fa fa-circle-o text-red"></i> <span>Личный состав</span></a></li>
                        <li><a href="/technique.php?id=' . $row['id'] . '"><i class="fa fa-circle-o text-red"></i> <span>Техника</span></a></li>
                ';
                showDepartmentsNavTree($row['id']);
                echo '
                      </ul>
                    </li>

                ';
            } else {
                echo '
                    <li class="' . ((in_array($row['id'], $arActive)) ? 'active ' : '') . 'treeview"><a href="/unit.php?id=' . $row['id'] . '"><i class="fa fa-circle-o text-green"></i> <span>' . $row['fullname'] . '</span></a>
                        <ul class="treeview-menu">
                            <li><a href="/unit.php?id=' . $row['id'] . '"><i class="fa fa-circle-o text-red"></i> <span>Штатное расписание</span></a></li>
                            <li><a href="/person.php?id=' . $row['id'] . '"><i class="fa fa-circle-o text-red"></i> <span>Личный состав</span></a></li>
                            <li><a href="/technique.php?id=' . $row['id'] . '"><i class="fa fa-circle-o text-red"></i> <span>Техника</span></a></li>
                        </ul>
                    </li>
                ';
            }
        }
    }