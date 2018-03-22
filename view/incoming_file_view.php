<?php
    // --------- OPEN - INSERT OID ---

       $rs = pg_exec($conn, "SELECT lo, mime, filename FROM attached WHERE code = '" . $_GET['code'] . "';");
       $row = pg_fetch_row($rs, 0);

       pg_exec($conn, "begin");
       $loid = pg_loopen($conn, $row[0], "r");

       header("Content-type: " . $row[1]);
       header('Content-Disposition: inline; filename=' . $row[2]);

       pg_loreadall($loid);
       pg_loclose($loid);

       pg_exec ($conn, "commit");
