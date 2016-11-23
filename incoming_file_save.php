<?php
/*     $the_file = '';
    //Если пользователь выбрал файл для отправки
    if (!empty($_FILES['file']['tmp_name'])) {
        // Закачиваем файл
        $path = $_FILES['file']['name'];
        if (copy($_FILES['file']['tmp_name'], $path)) {
            $the_file = $path;
        }
    }*/


    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';

    // --------- OPEN CONN ---

       $conn = pg_connect("host='" . $host . "' dbname='" . $dbname . "' user='" . $username . "' password='" . $passwd . "'");

    // --------- OPEN FILE ---

       $fp = fopen($_FILES['file']['tmp_name'], "r");
       $buffer = fread($fp, filesize($_FILES['file']['tmp_name']));
       fclose($fp);

    // --------- CREATE - INSERT OID ---

       pg_exec($conn, "begin");

       $oid = pg_locreate($conn);

       $rs = pg_exec($conn,"INSERT INTO attached(incoming, lo, filename, mime) VALUES('" . $_POST['incoming'] . "', $oid, '" . $_FILES['file']['name'] . "', '" . mime_content_type($_FILES['file']['tmp_name']) . "')");
       $handle = pg_loopen ($conn, $oid, "w");

       pg_lowrite ($handle, $buffer);
       pg_loclose ($handle);

       pg_exec($conn, "commit");

    // --------- CLOSE CONN ---

       pg_close();
