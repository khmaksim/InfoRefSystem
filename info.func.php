<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getinfoblockbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getuserrolebyid.func.php';

    ConnectDatabase();



                            // Выполним SQL запрос
                            try {
                                $sql = "SELECT *, idate AT TIME ZONE 'Europe/Moscow' AS idate FROM public.info ORDER BY id";
                                foreach ($dbconn->query($sql) as $row) {
                                    $infoblock = getInfoBlockById($row['id']);
                                    $block = (is_array($infoblock) && $infoblock['user_id'] != $_SESSION['user_id']) ? true : false;
                        ?>
                        <tr>
                            <td class="col-md-1"><?= $row['id']; ?></td>
                            <td><?= $row['title']; ?></td>
                            <td><?= mb_substr($row['idate'], 0, 10); ?></td>
                            <td><?= ($row['active']) ? 'Да' : 'Нет'; ?></td>
                            <td><img src="/info/<?= $row['id']; ?>_thumb.<?= $row['img_ext']; ?>" border="0" alt="" class="img-thumbnail" /></td>
                            <?php
                                if ($block == true || getUserRoleById($_SESSION['user_id']) == 2) {
                            ?>
                            <td class="col-md-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-md-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                            <?php
                                } else {
                            ?>
                            <td class="col-md-1 text-center"><a href="/info_edit.php?act=edit&id=<?= $row['id']; ?>" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <td class="col-md-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('<?= $row['id']; ?>');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
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