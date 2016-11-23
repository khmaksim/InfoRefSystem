<?php
    // Пользователь по его ID
    function getInfoById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT *, idate AT TIME ZONE 'Europe/Moscow' AS idate FROM public.info WHERE id = " . intval($id);
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