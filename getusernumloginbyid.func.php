<?php
    // ID пользователя по его имени
    function getUserNumLoginById($id, $success = 1)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT user_id FROM public.user_login WHERE user_id = " .   intval($id)  . " AND success = '" . $success . "'";
            $res = $dbconn->query($sql);
            return $res->rowCount();
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }