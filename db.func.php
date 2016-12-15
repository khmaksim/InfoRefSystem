<?php
    $host       = '192.168.1.18';
    $port       = 5432;
    $dbname     = 'isys-db';
    $username   = 'postgres';
    $passwd     = '12345';


    function ConnectDatabase()
    {
        global $dbconn;
        global $host;
        global $port;
        global $dbname;
        global $username;
        global $passwd;

        try {
            $dsn        = "pgsql:host=$host;port=$port;dbname=$dbname";
            $dbconn     = new PDO($dsn, $username, $passwd);
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br />";
        }
    }

    function DisconnectDatabase()
    {

    }