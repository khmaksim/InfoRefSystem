<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();

    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';

    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getusertitlebyid.func.php';

    ConnectDatabase();
    
    // Выполним SQL запрос
    try {
        $res = getDocuments();
        $count = 1;
        if ($res) {
            foreach ($res as $row) {
                echo '
                    <tr>
                        <td>'. $count++ .'</td>
                        <td><a href="download.php?file=' . $row['file_name'] . '" target="_blank">' . $row['name'] . '</a></td>
                        <td>' . $row['section'] . '</td>
                        <td class="col-xs-1 text-center"><a href="/documents_edit.php?act=edit&id=' . $row['id'] . '" class="button btn-success btn-sm"><span class="glyphicon glyphicon-pencil"></span></a></td>
                        <td class="col-xs-1 text-center"><a href="javascript:void(0);" onclick="ConfirmDelete(' . $row['id'] . ');" class="button btn-danger btn-sm"><span class="glyphicon glyphicon-remove"></span></a></td>
                    </tr>'
                    ;
            }
        }
    }   catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br />";
    }