<?php

    
    define("SERVER_NAME","localhost");
    define("USERNAME","root");
    define("DB_PASSWORD","usbw");
    define("DATABASE_NAME","userdb_32702");


    $con = new mysqli(SERVER_NAME, USERNAME, DB_PASSWORD, DATABASE_NAME);


    if(!$con){
        echo "<h1>Error Connecting to the database</h1>";
        die();
    }
?>