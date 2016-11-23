<?php
    // Пользователь по его ID
    function getUserById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT *, bdate AT TIME ZONE 'Europe/Moscow' AS bdate, adate AT TIME ZONE 'Europe/Moscow' AS adate FROM public.user WHERE id = " .   intval($id);
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