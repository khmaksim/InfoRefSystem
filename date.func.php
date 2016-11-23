<?php
  function GetMonth ($month)
  {
    switch ($month) {
        case '01': return 'Января'; break;
        case '02': return 'Февраля'; break;
        case '03': return 'Марта'; break;
        case '04': return 'Апреля'; break;
        case '05': return 'Мая'; break;
        case '06': return 'Июня'; break;
        case '07': return 'Июля'; break;
        case '08': return 'Августа'; break;
        case '09': return 'Сентября'; break;
        case '10': return 'Октября'; break;
        case '11': return 'Ноября'; break;
        case '12': return 'Декабря'; break;
    }
  }

  function GetDayOfWeek ($day)
  {
    switch ($day) {
        case '0': return 'Воскресенье'; break;
        case '1': return 'Понедельник'; break;
        case '2': return 'Вторник'; break;
        case '3': return 'Среда'; break;
        case '4': return 'Четверг'; break;
        case '5': return 'Птница'; break;
        case '6': return 'Суббота'; break;
    }
  }

  function GetNewsDate ($date)
  {
    $outdate = '';
    $outdate .= substr($date, 8, 2)." ";
    $outdate .= mb_strtolower(GetMonth(substr($date,5,2)), 'UTF-8')." ";
    $outdate .= substr($date,0,4);
    return $outdate;
  }

  //to RU
  function DateFromENtoRU ($dateEN, $split = ".")
  {
    $dateRU = substr($dateEN, 8, 2) . $split . substr($dateEN, 5, 2) . $split . substr($dateEN, 0, 4);
    return $dateRU;
  }

  function DateFromENtoRUfull ($dateEN, $split = ".")
  {
    $dateRU = substr($dateEN, 8, 2) . $split . substr($dateEN, 5, 2) . $split . substr($dateEN, 0, 4) . ' ' . substr($dateEN, 10);
    return $dateRU;
  }


  //to EN
  function DateFromRUtoEN ($dateRU, $split = "-") {
    $dateEN = substr($dateRU, 6, 4) . $split . substr($dateRU, 3, 2) . $split . substr($dateRU, 0, 2);
    return $dateEN;
  }

  function DateFromRUtoENfull ($dateRU, $split = "-") {
    $dateEN = substr($dateRU, 6, 4) . $split . substr($dateRU, 3, 2) . $split . substr($dateRU, 0, 2) . ' ' . substr($dateRU, 10);
    return $dateEN;
  }

