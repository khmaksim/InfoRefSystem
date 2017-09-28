<?php
    // Пользователь по его ID
    function getTechniqueById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT * FROM public.ttechnique WHERE id = " . intval($id);
            $res = $dbconn->query($sql);
            // Техника есть
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