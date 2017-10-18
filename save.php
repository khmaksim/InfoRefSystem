<?php
    header('Content-type: text/html; charset=utf-8');
    // Запуск механизма сессий
    session_start();
    // Механизм авторизации
    include_once $_SERVER['DOCUMENT_ROOT'] . '/lib/auth.php';
    // Функции БД и настройки соединения
    include_once $_SERVER['DOCUMENT_ROOT'] . '/db.func.php';
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

        case 'addAccesstype':  $sql = "INSERT INTO public.taccesstype (
                                                    name
                                                )
                                                VALUES (
                                                    '" . $name . "'
                                                )";
                            break;

        case 'editAccesstype': $sql = "UPDATE public.taccesstype SET name = '" . $name . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delAccesstype':  $sql = "DELETE FROM public.taccesstype WHERE id = '" . $id . "'";
                            break;

        case 'addMilitaryrank':  $sql = "INSERT INTO public.tmilitaryrank (
                                                    name
                                                )
                                                VALUES (
                                                    '" . $name . "'
                                                )";
                            break;

        case 'editMilitaryrank': $sql = "UPDATE public.tmilitaryrank SET name = '" . $name . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delMilitaryrank':  $sql = "DELETE FROM public.tmilitaryrank WHERE id = '" . $id . "'";
                            break;

        case 'addMilitaryposition':  $sql = "INSERT INTO public.tmilitaryposition (
                                                    name
                                                )
                                                VALUES (
                                                    '" . $name . "'
                                                )";
                            break;

        case 'editMilitaryposition': $sql = "UPDATE public.tmilitaryposition SET name = '" . $name . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delMilitaryposition':  $sql = "DELETE FROM public.tmilitaryposition WHERE id = '" . $id . "'";
                            break;

        case 'addPhonetype':  $sql = "INSERT INTO public.tphonetype (
                                                    name
                                                )
                                                VALUES (
                                                    '" . $name . "'
                                                )";
                            break;

        case 'editPhonetype': $sql = "UPDATE public.tphonetype SET name = '" . $name . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delPhonetype':  $sql = "DELETE FROM public.tphonetype WHERE id = '" . $id . "'";
                            break;

        case 'addAddresstype':  $sql = "INSERT INTO public.taddresstype (
                                                    name
                                                )
                                                VALUES (
                                                    '" . $name . "'
                                                )";
                            break;

        case 'editAddresstype': $sql = "UPDATE public.taddresstype SET name = '" . $name . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delAddresstype':  $sql = "DELETE FROM public.taddresstype WHERE id = '" . $id . "'";
                            break;

        case 'addEmailtype':  $sql = "INSERT INTO public.temailtype (
                                                    name
                                                )
                                                VALUES (
                                                    '" . $name . "'
                                                )";
                            break;

        case 'editEmailtype': $sql = "UPDATE public.temailtype SET name = '" . $name . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delEmailtype':  $sql = "DELETE FROM public.temailtype WHERE id = '" . $id . "'";
                            break;

        case 'addPhoneNumbertype':  $sql = "INSERT INTO public.tphonenumbertype (
                                                    name
                                                )
                                                VALUES (
                                                    '" . $name . "'
                                                )";
                            break;

        case 'editPhoneNumbertype': $sql = "UPDATE public.tphonenumbertype SET name = '" . $name . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delPhoneNumbertype':  $sql = "DELETE FROM public.tphonenumbertype WHERE id = '" . $id . "'";
                            break;

        case 'addCity':  $sql = "INSERT INTO public.tcity (
                                                    name
                                                )
                                                VALUES (
                                                    '" . $name . "'
                                                )";
                            break;

        case 'editCity': 
            $sql = "UPDATE public.tcity SET name = '" . $name . "' WHERE id = '" . $id . "'";
            break;
        case 'delCity':  
            $sql = "DELETE FROM public.tcity WHERE id = '" . $id . "'";
            break;
        case 'addMedaltype':  
            $sql = "INSERT INTO public.tmedaltype (name) VALUES ('" . $name . "')";
            break;

        case 'editMedaltype': $sql = "UPDATE public.tmedaltype SET name = '" . $name . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delMedaltype':  $sql = "DELETE FROM public.tmedaltype WHERE id = '" . $id . "'";
                            break;

        case 'addInterpassporttype':  $sql = "INSERT INTO public.tinterpassporttype (
                                                    name
                                                )
                                                VALUES (
                                                    '" . $name . "'
                                                )";
                            break;

        case 'editInterpassporttype': $sql = "UPDATE public.tinterpassporttype SET name = '" . $name . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delInterpassporttype':  $sql = "DELETE FROM public.tinterpassporttype WHERE id = '" . $id . "'";
                            break;

        case 'addDepartments':
            if (!isset($active)) $active = 'false';
            $sql = "INSERT INTO public.tdepartments (
                                                    fullname,
                                                    shortname,
                                                    dep_index,
                                                    server_addr,
                                                    note,
                                                    parent,
                                                    active
                                                )
                                                VALUES (
                                                    '" . $fullname . "',
                                                    '" . $shortname . "',
                                                    '" . $dep_index . "',
                                                    '" . $server_addr . "',
                                                    '" . $note . "',
                                                    '" . $parent . "',
                                                    '" . $active . "'
                                                )";
                            break;

        case 'editDepartments':
            if (!isset($active)) $active = 'false';
            $sql = "UPDATE public.tdepartments SET  fullname = '" . $fullname . "',
                                                    shortname = '" . $shortname . "',
                                                    dep_index = '" . $dep_index . "',
                                                    server_addr = '" . $server_addr . "',
                                                    note = '" . $note . "',
                                                    parent = '" . $parent . "',
                                                    active = '" . $active . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delDepartments':  $sql = "DELETE FROM public.tdepartments WHERE id = '" . $id . "'";
                            break;

        case 'addUnit':
            if (!isset($vacant)) $vacant = 'false';
            if ($dateorderend == '') $dateorderend = '01-01-1970';
            $sql = "INSERT INTO public.tunit (
                                                    id_departments,
                                                    id_militaryposition,
                                                    tariffcategory,
                                                    id_militaryrank,
                                                    id_accesslevel,
                                                    ordernumber,
                                                    orderowner,
                                                    dateorderstart,
                                                    dateorderend,
                                                    vacant
                                                )
                                                VALUES (
                                                    '" . $id_departments . "',
                                                    '" . $id_militaryposition . "',
                                                    '" . $tariffcategory . "',
                                                    '" . $id_militaryrank . "',
                                                    '" . $id_accesslevel . "',
                                                    '" . $ordernumber . "',
                                                    '" . $orderowner . "',
                                                    '" . DateFromRUtoEN($dateorderstart) . "',
                                                    '" . DateFromRUtoEN($dateorderend) . "',
                                                    '" . $vacant . "'
                                                )";
                            break;

        case 'editUnit':
            if (!isset($vacant)) $vacant = 'false';
            if ($dateorderend == '') $dateorderend = '01-01-1970';
            $sql = "UPDATE public.tunit SET  id_departments = '" . $id_departments . "',
                                                    id_militaryposition = '" . $id_militaryposition . "',
                                                    tariffcategory = '" . $tariffcategory . "',
                                                    id_militaryrank = '" . $id_militaryrank . "',
                                                    id_accesslevel = '" . $id_accesslevel . "',
                                                    ordernumber = '" . $ordernumber . "',
                                                    orderowner = '" . $orderowner . "',
                                                    dateorderstart = '" . DateFromRUtoEN($dateorderstart) . "',
                                                    dateorderend = '" . DateFromRUtoEN($dateorderend) . "',
                                                    vacant = '" . $vacant . "'
                                                                WHERE
                                                                    id = '" . $id . "'";
                            break;

        case 'delUnit':  $sql = "DELETE FROM public.tunit WHERE id = '" . $id . "'";
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


        case 'addUser':  
                           $sql = "INSERT INTO public.user (
                                    active,
                                    title,
                                    bdate,
                                    adate,
                                    name,
                                    passwd
                                                )
                                                VALUES (
                                                    '" . $active . "',
                                                    '" . $title . "',
                                                    '" . DateFromRUtoEN($bdate) . " 00:00:00 Europe/Moscow',
                                                    '" . DateFromRUtoEN($adate) . " 00:00:00 Europe/Moscow',
                                                    '" . $name . "',
                                                    '" . md5($passwd) . "'
                                                ) RETURNING id";
                            break;

        case 'editUser':
            if (!isset($active)) $active = 'false';
            $sql = "UPDATE public.user SET active = '" . $active . "',
                                                            title = '" . $title . "',
                                                            bdate = '" . DateFromRUtoEN($bdate) . " 00:00:00 Europe/Moscow',
                                                            adate = '" . DateFromRUtoEN($adate) . " 00:00:00 Europe/Moscow',
                                                            name = '" . $name . "'" . (($passwd != '') ? ", 
                                                            passwd = '" . md5($passwd) . "' " : '') . "
                                                            WHERE id = '" . $id . "'";
                            break;

        case 'delUser':  $sql = "DELETE FROM public.user WHERE id = '" . $id . "'";
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
        case 'addDocument':
            $sql = "INSERT INTO public.document (name, section) VALUES ('" . $name . "', '" . $section . "') RETURNING id";
            break;
        case 'editDocument':
            $sql = "UPDATE public.document SET name = '" . $name . "', section = '" . $section . "' WHERE id = '" . $id . "'";
            break;
        case 'delDocument':  $sql = "DELETE FROM public.document WHERE id = '" . $id . "'";
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
                // Загружаем картинку если она есть
                case 'addUser': case 'editUser':  
                    if (isset($id) && $id != '') {
                        $user_id = $id;
                    } else {
                        $res = $res->fetch();
                        $user_id = $res['id'];
                    }
                    if (sizeof($_FILES) && !$_FILES['face']['error']) {
                                                                        // если есть старые картинки то удаляем их
                                                                        $file_ext = mb_strtolower(mb_substr($_FILES['face']['name'], mb_strpos($_FILES['face']['name'], '.', (mb_strlen($_FILES['face']['name'], 'utf-8') - 4), 'utf-8') + 1, (mb_strlen($_FILES['face']['name'], 'utf-8') - mb_strpos($_FILES['face']['name'], '.', 0, 'utf-8')), 'utf-8'), 'utf-8');
                                                                        copy($_FILES['face']['tmp_name'], "./face/" . $user_id . "." . $file_ext);
                                                                        resizeImage('face', 100, 100, $user_id, $file_ext, $user_id . '_thumb');

                                                                        $dbconn->query("UPDATE public.user SET img_ext = '" . $file_ext . "' WHERE id = " . $user_id);
                                                                    }
                                                    // insert/update access right
                                                    $sql = "INSERT INTO public.access_right (user_id, admin, omu, kadr, telephone, incoming) 
                                                            VALUES (
                                                                '" . $user_id . "',
                                                                '" . getIntValueAccessRight($adminView, $adminEdit, $adminRemove) . "',
                                                                '" . getIntValueAccessRight($omuView, $omuEdit, $omuRemove) . "',
                                                                '" . getIntValueAccessRight($kadrView, $kadrEdit, $kadrRemove) . "',
                                                                '" . getIntValueAccessRight($telephoneView, $telephoneEdit, $telephoneRemove) . "',
                                                                '" . getIntValueAccessRight($incomingView, $incomingEdit, $incomingRemove) . "'
                                                            ) 
                                                            ON CONFLICT (user_id) 
                                                            DO UPDATE SET admin = '" . getIntValueAccessRight($adminView, $adminEdit, $adminRemove) . "', 
                                                            omu = '" . getIntValueAccessRight($omuView, $omuEdit, $omuRemove) . "', 
                                                            kadr = '" . getIntValueAccessRight($kadrView, $kadrEdit, $kadrRemove) . "', 
                                                            telephone = '" . getIntValueAccessRight($telephoneView, $telephoneEdit, $telephoneRemove) . "', 
                                                            incoming = '" . getIntValueAccessRight($incomingView, $incomingEdit, $incomingRemove) . "'
                                                            ";
                                                    $res = $dbconn->query($sql);
                                                    if ($mysqli->errno) {
                                                        die('Error (' . $mysqli->errno . ') ' . $mysqli->error . " " . $sql);
                                                    } 
                                                    break;
                // Удалем картинку если она есть
                case 'delUser':        if (file_exists('/face/' . $id . '.' . $photo['file_ext']))
                                                    unlink('../face/' . $id . '.' . $photo['file_ext']);
                                                if (file_exists('../face/' . $id . '_thumb.' . $photo['file_ext']))
                                                    unlink('../face/' . $id . '_thumb.' . $photo['file_ext']);
                                        $sql = "DELETE FROM public.access_right WHERE user_id = '" . $id . "'";
                                        $res = $dbconn->query($sql);
                                        if ($mysqli->errno) {
                                            die('Error (' . $mysqli->errno . ') ' . $mysqli->error . " " . $sql);
                                        }
                                        break;
                 case 'addDocument': 
                 case 'editDocument':  
                    if (isset($id) && $id != '') {
                        $document_id = $id;
                    } else {
                        $res = $res->fetch();
                        $document_id = $res['id'];
                    }
                    if (sizeof($_FILES) && !$_FILES['document-file']['error'] && $_FILES['document-file']['size'] < 1024 * 2 * 1024) {
                        $uploadInfo = $_FILES['document-file'];
                        $fileName = $_SERVER['DOCUMENT_ROOT'] . 'documents/' . $document_id;
                        switch ($uploadInfo['type']) {
                            case 'image/jpeg':
                                $fileName .= '.jpg';
                                break;
                            case 'image/png':
                                $fileName .= '.png';
                                break;
                            case 'application/msword':
                                $fileName .= '.doc';
                                break;
                            case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                                $fileName .= '.docx';
                                break;
                            case 'application/pdf':
                                $fileName .= '.pdf';
                                break;
                            default:
                                exit;
                        }
                        $fileName = iconv('utf-8', 'windows-1251', $fileName);
                        if (!move_uploaded_file($uploadInfo['tmp_name'], $fileName)) {
                            echo 'Не удалось осуществить сохранение файла';
                        }
                        $dbconn->query("UPDATE public.document SET file_name = '" . $fileName . "' WHERE id = " . $document_id);
                    }
                    break;
                // Удалем документ если он есть
                case 'delDocument':        
                    if (file_exists('/documents/' . $section . '/' . $id . '_' . $name . '.' . $photo['file_ext']))
                        unlink('/documents/' . $section . '/' . $id . '_' . $name . '.' . $photo['file_ext']);
                    if (file_exists('../documents/' . $section . '/' . $id . '_' . $name . '.' . $photo['file_ext']))
                        unlink('../documents/' . $section . '/' . $id . '_' . $name . '.' . $photo['file_ext']);
                    break;
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
    // else if(preg_match("/document/i", $act)) echo "\n<META http-equiv='REFRESH' content='0; url=./documents.php'>";
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
    // else echo "\n<META http-equiv='REFRESH' content='0; url=/'>";

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

