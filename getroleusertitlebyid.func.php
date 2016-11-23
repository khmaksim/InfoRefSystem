<?php
    // Пользователь по его ID
    function getRoleUserTitleById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $arUser = array();
            $sql = "SELECT title FROM public.user WHERE role_id = " .   intval($id);
            $res = $dbconn->query($sql);
            // Пользователь есть
            if ($res->rowCount() != 0) {
                foreach ($res as $user) {
                    $arUser[] = $user['title'];
                }
            }
            return $arUser;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }