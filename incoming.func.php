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
                                $sql = "SELECT *, date_in AT TIME ZONE 'Europe/Moscow' AS date_in, out_date AT TIME ZONE 'Europe/Moscow' AS out_date FROM public.incomings ORDER BY code";
                                foreach ($dbconn->query($sql) as $row) {
                        ?>
                        <tr>
                            <td class="col-md-1"><?= $row['number_in']; ?></td>
                            <td><?= DateFromENtoRU(mb_substr($row['date_in'], 0, 10), '-'); ?></td>
                            <td><?= $row['control']; ?></td>
                            <td><?= $row['subject']; ?></td>
                            <td><?= $row['senders_numbers']; ?></td>
                            <td><?= $row['out_where']; ?></td>
                            <td><?= DateFromENtoRU(mb_substr($row['out_date'], 0, 10), '-'); ?></td>
                            <td><?= $row['out_details']; ?></td>
                            <?php
                                if ($row['editable'] == true) {
                            ?>
                            <td class="col-md-1 text-center"><a href="/incoming_edit.php?act=edit&id=<?= $row['code']; ?>" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <!--<td class="col-md-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete('<?= $row['id']; ?>');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>-->
                            <?php
                                } else {
                            ?>
                            <td class="col-md-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                            <!--<td class="col-md-1 text-center"><a class="button btn-default btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>-->
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