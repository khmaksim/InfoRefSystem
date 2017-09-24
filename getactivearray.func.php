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
                $arReturn[] = isset($row[0]['parent']) ? $row[0]['parent'] : 0;
                $id = isset($row[0]['parent']) ? $row[0]['parent'] : 0;
            }
            while ($res->rowCount() != 0);
            return $arReturn;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }