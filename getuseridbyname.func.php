<?php
    // ID пользователя по его имени
    function getUserIdByName($name)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT id FROM public.user WHERE name LIKE '" . $name . "'";
            $res = $dbconn->query($sql);
            // Пользователь с таким именем есть
            if ($res->rowCount() != 0) {
                $res = $res->fetchAll();
                return $res[0]['id'];
            // Такого пользователя нет
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }