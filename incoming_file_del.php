<?php
// Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';

    // --------- OPEN CONN ---

       $conn = pg_connect("host='" . $host . "' dbname='" . $dbname . "' user='" . $username . "' password='" . $passwd . "'");

    // --------- OPEN - INSERT OID ---

       $rs = pg_exec($conn, "SELECT lo FROM attached WHERE code = '" . $_POST['code'] . "';");
       $row = pg_fetch_row($rs, 0);

    // --------- UNLINK OID ---

       pg_exec($conn, "begin");

       $loid = $row[0];
       pg_lounlink($conn, $loid);

       pg_exec ($conn, "commit");

    // --------- DELETE OID ---

       pg_exec($conn, "DELETE FROM attached WHERE code = '" . $_POST['code'] . "';");

    // --------- CLOSE CONN ---

       pg_close();
