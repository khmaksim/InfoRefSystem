<?php
    // Пользователь по его ID
    function getUnitById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT * FROM public.tunit WHERE id = " . intval($id);
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