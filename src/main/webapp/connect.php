<?php
$dbhost="rdbms.strato.de";
$dbuser="dbu433728";
$dbpass="projektarbeit";
$dbname="dbs9413900";

$connect = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if (mysqli_connect_error()){
    die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
}
?>