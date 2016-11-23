<?php
  //запуск механизма сессий
	session_start();
	
	unset ($_SESSION['user_id']);
	unset ($_SESSION['error']);
	
	echo "\n<META http-equiv='REFRESH' content='0; url=/'>";