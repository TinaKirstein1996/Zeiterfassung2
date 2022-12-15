<?php

$dbhost="rdbms.strato.de";
$dbuser="dbu433728";
$dbpass="projektarbeit";
$dbname="dbs9413900";

$connect = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

if (mysqli_connect_error()){
    die('Connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
} else {
    $where_sql = '';
    if(!empty($_GET['start_time']) && !empty($_GET['end_time'])){
        $where_sql .= " WHERE date = '"$_GET['date']."'  ";
    }
    
    $sql = "SELECT * FROM tracked_time $where_sql";
    $result = $connect->query($sql);
    
    $eventsArr = array();
    if($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            array_push($eventsArr, $row);
        }
    }
    
    echo json_encode($eventsArr);
}