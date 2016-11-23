<?php
    // ID пользователя по его имени
    function getUserPrevLoginById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT ldate AT TIME ZONE 'Europe/Moscow' AS ldate FROM public.user_login WHERE user_id = " .   intval($id)  . " AND success = '1' ORDER BY ldate DESC LIMIT 1 OFFSET 1";
            $res = $dbconn->query($sql);
            // Пользователь входит не первый раз
            if ($res->rowCount() != 0) {
                $res = $res->fetchAll();
                return $res[0]['ldate'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }