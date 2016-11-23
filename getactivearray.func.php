<?php
    // Роль пользователя по его ID
    function getActiveArray($id)
    {
        global $dbconn;
        $arReturn = array($id);

        // Выполним SQL запрос
        try {
            do {
                $res = $dbconn->query("SELECT parent FROM public.tdepartments WHERE id = '" . intval($id) . "' AND parent != '0'");
                $row = $res->fetchAll();
                $arReturn[] = $row[0]['parent'];
                $id = $row[0]['parent'];
            }
            while ($res->rowCount() != 0);
            return $arReturn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }