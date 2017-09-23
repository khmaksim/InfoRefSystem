<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/date.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getmilitarypositionbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getaccesstypebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getunitbyid.func.php';

    ConnectDatabase();



                            // Выполним SQL запрос
                            try {
                                $sql = "SELECT * FROM tperson WHERE id_departments = '" . $_GET['id'] . "' ORDER BY id";
                                $number = 0;
                                foreach ($dbconn->query($sql) as $row) {
                        ?>
                        <tr>
                            <td><?= ++$number; ?></td>
                            <td>
                                <?php
                                    if (file_exists('./user/' . $row['id'] . '_thumb.' . $row['img_ext'])) {
                                ?>
                                <img src="/user/<?= $row['id']; ?>_thumb.<?= $row['img_ext']; ?>" border="0" alt="" class="img-circle" />
                                <?php
                                    } else {
                                ?>
                                Нет
                                <?php
                                    }
                                ?>
                            </td>
                            <td><?= $row['personalnumber']; ?></td>
                            <td><?= $row['lastname']; ?> <?= $row['firstname']; ?> <?= $row['patronymic']; ?></td>
                            <td><? $t1 = getAccessTypeById($row['id_accesslevel']); print $t1['name']; ?></td>
                            <td><?= DateFromENtoRU($row['birthday'], '-'); ?></td>
                            <td><? $t1 = getUnitByid($row['id_tunit']); $t2 = getMilitaryPositionById($t1['id_militaryposition']); print $t2['name']; ?></td>
                            <td class="col-xs-1 text-center"><a href="/person_view.php?id=<?= $row['id']; ?>&id_departments=<?= $_GET['id']; ?>" target="_blank" class="button btn-warning btn-sm"><span class="glyphicon glyphicon-print"></span></a></td>
                            <?php
                                if ($row['editable'] == true) {
                            ?>
                            <td class="col-xs-1 text-center"><a href="/person_edit.php?act=edit&id=<?= $row['id']; ?>&id_departments=<?= $_GET['id']; ?>" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-md-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('<?= $row['id']; ?>');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                            <?php
                                } else {
                            ?>
                            <td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-xs-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                            <?php
                                }
                            ?>
                        </tr>
                        <?php
                                }

                            } catch (PDOException $e) {
                                print "Error!: " . $e->getMessage() . "<br />";
                            }
                        ?>