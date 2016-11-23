<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/date.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getroletitlebyid.func.php';

    ConnectDatabase();



                            // Выполним SQL запрос
                            try {
                                $sql = "SELECT *, bdate AT TIME ZONE 'Europe/Moscow' AS bdate, adate AT TIME ZONE 'Europe/Moscow' AS adate FROM public.user ORDER BY id";
                                $number = 0;
                                foreach ($dbconn->query($sql) as $row) {
                        ?>
                        <tr>
                            <td class="col-md-1"><?= ++$number; ?></td>
                            <td>
                                <?php
                                    if (file_exists('./face/' . $row['id'] . '_thumb.' . $row['img_ext'])) {
                                ?>
                                <img src="/face/<?= $row['id']; ?>_thumb.<?= $row['img_ext']; ?>" border="0" alt="" class="img-circle" />
                                <?php
                                    } else {
                                ?>
                                Нет
                                <?php
                                    }
                                ?>
                            </td>
                            <td><?= $row['title']; ?><br />(<?= getRoleTitleById($row['role_id']); ?>)</td>
                            <td><?= $row['name']; ?></td>
                            <td><?= ($row['active']) ? 'Нет' : 'Да'; ?></td>
                            <td><?= DateFromENtoRU(mb_substr($row['adate'], 0, 10), '-'); ?></td>
                            <td><?= DateFromENtoRU(mb_substr($row['bdate'], 0, 10), '-'); ?></td>
                            <?php
                                if ($row['editable'] == true) {
                            ?>
                            <td class="col-md-1 text-center"><a href="/user_edit.php?act=edit&id=<?= $row['id']; ?>" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-md-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('<?= $row['id']; ?>');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                            <?php
                                } else {
                            ?>
                            <td class="col-md-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-md-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
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