<?php
    // Роль пользователя по его ID
    function getUserTitleById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT title FROM public.user WHERE id = " .   intval($id);
            $res = $dbconn->query($sql);
            // Пользователь есть
            if ($res->rowCount() != 0) {
                $res = $res->fetchAll();
                return $res[0]['title'];
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }