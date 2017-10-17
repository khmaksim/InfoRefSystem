<?php
    // Роль пользователя по его ID
    function getUserTitleById($id) {
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
    function getDocumentById($id) {
        global $dbconn;
        // Выполним SQL запрос
        try {
            $sql = "SELECT name, section FROM public.document WHERE id = " . intval($id);
            $res = $dbconn->query($sql);
            // Документ есть
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
    function getDocuments($section = "") {
        global $dbconn;

        try {
            $sql = "SELECT * FROM document WHERE section LIKE '%" . $section . "%' ORDER BY name";
            $res = $dbconn->query($sql);
            if ($res->rowCount() != 0) {
                $res = $res->fetchAll();
                return $res;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }