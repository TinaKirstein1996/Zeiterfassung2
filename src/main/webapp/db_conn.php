<?php

$dbhost="localhost:3307";
$dbuser="root";
$dbpass="";
$dbname="time_tracking";

$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname);

if (!$connect) {
    
    echo "Verbindung fehlgeschlagen!";
    
}

