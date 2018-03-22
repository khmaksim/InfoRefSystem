<?php

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

