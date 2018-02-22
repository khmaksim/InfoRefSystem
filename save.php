<?php
    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/date.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getusernumloginbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getuserprevloginbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getuserrolebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getroletitlebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getusertitlebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getuserbyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/getrolebyid.func.php';
    include_once $_SERVER['DOCUMENT_ROOT'] . '/resize_image.php';
    // Проверка авторизации
    if ( !AuthUser() )
        header('Location: /login.php');
    ConnectDatabase();

    // Расшариваем переменные
    if (!empty($_GET)) {
        extract($_GET);
    }
    if (!empty($_POST)) {
        extract($_POST);
    }
    // Обработка события
    switch ($act) {
        case 'addRole':  $sql = "INSERT INTO public.role (
                                                    title
                                                )
                                                VALUES (
                                                    '" . $title . "'
                                                )";
                            break;

        case 'editRole': $sql = "UPDATE public.role SET title = '" . $title . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delRole':  $sql = "DELETE FROM public.role WHERE id = '" . $id . "'";
                            break;


        case 'addPerson':
            if (!isset($military)) $military = 'false';
            $sql = "INSERT INTO public.tperson (
                                                    id_departments,
                                                    personalnumber,
                                                    lastname,
                                                    firstname,
                                                    patronymic,
                                                    id_tunit,
                                                    id_accesslevel,
                                                    id_militaryrank,
                                                    military,
                                                    birthday,
                                                    id_city,
                                                    address,
                                                    comment
                                                )
                                                VALUES (
                                                    '" . $id_departments . "',
                                                    '" . $personalnumber . "',
                                                    '" . $lastname . "',
                                                    '" . $firstname . "',
                                                    '" . $patronymic . "',
                                                    '" . $id_tunit . "',
                                                    '" . $id_accesslevel . "',
                                                    '" . $id_militaryrank . "',
                                                    '" . $military . "',
                                                    '" . DateFromRUtoEN($birthday) . "',
                                                    '" . $id_city . "',
                                                    '" . $address . "',
                                                    '" . $comment . "'
                                                ) RETURNING id";
                            break;

        case 'editPerson':
            if (!isset($military)) $military = 'false';
            $sql = "UPDATE public.tperson SET  id_departments = '" . $id_departments . "',
                                                    personalnumber = '" . $personalnumber . "',
                                                    lastname = '" . $lastname . "',
                                                    firstname = '" . $firstname . "',
                                                    patronymic = '" . $patronymic . "',
                                                    id_tunit = '" . $id_tunit . "',
                                                    id_accesslevel = '" . $id_accesslevel . "',
                                                    id_militaryrank = '" . $id_militaryrank . "',
                                                    military = '" . $military . "',
                                                    birthday = '" . DateFromRUtoEN($birthday) . "',
                                                    id_city = '" . $id_city . "',
                                                    address = '" . $address . "',
                                                    comment = '" . $comment . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delPerson':  $sql = "DELETE FROM public.tperson WHERE id = '" . $id . "'";
                            break;


        case 'addInfo':
            if (!isset($active)) $active = 'false'; 
            $sql = "INSERT INTO public.info (
                                                    active,
                                                    title,
                                                    idate,
                                                    user_id
                                                )
                                                VALUES (
                                                    '" . $active . "',
                                                    '" . $title . "',
                                                    '" . DateFromRUtoEN($idate) . " 00:00:00 Europe/Moscow',
                                                    '" . $_SESSION['user_id'] . "'
                                                ) RETURNING id";
                            break;

        case 'editInfo':
          if (!isset($active)) $active = 'false';
          $sql = "UPDATE public.info SET active = '" . $active . "',
          title = '" . $title . "',
          idate = '" . $idate . " 00:00:00 Europe/Moscow'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delInfo':  $sql = "DELETE FROM public.info WHERE id = '" . $id . "'";
                            break;
        case 'addIncoming':
            if ($date_in == '') $date_in = '01-01-1970';
            if ($out_date == '') $out_date = '01-01-1970';
            $sql = "INSERT INTO public.incomings (
                                                  number_in,
                                                  date_in,
                                                  senders_numbers,
                                                  grif,
                                                  sheets,
                                                  subject,
                                                  orders,
                                                  instructions,
                                                  notes,
                                                  control,
                                                  out_where,
                                                  out_details,
                                                  out_date
                                                )
                                                VALUES (
                                                    '" . $number_in . "',
                                                    '" . DateFromRUtoEN($date_in) . " 00:00:00 Europe/Moscow',
                                                    '" . $senders_numbers . "',
                                                    '" . $grif . "',
                                                    '" . $sheets . "',
                                                    '" . $subject . "',
                                                    '" . $orders . "',
                                                    '" . $instructions . "',
                                                    '" . $notes . "',
                                                    '" . $control . "',
                                                    '" . $out_where . "',
                                                    '" . $out_details . "',
                                                    '" . DateFromRUtoEN($out_date) . " 00:00:00 Europe/Moscow'
                                                )";
                            break;

        case 'editIncoming':
            if ($date_in == '') $date_in = '01-01-1970';
            if ($out_date == '') $out_date = '01-01-1970';
            $sql = "UPDATE public.incomings SET number_in = '" . $number_in . "',
                                                                date_in = '" . DateFromRUtoEN($date_in) . " 00:00:00 Europe/Moscow',
                                                                senders_numbers = '" . $senders_numbers . "',
                                                                grif = '" . $grif . "',
                                                                sheets = '" . $sheets . "',
                                                                subject = '" . $subject . "',
                                                                orders = '" . $orders . "',
                                                                instructions = '" . $instructions . "',
                                                                notes = '" . $notes . "',
                                                                control = '" . $control . "',
                                                                out_where = '" . $out_where . "',
                                                                out_details = '" . $out_details . "',
                                                                out_date = '" . DateFromRUtoEN($out_date) . " 00:00:00 Europe/Moscow'
                                                                WHERE
                                                                    code = '" . $code . "'";
            break;
        

        default:    echo '<pre>';
                    print_r($_POST);
                    print_r($_FILES);
                    echo '<br />';
                    echo $sql;
                    echo '<br />';
                    print_r($_GET);
                    print_r($_FILES);
                    echo '</pre>';
                    exit;
    }
    $res = $dbconn->query($sql);

    /*echo '<pre>';
                    print_r($_POST);
                    print_r($_FILES);
                    echo '<br />';
                    echo $sql;
                    echo '<br />';
                    print_r($_GET);
                    print_r($_FILES);
                    echo '</pre>';
                    exit;*/

    // if ($mysqli->errno) {
    //     die('Error (' . $mysqli->errno . ') ' . $mysqli->error . " " . $sql);
    // } else {
        // Если изменения в БД прошли нормально, делаем пост-обновления
        if ($res) {
            switch ($act) {
                                                    // // insert/update access right
                                                    // $sql = "INSERT INTO public.access_right (user_id, admin, omu, kadr, telephone, incoming) 
                                                    //         VALUES (
                                                    //             '" . $user_id . "',
                                                    //             '" . getIntValueAccessRight($adminView, $adminEdit, $adminRemove) . "',
                                                    //             '" . getIntValueAccessRight($omuView, $omuEdit, $omuRemove) . "',
                                                    //             '" . getIntValueAccessRight($kadrView, $kadrEdit, $kadrRemove) . "',
                                                    //             '" . getIntValueAccessRight($telephoneView, $telephoneEdit, $telephoneRemove) . "',
                                                    //             '" . getIntValueAccessRight($incomingView, $incomingEdit, $incomingRemove) . "'
                                                    //         ) 
                                                    //         ON CONFLICT (user_id) 
                                                    //         DO UPDATE SET admin = '" . getIntValueAccessRight($adminView, $adminEdit, $adminRemove) . "', 
                                                    //         omu = '" . getIntValueAccessRight($omuView, $omuEdit, $omuRemove) . "', 
                                                    //         kadr = '" . getIntValueAccessRight($kadrView, $kadrEdit, $kadrRemove) . "', 
                                                    //         telephone = '" . getIntValueAccessRight($telephoneView, $telephoneEdit, $telephoneRemove) . "', 
                                                    //         incoming = '" . getIntValueAccessRight($incomingView, $incomingEdit, $incomingRemove) . "'
                                                    //         ";
                                                    // $res = $dbconn->query($sql);
                                                    // break;
                // Загружаем картинку если она есть
                case 'addPerson': case 'editPerson':    if (isset($id) && $id != '') {
                                                            $person_id = $id;
                                                        } else {
                                                            $res = $res->fetch();
                                                            $person_id = $res['id'];
                                                        }

                                                        if (sizeof($_FILES) && !$_FILES['face']['error']) {
                                                            // если есть старые картинки то удаляем их
                                                            $file_ext = mb_strtolower(mb_substr($_FILES['face']['name'], mb_strpos($_FILES['face']['name'], '.', (mb_strlen($_FILES['face']['name'], 'utf-8') - 4), 'utf-8') + 1, (mb_strlen($_FILES['face']['name'], 'utf-8') - mb_strpos($_FILES['face']['name'], '.', 0, 'utf-8')), 'utf-8'), 'utf-8');
                                                            copy($_FILES['face']['tmp_name'], "./user/" . $person_id . "." . $file_ext);
                                                            resizeImage('user', 100, 100, $person_id, $file_ext, $person_id . '_thumb');

                                                            $dbconn->query("UPDATE public.tperson SET img_ext = '" . $file_ext . "' WHERE id = " . $person_id);
                                                        }
                                                        /**
                                                         *  Очищаем таблицы телефонов и email
                                                         */
                                                        $dbconn->query("DELETE FROM public.tphone WHERE id_person = " . $person_id);
                                                        $dbconn->query("DELETE FROM public.temail WHERE id_person = " . $person_id);

                                                        foreach ($_POST['person-phone'] as $key => $val) {
                                                            $dbconn->query("INSERT INTO public.tphone(id_person, name) VALUES('" . $person_id . "', '" . $val . "')");
                                                        }

                                                        foreach ($_POST['person-email'] as $key => $val) {
                                                            $dbconn->query("INSERT INTO public.temail(id_person, name) VALUES('" . $person_id . "', '" . $val . "')");
                                                        }

                                                    break;
                // Удалем картинку если она есть
                case 'delPerson':        if (file_exists('/user/' . $id . '.' . $photo['file_ext']))
                                                    unlink('../user/' . $id . '.' . $photo['file_ext']);
                                                if (file_exists('../user/' . $id . '_thumb.' . $photo['file_ext']))
                                                    unlink('../user/' . $id . '_thumb.' . $photo['file_ext']);

                                                    /**
                                                         *  Очищаем таблицы телефонов и email
                                                         */
                                                        $dbconn->query("DELETE FROM public.tphone WHERE id_person = " . $person_id);
                                                        $dbconn->query("DELETE FROM public.temail WHERE id_person = " . $person_id);

                                            break;

                // Загружаем картинку если она есть
                case 'addInfo': case 'editInfo':  if (isset($id) && $id != '') {
                                                                        $info_id = $id;
                                                                    } else {
                                                                        $res = $res->fetch();
                                                                        $info_id = $res['id'];
                                                                    }

                                                                    if (sizeof($_FILES) && !$_FILES['info']['error']) {
                                                                        // если есть старые картинки то удаляем их
                                                                        $file_ext = mb_strtolower(mb_substr($_FILES['info']['name'], mb_strpos($_FILES['info']['name'], '.', (mb_strlen($_FILES['info']['name'], 'utf-8') - 4), 'utf-8') + 1, (mb_strlen($_FILES['info']['name'], 'utf-8') - mb_strpos($_FILES['info']['name'], '.', 0, 'utf-8')), 'utf-8'), 'utf-8');
                                                                        copy($_FILES['info']['tmp_name'], "./info/" . $info_id . "." . $file_ext);
                                                                        resizeImage('info', 100, 100, $info_id, $file_ext, $info_id . '_thumb');

                                                                        $dbconn->query("UPDATE public.info SET img_ext = '" . $file_ext . "' WHERE id = " . $info_id);
                                                                    }
                                                    break;
                // Удалем картинку если она есть
                case 'delInfo':        if (file_exists('/info/' . $id . '.' . $photo['file_ext']))
                                                    unlink('../info/' . $id . '.' . $photo['file_ext']);
                                                if (file_exists('../info/' . $id . '_thumb.' . $photo['file_ext']))
                                                    unlink('../info/' . $id . '_thumb.' . $photo['file_ext']);

                                            break;
            }
        }
    // }                                                 

    // Перенаправление в зависимости от действия
    if(preg_match("/pwd/i", $act) && $id == $_SESSION['admin_id']) echo "\n<META http-equiv='REFRESH' content='0; url=./lib/logout.php'>";
    else if(preg_match("/person/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./person.php?id=" . $id_departments . "'>";
    else if(preg_match("/technique/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./technique.php?id=" . $id_departments . "'>";
    else if(preg_match("/unit/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./unit.php?id=" . $id_departments . "'>";
    else if(preg_match("/departments/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./departments.php'>";
    else if(preg_match("/document/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./documents.php'>";
    else if(preg_match("/accesstype/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=accesstype'>";
    else if(preg_match("/interpassporttype/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=interpassporttype'>";
    else if(preg_match("/medaltype/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=medaltype'>";
    else if(preg_match("/phonetype/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=phonetype'>";
    else if(preg_match("/phonenumbertype/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=phonenumbertype'>";
    else if(preg_match("/militaryposition/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=militaryposition'>";
    else if(preg_match("/militaryrank/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=militaryrank'>";
    else if(preg_match("/role/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=role>";
    else if(preg_match("/user/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./user.php'>";
    else if(preg_match("/incoming/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./incoming.php'>";
    else if(preg_match("/city/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=city'>";
    else if(preg_match("/addresstype/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=addresstype'>";
    else if(preg_match("/emailtype/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./dictionary.php?name=emailtype'>";
    else if(preg_match("/info/i", $act)) {
        $dbconn->query("DELETE FROM public.infoblock WHERE user_id = '" . $_SESSION['user_id'] . "' AND info_id = '" . $info_id . "'");
        echo "\n<META http-equiv='REFRESH' content='0; url=/'>";
    }
    else echo "\n<META http-equiv='REFRESH' content='0; url=/'>";

    function getIntValueAccessRight($view, $edit, $remove)
    {
        if ($view == '') {
            $view = '0';
        }
        if ($edit == '') {
            $edit = '0';
        }
        if ($remove == '') {
            $remove = '0';
        }
        return (string)base_convert($view . $edit . $remove, 2, 10);
    }
?>

