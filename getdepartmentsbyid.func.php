<?php
    // Роль пользователя по его ID
    function getDepartmentsById($id)
    {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT * FROM public.tdepartments WHERE id = " .   intval($id);
            $res = $dbconn->query($sql);
            // Роль есть
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