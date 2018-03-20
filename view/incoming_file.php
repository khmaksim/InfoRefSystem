<?php
    // Функции БД и настройки соединения
  include_once $_SERVER['DOCUMENT_ROOT'] . '/sys/core/init.inc.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';

    // --------- OPEN CONN ---

       $conn = pg_connect("host='" . $host . "' dbname='" . $dbname . "' user='" . $username . "' password='" . $passwd . "'");

    // --------- OPEN FILE ---

       $fp = fopen('logo.gif', "r");
       $buffer = fread($fp, filesize('logo.gif'));
       fclose($fp);

    // --------- CREATE - INSERT OID ---

       pg_exec($conn, "begin");

       $oid = pg_locreate($conn);

       $rs = pg_exec($conn,"INSERT INTO test(tipo, images) VALUES('A1', $oid);");
       $handle = pg_loopen ($conn, $oid, "w");

       pg_lowrite ($handle, $buffer);
       pg_loclose ($handle);

       pg_exec($conn, "commit");

    // --------- OPEN - INSERT OID ---

       $rs = pg_exec($conn, "SELECT images FROM test WHERE tipo = 'A1';");
       $row = pg_fetch_row($rs, 0);

       pg_exec($conn, "begin");
       $loid = pg_loopen($conn, $row[0], "r");

       header("Content-type: image/gif");

       pg_loreadall($loid);
       pg_loclose($loid);

       pg_exec ($conn, "commit");

    // --------- UNLINK OID ---

       pg_exec($conn, "begin");

       $loid = $row[0];
       pg_lounlink($conn, $loid);

       pg_exec ($conn, "commit");

    // --------- DELETE OID ---

    //   pg_exec($conn, "DELETE FROM test WHERE tipo = 'A1';");

    // --------- CLOSE CONN ---

   pg_close();
