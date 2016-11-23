<?php
    // Пользователь по его ID
    function getInfoBlockById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT *, blockdate AT TIME ZONE 'Europe/Moscow' AS blockdate FROM public.infoblock WHERE info_id = '" . intval($id) . "'";
            $res = $dbconn->query($sql);
            // Пользователь есть
            if ($res->rowCount() != 0) {
                $res = $res->fetchAll();
                return $res[0];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }