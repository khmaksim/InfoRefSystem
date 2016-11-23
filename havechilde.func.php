<?php
    function haveChilde($id) {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT * FROM tdepartments WHERE parent = '" . $id . "'";
            $res = $dbconn->query($sql);
            // Роль есть
            if ($res->rowCount() != 0) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }


