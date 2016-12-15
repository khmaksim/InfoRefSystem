<?php
    // Права доступа к ПМ по ID пользователя
    function getAccessRightById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT * FROM public.access_right WHERE user_id = " . intval($id);
            $res = $dbconn->query($sql);
            // Права доступа есть есть
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